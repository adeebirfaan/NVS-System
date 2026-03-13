<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\InquiryEvidence;
use App\Models\InquiryStatusHistory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isPublic()) {
                return redirect('/')->with('error', 'Access denied.');
            }
            return $next($request);
        })->only(['create', 'store', 'myInquiries', 'show']);
    }

    public function create()
    {
        return view('public.inquiries.create');
    }

    public function store(StoreInquiryRequest $request)
    {
        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'inquiry_number' => Inquiry::generateInquiryNumber(),
            'title' => $request->title,
            'description' => $request->description,
            'source_url' => $request->source_url,
            'category' => $request->category,
            'content_snippet' => substr($request->description, 0, 1000),
            'status' => Inquiry::STATUS_PENDING_REVIEW,
            'is_public' => $request->boolean('is_public', false),
            'submission_ip' => $request->ip(),
        ]);

        InquiryStatusHistory::create([
            'inquiry_id' => $inquiry->id,
            'from_status' => null,
            'to_status' => $inquiry->status,
            'notes' => 'Inquiry submitted by user.',
            'officer_name' => auth()->user()->name,
            'officer_id' => auth()->id(),
        ]);

        if ($request->hasFile('evidences')) {
            foreach ($request->file('evidences') as $file) {
                $path = $file->store('evidences/' . $inquiry->id, 'public');
                
                InquiryEvidence::create([
                    'inquiry_id' => $inquiry->id,
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        Notification::notifyMCMC(
            Notification::TYPE_INQUIRY_SUBMITTED,
            'New Inquiry Submitted',
            "Inquiry #{$inquiry->inquiry_number} has been submitted by {$inquiry->user->name}.",
            ['inquiry_id' => $inquiry->id, 'inquiry_number' => $inquiry->inquiry_number]
        );

        return redirect()->route('inquiries.my')->with('success', 'Your inquiry has been submitted successfully! Inquiry Number: ' . $inquiry->inquiry_number);
    }

    public function myInquiries(Request $request)
    {
        $query = Inquiry::where('user_id', auth()->id())
            ->with('latestStatusHistory');

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('inquiry_number', 'like', '%' . $request->search . '%');
            });
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('public.inquiries.my-index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        $this->authorize('view', $inquiry);

        $inquiry->load(['evidences', 'statusHistories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('public.inquiries.show', compact('inquiry'));
    }
}
