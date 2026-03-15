@extends('layouts.app')

@section('title', 'Manage Inquiries')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .page-container{
        min-height: calc(100vh - 140px);
        padding: 40px 0;
    }

    .page-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
        color: white;
    }

    .glass-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
    }

    .glass-card .card-body{
        padding: 22px;
    }

    .form-control,
    .form-select{
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #111827;
        border-radius: 12px;
        padding: 12px 14px;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus{
        background: rgba(255,255,255,0.25);
        border: 1px solid #4facfe;
        box-shadow: 0 0 12px rgba(79,172,254,0.6);
        color: #111827;
    }

    .form-control::placeholder{
        color: rgba(17,24,39,0.45);
    }

    .btn-modern{
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-modern:hover{
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.35);
    }

    .btn-gradient{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        color: white;
    }

    .btn-gradient:hover{
        color: white;
    }

    .btn-glass{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        color: white;
    }

    .btn-glass:hover{
        background: rgba(255,255,255,0.14);
        color: white;
    }

    .btn-stats{
        background: linear-gradient(135deg,#06b6d4,#22d3ee);
        border: none;
        color: white;
    }

    .btn-stats:hover{
        color: white;
    }

    .table{
        color: white;
        margin-bottom: 0;
    }

    .table thead th{
        border-bottom: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.85);
        font-weight: 600;
        white-space: nowrap;
    }

    .table tbody td{
        border-color: rgba(255,255,255,0.08);
        vertical-align: middle;
    }

    .table-hover tbody tr:hover{
        background: rgba(255,255,255,0.05);
    }

    .table a{
        color: #8fd3ff;
        text-decoration: none;
    }

    .table a:hover{
        color: white;
        text-decoration: underline;
    }

    .muted-text{
        color: rgba(255,255,255,0.65) !important;
    }

    .glass-badge{
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .badge-category{
        background: rgba(148,163,184,0.18);
        color: #e2e8f0;
        border-color: rgba(148,163,184,0.30);
    }

    .badge-agency{
        background: rgba(34,211,238,0.18);
        color: #a5f3fc;
        border-color: rgba(34,211,238,0.30);
    }

    .badge-pending{
        background: rgba(245,158,11,0.18);
        color: #fde68a;
        border-color: rgba(245,158,11,0.30);
    }

    .badge-investigating{
        background: rgba(59,130,246,0.18);
        color: #bfdbfe;
        border-color: rgba(59,130,246,0.30);
    }

    .badge-verified{
        background: rgba(16,185,129,0.18);
        color: #bbf7d0;
        border-color: rgba(16,185,129,0.30);
    }

    .badge-fake{
        background: rgba(239,68,68,0.18);
        color: #fecaca;
        border-color: rgba(239,68,68,0.30);
    }

    .badge-rejected{
        background: rgba(148,163,184,0.18);
        color: #e5e7eb;
        border-color: rgba(148,163,184,0.30);
    }

    .action-btn{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 6px 10px;
    }

    .action-btn:hover{
        color: white;
        box-shadow: 0 6px 14px rgba(0,242,254,0.25);
    }

    .pagination{
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-link{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.10);
        color: white;
    }

    .pagination .page-item.active .page-link{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border-color: transparent;
        color: white;
    }

    .pagination .page-link:hover{
        background: rgba(255,255,255,0.16);
        color: white;
    }

    .empty-text{
        color: rgba(255,255,255,0.75);
        padding: 18px 0;
    }
</style>
@endsection

@section('content')
<div class="container page-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="page-title mb-0">Manage Inquiries</h2>

        <a href="{{ route('mcmc.inquiries.statistics') }}" class="btn btn-stats btn-modern">
            <i class="bi bi-bar-chart"></i> Statistics
        </a>
    </div>

    <div class="card glass-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search title, inquiry #, user"
                        value="{{ request('search') }}"
                    >
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
                            <option value="{{ $agency->id }}" {{ request('agency') == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-gradient btn-modern">Filter</button>
                    <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-glass btn-modern">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card glass-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
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
                                    <span class="muted-text">{{ $inquiry->inquiry_number }}</span>
                                </td>

                                <td>
                                    <a href="{{ route('mcmc.inquiries.show', $inquiry) }}">
                                        {{ Str::limit($inquiry->title, 30) }}
                                    </a>
                                </td>

                                <td>
                                    {{ $inquiry->user->name }}
                                    <br>
                                    <small class="muted-text">{{ $inquiry->user->email }}</small>
                                </td>

                                <td>
                                    <span class="glass-badge badge-category">
                                        {{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}
                                    </span>
                                </td>

                                <td>
                                    @if($inquiry->currentAssignment)
                                        <span class="glass-badge badge-agency">
                                            {{ $inquiry->currentAssignment->agency->name }}
                                        </span>
                                    @else
                                        <span class="muted-text">-</span>
                                    @endif
                                </td>

                                <td>
                                    @switch($inquiry->status)
                                        @case('pending_review')
                                            <span class="glass-badge badge-pending">Pending</span>
                                            @break

                                        @case('under_investigation')
                                            <span class="glass-badge badge-investigating">Investigating</span>
                                            @break

                                        @case('verified_true')
                                            <span class="glass-badge badge-verified">Verified True</span>
                                            @break

                                        @case('identified_fake')
                                            <span class="glass-badge badge-fake">Identified Fake</span>
                                            @break

                                        @case('rejected')
                                            <span class="glass-badge badge-rejected">Rejected</span>
                                            @break
                                    @endswitch
                                </td>

                                <td>{{ $inquiry->created_at->format('d/m/Y') }}</td>

                                <td>
                                    <a href="{{ route('mcmc.inquiries.show', $inquiry) }}" class="btn btn-sm action-btn">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center empty-text">No inquiries found.</td>
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