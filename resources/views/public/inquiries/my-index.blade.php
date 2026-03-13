@extends('layouts.app')

@section('title', 'My Inquiries')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Inquiries</h2>
        <a href="{{ route('inquiries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Submit New Inquiry
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by title or inquiry number" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                        <option value="verified_true" {{ request('status') == 'verified_true' ? 'selected' : '' }}>Verified as True</option>
                        <option value="identified_fake" {{ request('status') == 'identified_fake' ? 'selected' : '' }}>Identified as Fake</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
                @if(request('search') || request('status'))
                <div class="col-md-2">
                    <a href="{{ route('inquiries.my') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($inquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Inquiry #</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiries as $inquiry)
                                <tr>
                                    <td>
                                        <span class="text-muted">{{ $inquiry->inquiry_number }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('inquiries.show', $inquiry) }}">{{ Str::limit($inquiry->title, 40) }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</span>
                                    </td>
                                    <td>
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
                                            @default
                                                <span class="badge bg-secondary">{{ $inquiry->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $inquiry->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('inquiries.show', $inquiry) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $inquiries->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="mt-3 text-muted">No inquiries found.</p>
                    <a href="{{ route('inquiries.create') }}" class="btn btn-primary">Submit Your First Inquiry</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
