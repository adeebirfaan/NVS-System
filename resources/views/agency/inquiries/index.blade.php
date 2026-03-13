@extends('layouts.app')

@section('title', 'Assigned Inquiries')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Assigned Inquiries</h2>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search title, inquiry #" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                        <option value="verified_true" {{ request('status') == 'verified_true' ? 'selected' : '' }}>Verified True</option>
                        <option value="identified_fake" {{ request('status') == 'identified_fake' ? 'selected' : '' }}>Identified Fake</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="assignment_status" class="form-select">
                        <option value="">All Assignment Statuses</option>
                        <option value="pending" {{ request('assignment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('assignment_status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('assignment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('agency.inquiries.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Inquiry #</th>
                            <th>Title</th>
                            <th>Submitter</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Assignment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $inquiry->inquiry_number }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('agency.inquiries.show', $inquiry) }}">{{ Str::limit($inquiry->title, 30) }}</a>
                                </td>
                                <td>
                                    {{ $inquiry->user->name }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</span>
                                </td>
                                <td>
                                    @switch($inquiry->status)
                                        @case('pending_review')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('under_investigation')
                                            <span class="badge bg-info">Investigating</span>
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
                                </td>
                                <td>
                                    @if($inquiry->currentAssignment)
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
                                            @case('reassigned')
                                                <span class="badge bg-info">Reassigned</span>
                                                @break
                                        @endswitch
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('agency.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No inquiries assigned to your agency.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $inquiries->links() }}
        </div>
    </div>
</div>
@endsection
