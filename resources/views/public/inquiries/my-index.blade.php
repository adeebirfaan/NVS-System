@extends('layouts.app')

@section('title', 'My Inquiries')

@section('styles')
<style>
body{
    background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
}

/* Page spacing */
.page-container{
    min-height: calc(100vh - 140px);
    padding: 40px 0;
}

/* Page title */
.page-title{
    font-family: 'Orbitron', sans-serif;
    letter-spacing: 1px;
    color: white;
}

/* Glass card */
.glass-card{
    background: rgba(15,23,42,0.65);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.5);
    color: white;
}

/* Form styling */
.form-control,
.form-select{
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.18);
    color: #ffffff;
    border-radius: 10px;
}

.form-control::placeholder{
    color: rgba(255,255,255,0.60);
}

.form-control:focus,
.form-select:focus{
    background: rgba(255,255,255,0.16);
    border-color: #4facfe;
    box-shadow: 0 0 8px rgba(79,172,254,0.6);
    color: #ffffff;
}

.form-select option{
    color: #111827;
}

/* Buttons */
.btn-gradient{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border: none;
    color: white;
    border-radius: 10px;
    font-weight: 500;
}

.btn-gradient:hover{
    color: white;
}

.btn-glass{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: white;
    border-radius: 10px;
    font-weight: 500;
}

.btn-glass:hover{
    background: rgba(255,255,255,0.16);
    color: white;
}

/* =========================
   TABLE FIX
   This overrides Bootstrap 5 table vars
   ========================= */

/* Outer table shell */
.table-wrapper{
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    background: rgba(10, 15, 30, 0.45);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.10);
    box-shadow:
        0 8px 30px rgba(0,0,0,0.45),
        inset 0 1px 0 rgba(255,255,255,0.05);
}

/* soft glow border */
.table-wrapper::before{
    content: "";
    position: absolute;
    inset: 0;
    padding: 1px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(79,172,254,0.55), rgba(0,242,254,0.18));
    -webkit-mask:
        linear-gradient(#000 0 0) content-box,
        linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}

/* responsive area */
.table-responsive{
    border-radius: 18px;
    overflow: hidden;
    background: transparent !important;
}

/* IMPORTANT: Bootstrap 5 table variable overrides */
.table.glass-table{
    --bs-table-color: #f8fafc;
    --bs-table-bg: transparent;
    --bs-table-border-color: rgba(255,255,255,0.08);
    --bs-table-striped-color: #f8fafc;
    --bs-table-striped-bg: rgba(255,255,255,0.03);
    --bs-table-active-color: #ffffff;
    --bs-table-active-bg: rgba(255,255,255,0.06);
    --bs-table-hover-color: #ffffff;
    --bs-table-hover-bg: rgba(79,172,254,0.10);

    color: #f8fafc !important;
    margin-bottom: 0;
    background-color: transparent !important;
    border-color: rgba(255,255,255,0.08) !important;
}

/* Kill Bootstrap white cell fill */
.table.glass-table > :not(caption) > * > *{
    background-color: transparent !important;
    box-shadow: none !important;
    color: #f8fafc !important;
    border-bottom-color: rgba(255,255,255,0.08) !important;
    vertical-align: middle;
    padding: 16px 18px;
}

/* Header */
.table.glass-table thead{
    background: rgba(255,255,255,0.06) !important;
}

.table.glass-table thead th{
    color: #ffffff !important;
    font-weight: 600;
    letter-spacing: 0.3px;
    border-bottom: 1px solid rgba(255,255,255,0.12) !important;
}

/* Body rows */
.table.glass-table tbody tr{
    transition: background 0.2s ease, transform 0.2s ease;
}

.table.glass-table tbody tr:nth-child(even){
    background: rgba(255,255,255,0.03);
}

.table.glass-table.table-hover tbody tr:hover{
    background: rgba(79,172,254,0.10) !important;
}

/* Links inside table */
.table.glass-table a{
    color: #8fd3ff;
    font-weight: 500;
    text-decoration: none;
}

.table.glass-table a:hover{
    color: #ffffff;
    text-decoration: underline;
}

/* Muted inquiry number */
.muted-text{
    color: rgba(255,255,255,0.78);
    font-weight: 500;
}

/* Status badges */
.badge-glass{
    display: inline-block;
    padding: 7px 14px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.2px;
}

.badge-pending{
    background: rgba(245,158,11,0.18);
    color:#fde68a;
}

.badge-investigating{
    background: rgba(59,130,246,0.18);
    color:#bfdbfe;
}

.badge-verified{
    background: rgba(16,185,129,0.18);
    color:#bbf7d0;
}

.badge-fake{
    background: rgba(239,68,68,0.18);
    color:#fecaca;
}

.badge-rejected{
    background: rgba(148,163,184,0.18);
    color:#e5e7eb;
}

/* Category badge */
.badge-category{
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(148,163,184,0.18);
    color:#f1f5f9;
    font-size: 0.78rem;
    font-weight: 500;
}

/* Table action button */
.table .btn-gradient{
    padding: 6px 14px;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 10px;
}

/* Pagination styling */
.pagination{
    justify-content:center;
    margin-top: 20px;
}

.pagination .page-link{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    color:white;
}

.pagination .page-item.active .page-link{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border:none;
}

.pagination .page-link:hover{
    background: rgba(255,255,255,0.15);
    color: white;
}

/* Empty state */
.empty-state{
    text-align:center;
    padding:60px 20px;
}

.empty-state i{
    font-size:3rem;
    color:rgba(255,255,255,0.4);
}

.empty-text{
    margin-top:15px;
    color:rgba(255,255,255,0.7);
}
</style>
@endsection

@section('content')
<div class="container page-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">My Inquiries</h2>

        <a href="{{ route('inquiries.create') }}" class="btn btn-gradient">
            <i class="bi bi-plus-circle"></i> Submit New Inquiry
        </a>
    </div>

    <div class="card glass-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by title or inquiry number"
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>

                        <option value="pending_review" {{ request('status')=='pending_review' ? 'selected' : '' }}>
                            Pending Review
                        </option>

                        <option value="under_investigation" {{ request('status')=='under_investigation' ? 'selected' : '' }}>
                            Under Investigation
                        </option>

                        <option value="verified_true" {{ request('status')=='verified_true' ? 'selected' : '' }}>
                            Verified as True
                        </option>

                        <option value="identified_fake" {{ request('status')=='identified_fake' ? 'selected' : '' }}>
                            Identified as Fake
                        </option>

                        <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-glass w-100">Filter</button>
                </div>

                @if(request('search') || request('status'))
                    <div class="col-md-2">
                        <a href="{{ route('inquiries.my') }}" class="btn btn-glass w-100">
                            Clear
                        </a>
                    </div>
                @endif

            </form>
        </div>
    </div>

    <div class="card glass-card">
        <div class="card-body">

            @if($inquiries->count() > 0)

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table glass-table table-hover align-middle">
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
                                            <span class="muted-text">
                                                {{ $inquiry->inquiry_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('inquiries.show', $inquiry) }}">
                                                {{ \Illuminate\Support\Str::limit($inquiry->title, 40) }}
                                            </a>
                                        </td>

                                        <td>
                                            <span class="badge-category">
                                                {{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}
                                            </span>
                                        </td>

                                        <td>
                                            @switch($inquiry->status)
                                                @case('pending_review')
                                                    <span class="badge-glass badge-pending">Pending Review</span>
                                                    @break

                                                @case('under_investigation')
                                                    <span class="badge-glass badge-investigating">Investigating</span>
                                                    @break

                                                @case('verified_true')
                                                    <span class="badge-glass badge-verified">Verified True</span>
                                                    @break

                                                @case('identified_fake')
                                                    <span class="badge-glass badge-fake">Identified Fake</span>
                                                    @break

                                                @case('rejected')
                                                    <span class="badge-glass badge-rejected">Rejected</span>
                                                    @break
                                            @endswitch
                                        </td>

                                        <td>
                                            {{ $inquiry->created_at->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            <a href="{{ route('inquiries.show', $inquiry) }}" class="btn btn-sm btn-gradient">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $inquiries->links() }}

            @else

                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p class="empty-text">No inquiries found.</p>

                    <a href="{{ route('inquiries.create') }}" class="btn btn-gradient mt-3">
                        Submit Your First Inquiry
                    </a>
                </div>

            @endif

        </div>
    </div>

</div>
@endsection