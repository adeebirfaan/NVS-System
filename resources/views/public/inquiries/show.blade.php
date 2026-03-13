@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="container mt-5">
    <div class="mb-3">
        <a href="{{ route('inquiries.my') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to My Inquiries
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
                                <span class="badge bg-danger">Identified as Fake</span>
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
                </div>
            </div>

            @if($inquiry->statusHistories->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Status History</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($inquiry->statusHistories as $history)
                            <div class="border-start border-2 ps-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $history->getStatusLabelAttribute() }}</strong>
                                    <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                @if($history->notes)
                                    <p class="mb-1 text-muted">{{ $history->notes }}</p>
                                @endif
                                <small class="text-muted">By: {{ $history->officer_name ?? 'System' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Inquiry Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Submission Date</th>
                            <td>{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $inquiry->updated_at->format('d/m/Y H:i') }}</td>
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
        </div>
    </div>
</div>
@endsection
