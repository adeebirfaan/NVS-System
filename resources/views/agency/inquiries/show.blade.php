@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="container mt-5">
    <div class="mb-3">
        <a href="{{ route('agency.inquiries.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Assigned Inquiries
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
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inquiry->statusHistories as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $history->getStatusLabelAttribute() }}</td>
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
                            <th>Category</th>
                            <td>{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Assignment Details</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Agency</th>
                            <td>{{ auth()->user()->agency->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @switch($assignment->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('accepted')
                                        <span class="badge bg-success">Accepted</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                    @case('reassigned')
                                        <span class="badge bg-info">Reassigned</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        @if($assignment->assignment_notes)
                        <tr>
                            <th>Notes from MCMC</th>
                            <td>{{ $assignment->assignment_notes }}</td>
                        </tr>
                        @endif
                        @if($assignment->rejection_reason)
                        <tr>
                            <th>Rejection Reason</th>
                            <td class="text-danger">{{ $assignment->rejection_reason }}</td>
                        </tr>
                        @endif
                    </table>

                    @if($assignment->status === 'pending')
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('agency.inquiries.accept', $inquiry) }}">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Optional notes"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Accept Assignment
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle"></i> Reject Assignment
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            @if($assignment->status === 'accepted' && $inquiry->status === 'under_investigation')
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Update Investigation Progress</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('agency.inquiries.update-progress', $inquiry) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="under_investigation" {{ $inquiry->status == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                                <option value="verified_true">Verified as True</option>
                                <option value="identified_fake">Identified as Fake</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes / Findings <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" required placeholder="Provide details about your investigation findings"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($assignment->status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('agency.inquiries.reject', $inquiry) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please provide a reason why this inquiry cannot be handled by your agency"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
