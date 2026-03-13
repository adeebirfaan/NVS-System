@extends('layouts.app')

@section('title', 'Manage Inquiries')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Inquiries</h2>
        <a href="{{ route('mcmc.inquiries.statistics') }}" class="btn btn-info">
            <i class="bi bi-bar-chart"></i> Statistics
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search title, inquiry #, user" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Under Investigation</option>
                        <option value="verified_true" {{ request('status') == 'verified_true' ? 'selected' : '' }}>Verified True</option>
                        <option value="identified_fake" {{ request('status') == 'identified_fake' ? 'selected' : '' }}>Identified Fake</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="news" {{ request('category') == 'news' ? 'selected' : '' }}>News</option>
                        <option value="social_media" {{ request('category') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="message" {{ request('category') == 'message' ? 'selected' : '' }}>Message</option>
                        <option value="video" {{ request('category') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="image" {{ request('category') == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="agency" class="form-select">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                        <input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-secondary">Clear</a>
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
                            <th>Agency</th>
                            <th>Status</th>
                            <th>Submitted</th>
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
                                    <a href="{{ route('mcmc.inquiries.show', $inquiry) }}">{{ Str::limit($inquiry->title, 30) }}</a>
                                </td>
                                <td>
                                    {{ $inquiry->user->name }}
                                    <br>
                                    <small class="text-muted">{{ $inquiry->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}</span>
                                </td>
                                <td>
                                    @if($inquiry->currentAssignment)
                                        <span class="badge bg-info">{{ $inquiry->currentAssignment->agency->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
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
                                <td>{{ $inquiry->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('mcmc.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No inquiries found.</td>
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
