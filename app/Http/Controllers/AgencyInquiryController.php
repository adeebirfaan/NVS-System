<?php

namespace App\Http\Controllers;

use App\Models\AgencyAssignment;
use App\Models\Inquiry;
use App\Models\InquiryStatusHistory;
use App\Models\Notification;
use Illuminate\Http\Request;

class AgencyInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('agency');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Inquiry::whereHas('assignments', function ($q) use ($user) {
            $q->where('agency_id', $user->agency_id);
        })->with(['user', 'latestStatusHistory', 'currentAssignment']);

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('assignment_status') && $request->assignment_status !== '') {
            $query->whereHas('currentAssignment', function ($q) use ($request) {
                $q->where('status', $request->assignment_status);
            });
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('inquiry_number', 'like', '%' . $request->search . '%');
            });
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('agency.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        $user = auth()->user();
        
        $assignment = $inquiry->assignments()
            ->where('agency_id', $user->agency_id)
            ->latest()
            ->first();

        if (!$assignment) {
            return redirect()->route('agency.dashboard')->with('error', 'Inquiry not assigned to your agency.');
        }

        $inquiry->load(['user', 'evidences', 'statusHistories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'assignments.agency']);

        return view('agency.inquiries.show', compact('inquiry', 'assignment'));
    }

    public function accept(Request $request, Inquiry $inquiry)
    {
        $user = auth()->user();
        
        $assignment = $inquiry->assignments()
            ->where('agency_id', $user->agency_id)
            ->pending()
            ->latest()
            ->first();

        if (!$assignment) {
            return redirect()->route('agency.inquiries.index')->with('error', 'No pending assignment found.');
        }

        $assignment->accept($request->notes ?? null);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $inquiry->status,
            'to_status' => $inquiry->status,
            'notes' => 'Assignment accepted by agency. ' . ($request->notes ?? ''),
            'officer_name' => $user->name,
            'officer_id' => $user->id,
        ]);

        Notification::createForUser(
            $inquiry->user_id,
            Notification::TYPE_STATUS_UPDATED,
            'Assignment Accepted',
            "Your inquiry #{$inquiry->inquiry_number} has been accepted by the assigned agency.",
            ['inquiry_id' => $inquiry->id]
        );

        return redirect()->route('agency.inquiries.show', $inquiry)->with('success', 'Assignment accepted successfully.');
    }

    public function reject(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        
        $assignment = $inquiry->assignments()
            ->where('agency_id', $user->agency_id)
            ->pending()
            ->latest()
            ->first();

        if (!$assignment) {
            return redirect()->route('agency.inquiries.index')->with('error', 'No pending assignment found.');
        }

        $assignment->reject($validated['rejection_reason']);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $inquiry->status,
            'to_status' => $inquiry->status,
            'notes' => 'Assignment rejected by agency. Reason: ' . $validated['rejection_reason'],
            'officer_name' => $user->name,
            'officer_id' => $user->id,
        ]);

        Notification::notifyMCMC(
            Notification::TYPE_INQUIRY_REJECTED,
            'Assignment Rejected',
            "Inquiry #{$inquiry->inquiry_number} has been rejected by {$user->agency->name}. Reason: {$validated['rejection_reason']}",
            ['inquiry_id' => $inquiry->id, 'inquiry_number' => $inquiry->inquiry_number]
        );

        return redirect()->route('agency.inquiries.show', $inquiry)->with('info', 'Assignment rejected. MCMC will be notified.');
    }

    public function updateProgress(Request $request, Inquiry $inquiry)
    {
        $user = auth()->user();
        
        $assignment = $inquiry->assignments()
            ->where('agency_id', $user->agency_id)
            ->accepted()
            ->latest()
            ->first();

        if (!$assignment) {
            return redirect()->route('agency.inquiries.index')->with('error', 'No accepted assignment found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [
                Inquiry::STATUS_UNDER_INVESTIGATION,
                Inquiry::STATUS_VERIFIED_TRUE,
                Inquiry::STATUS_IDENTIFIED_FAKE,
                Inquiry::STATUS_REJECTED,
            ]),
            'notes' => 'required|string|max:1000',
        ]);

        $oldStatus = $inquiry->status;

        $inquiry->update([
            'status' => $validated['status'],
            'resolution_notes' => $validated['notes'],
        ]);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => $oldStatus,
            'to_status' => $validated['status'],
            'notes' => $validated['notes'],
            'officer_name' => $user->name,
            'officer_id' => $user->id,
        ]);

        Notification::createForUser(
            $inquiry->user_id,
            Notification::TYPE_INQUIRY_COMPLETED,
            'Inquiry Status Updated',
            "Your inquiry #{$inquiry->inquiry_number} status has been updated to " . str_replace('_', ' ', $validated['status']),
            ['inquiry_id' => $inquiry->id, 'status' => $validated['status']]
        );

        Notification::notifyMCMC(
            Notification::TYPE_STATUS_UPDATED,
            'Inquiry Progress Updated',
            "Inquiry #{$inquiry->inquiry_number} has been updated to " . str_replace('_', ' ', $validated['status']) . " by {$user->agency->name}.",
            ['inquiry_id' => $inquiry->id, 'inquiry_number' => $inquiry->inquiry_number]
        );

        return redirect()->route('agency.inquiries.show', $inquiry)->with('success', 'Inquiry status updated successfully.');
    }
}
