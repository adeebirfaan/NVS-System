<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AuditLog;
use App\Models\Inquiry;
use App\Models\InquiryStatusHistory;
use App\Models\Notification;
use Illuminate\Http\Request;

class McmcInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mcmc');
    }

    public function index(Request $request)
    {
        $query = Inquiry::with(['user', 'latestStatusHistory', 'currentAssignment.agency']);

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        if ($request->has('agency') && $request->agency !== '') {
            $query->whereHas('currentAssignment', function ($q) use ($request) {
                $q->where('agency_id', $request->agency);
            });
        }

        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('inquiry_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQ) use ($request) {
                      $userQ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $agencies = Agency::active()->get();

        return view('mcmc.inquiries.index', compact('inquiries', 'agencies'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['user', 'evidences', 'statusHistories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'currentAssignment.agency', 'assignments.agency']);

        return view('mcmc.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Inquiry::STATUSES),
            'notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $inquiry->status;
        
        $inquiry->update([
            'status' => $validated['status'],
            'mcmc_notes' => $validated['notes'] ?? $inquiry->mcmc_notes,
        ]);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $oldStatus,
            'to_status' => $validated['status'],
            'notes' => $validated['notes'] ?? 'Status updated by MCMC',
            'officer_name' => auth()->user()->name,
            'officer_id' => auth()->id(),
        ]);

        AuditLog::logStatusChange(
            auth()->id(),
            $inquiry,
            $oldStatus,
            $validated['status'],
            $validated['notes'] ?? null,
            $request->ip()
        );

        if (in_array($validated['status'], [Inquiry::STATUS_VERIFIED_TRUE, Inquiry::STATUS_IDENTIFIED_FAKE, Inquiry::STATUS_REJECTED])) {
            Notification::createForUser(
                $inquiry->user_id,
                Notification::TYPE_INQUIRY_COMPLETED,
                'Inquiry Status Updated',
                "Your inquiry #{$inquiry->inquiry_number} has been {$validated['status']}.",
                ['inquiry_id' => $inquiry->id, 'status' => $validated['status']]
            );
        } else {
            Notification::createForUser(
                $inquiry->user_id,
                Notification::TYPE_STATUS_UPDATED,
                'Inquiry Status Updated',
                "Your inquiry #{$inquiry->inquiry_number} status has been updated to " . str_replace('_', ' ', $validated['status']),
                ['inquiry_id' => $inquiry->id, 'status' => $validated['status']]
            );
        }

        return redirect()->route('mcmc.inquiries.show', $inquiry)->with('success', 'Inquiry status updated successfully.');
    }

    public function assign(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $agency = Agency::findOrFail($validated['agency_id']);

        $assignment = \App\Models\AgencyAssignment::create([
            'inquiry_id' => $inquiry->id,
            'agency_id' => $validated['agency_id'],
            'assigned_by' => auth()->id(),
            'assignment_notes' => $validated['notes'],
            'status' => \App\Models\AgencyAssignment::STATUS_PENDING,
        ]);

        $inquiry->update([
            'status' => Inquiry::STATUS_UNDER_INVESTIGATION,
        ]);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $inquiry->getOriginal('status'),
            'to_status' => Inquiry::STATUS_UNDER_INVESTIGATION,
            'notes' => 'Assigned to ' . $agency->name . '. ' . ($validated['notes'] ?? ''),
            'officer_name' => auth()->user()->name,
            'officer_id' => auth()->id(),
        ]);

        AuditLog::logAgencyAssignment(auth()->id(), $inquiry, $agency, $request->ip());

        Notification::notifyAgency(
            $validated['agency_id'],
            Notification::TYPE_INQUIRY_ASSIGNED,
            'New Inquiry Assigned',
            "Inquiry #{$inquiry->inquiry_number} has been assigned to your agency for investigation.",
            ['inquiry_id' => $inquiry->id, 'inquiry_number' => $inquiry->inquiry_number]
        );

        return redirect()->route('mcmc.inquiries.show', $inquiry)->with('success', 'Inquiry assigned to ' . $agency->name);
    }

    public function reassign(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $agency = Agency::findOrFail($validated['agency_id']);

        $previousAssignment = $inquiry->currentAssignment;
        
        if ($previousAssignment) {
            $previousAssignment->update([
                'status' => \App\Models\AgencyAssignment::STATUS_REASSIGNED,
            ]);
        }

        $assignment = \App\Models\AgencyAssignment::create([
            'inquiry_id' => $inquiry->id,
            'agency_id' => $validated['agency_id'],
            'assigned_by' => auth()->id(),
            'assignment_notes' => $validated['notes'],
            'assignment_group_id' => $previousAssignment?->id,
            'status' => \App\Models\AgencyAssignment::STATUS_PENDING,
        ]);

        $inquiry->update([
            'status' => Inquiry::STATUS_UNDER_INVESTIGATION,
        ]);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $inquiry->getOriginal('status'),
            'to_status' => Inquiry::STATUS_UNDER_INVESTIGATION,
            'notes' => 'Reassigned to ' . $agency->name . '. ' . ($validated['notes'] ?? ''),
            'officer_name' => auth()->user()->name,
            'officer_id' => auth()->id(),
        ]);

        Notification::notifyAgency(
            $validated['agency_id'],
            Notification::TYPE_INQUIRY_ASSIGNED,
            'Inquiry Reassigned',
            "Inquiry #{$inquiry->inquiry_number} has been reassigned to your agency for investigation.",
            ['inquiry_id' => $inquiry->id, 'inquiry_number' => $inquiry->inquiry_number]
        );

        return redirect()->route('mcmc.inquiries.show', $inquiry)->with('success', 'Inquiry reassigned to ' . $agency->name);
    }

    public function statistics()
    {
        $stats = [
            'total' => Inquiry::count(),
            'pending_review' => Inquiry::where('status', Inquiry::STATUS_PENDING_REVIEW)->count(),
            'under_investigation' => Inquiry::where('status', Inquiry::STATUS_UNDER_INVESTIGATION)->count(),
            'verified_true' => Inquiry::where('status', Inquiry::STATUS_VERIFIED_TRUE)->count(),
            'identified_fake' => Inquiry::where('status', Inquiry::STATUS_IDENTIFIED_FAKE)->count(),
            'rejected' => Inquiry::where('status', Inquiry::STATUS_REJECTED)->count(),
            'by_category' => Inquiry::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category'),
        ];

        return view('mcmc.inquiries.statistics', compact('stats'));
    }
}
