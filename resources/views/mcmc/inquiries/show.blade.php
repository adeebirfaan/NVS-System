@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="container mt-5">
    <div class="mb-3">
        <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Inquiries
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Inquiry #</span>
                        <strong>{{ $inquiry->inquiry_number }}</strong>
                    </div>
                    <div>
                        @switch($inquiry->status)
                            @case('pending_review')
                                <span class="badge bg-warning">Pending Review</span>
                                @break
                            @case('under_investigation')
                                <span class="badge bg-info">Under Investigation</span>
                                @break
                            @case('verified_true')
                                <span class="badge bg-success">Verified True</span>
                                @break
                            @case('identified_fake')
                                <span class="badge bg-danger">Identified Fake</span>
                                @break
                            @case('rejected')
                                <span class="badge bg-secondary">Rejected</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <h4>{{ $inquiry->title }}</h4>
                    
                    <div class="mb-3">
                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</span>
                        @if($inquiry->is_public)
                            <span class="badge bg-info">Public</span>
                        @endif
                    </div>

                    <h6>Description</h6>
                    <p class="mb-4">{{ $inquiry->description }}</p>

                    @if($inquiry->source_url)
                        <h6>Source URL</h6>
                        <p class="mb-4">
                            <a href="{{ $inquiry->source_url }}" target="_blank" rel="noopener noreferrer">
                                {{ $inquiry->source_url }}
                            </a>
                        </p>
                    @endif

                    @if($inquiry->evidences->count() > 0)
                        <h6>Evidence Files</h6>
                        <div class="list-group mb-4">
                            @foreach($inquiry->evidences as $evidence)
                                <a href="{{ asset('storage/' . $evidence->file_path) }}" target="_blank" class="list-group-item list-group-item-action">
                                    <i class="bi bi-paperclip"></i> 
                                    {{ $evidence->original_filename }}
                                    <span class="text-muted">({{ number_format($evidence->file_size / 1024, 2) }} KB)</span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if($inquiry->statusHistories->count() > 0)
                    <h6>Status History</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Notes</th>
                                    <th>Officer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inquiry->statusHistories as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $history->from_status ? ucfirst(str_replace('_', ' ', $history->from_status)) : '-' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $history->to_status)) }}</td>
                                        <td>{{ $history->notes ?? '-' }}</td>
                                        <td>{{ $history->officer_name ?? 'System' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Inquiry Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Submitter</th>
                            <td>
                                {{ $inquiry->user->name }}
                                <br>
                                <small class="text-muted">{{ $inquiry->user->email }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Submission Date</th>
                            <td>{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>{{ $inquiry->submission_ip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</td>
                        </tr>
                        @if($inquiry->currentAssignment)
                        <tr>
                            <th>Assigned Agency</th>
                            <td>{{ $inquiry->currentAssignment->agency->name }}</td>
                        </tr>
                        <tr>
                            <th>Assignment Status</th>
                            <td>
                                @switch($inquiry->currentAssignment->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('accepted')
                                        <span class="badge bg-success">Accepted</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            @if($inquiry->status === 'pending_review')
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Assign to Agency</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mcmc.inquiries.assign', $inquiry) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="agency_id" class="form-label">Select Agency</label>
                            <select class="form-select" id="agency_id" name="agency_id" required>
                                <option value="">Select Agency</option>
                                @foreach(\App\Models\Agency::active()->get() as $agency)
                                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Optional notes for the agency"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign Inquiry</button>
                    </form>
                </div>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Update Status</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mcmc.inquiries.update-status', $inquiry) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label">New Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="pending_review" {{ $inquiry->status == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                                <option value="under_investigation" {{ $inquiry->status == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                                <option value="verified_true">Verified as True</option>
                                <option value="identified_fake">Identified as Fake</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Internal Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add notes about this status change (visible to user)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
