@extends('layouts.app')

@section('title', 'Inquiry Details')

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
        overflow: hidden;
    }

    /* Different title colors for each card header */
    .header-primary{
        color: #ffffff !important;
    }

    .header-info{
        color: #8fd3ff !important;
    }

    .header-success{
        color: #86efac !important;
    }

    .header-warning{
        color: #fcd34d !important;
    }

    .header-danger{
        color: #fca5a5 !important;
    }

    .header-purple{
        color: #c4b5fd !important;
    }

    .header-cyan{
        color: #67e8f9 !important;
    }

    .glass-card .card-header{
        background: rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.12);
        color: white;
        padding: 16px 20px;
    }

    .glass-card .card-body{
        padding: 22px;
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

    .btn-warning-modern{
        background: linear-gradient(135deg,#f59e0b,#fbbf24);
        border: none;
        color: white;
    }

    .btn-warning-modern:hover{
        color: white;
    }

    .btn-danger-modern{
        background: linear-gradient(135deg,#ef4444,#f87171);
        border: none;
        color: white;
    }

    .btn-danger-modern:hover{
        color: white;
    }

    .text-soft{
        color: rgba(255,255,255,0.72) !important;
    }

    .section-title{
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .main-title{
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .content-text{
        color: #f8fafc;
        line-height: 1.7;
    }

    .glass-link{
        color: #8fd3ff;
        text-decoration: none;
        word-break: break-word;
    }

    .glass-link:hover{
        color: #ffffff;
        text-decoration: underline;
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

    .badge-public{
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

    .badge-accepted{
        background: rgba(16,185,129,0.18);
        color: #bbf7d0;
        border-color: rgba(16,185,129,0.30);
    }

    .badge-assignment-rejected{
        background: rgba(239,68,68,0.18);
        color: #fecaca;
        border-color: rgba(239,68,68,0.30);
    }

    .evidence-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .evidence-item{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        color: white;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .evidence-item:hover{
        background: rgba(255,255,255,0.09);
        border-color: rgba(79,172,254,0.35);
        color: white;
    }

    .evidence-left{
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .evidence-icon{
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79,172,254,0.16);
        color: #8fd3ff;
        flex-shrink: 0;
    }

    .evidence-name{
        color: #f8fafc;
        font-weight: 500;
        word-break: break-word;
    }

    .evidence-size{
        color: rgba(255,255,255,0.65);
        font-size: 0.88rem;
        white-space: nowrap;
    }

    .alert-glass-danger{
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.25);
        color: #fecaca;
        border-radius: 14px;
    }

    .table-wrapper{
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        background: rgba(10,15,30,0.42);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.10);
        box-shadow:
            0 8px 30px rgba(0,0,0,0.45),
            inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .table-responsive{
        border-radius: 18px;
        overflow: hidden;
        background: transparent !important;
    }

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

    .table.glass-table > :not(caption) > * > *{
        background-color: transparent !important;
        box-shadow: none !important;
        color: #f8fafc !important;
        border-bottom-color: rgba(255,255,255,0.08) !important;
        vertical-align: middle;
        padding: 14px 16px;
    }

    .table.glass-table thead{
        background: rgba(255,255,255,0.06) !important;
    }

    .table.glass-table thead th{
        border-bottom: 1px solid rgba(255,255,255,0.12) !important;
        color: rgba(255,255,255,0.92) !important;
        font-weight: 600;
        white-space: nowrap;
    }

    .table.glass-table tbody tr:nth-child(even){
        background: rgba(255,255,255,0.03);
    }

    .info-table th{
        width: 42%;
        color: rgba(255,255,255,0.82) !important;
        font-weight: 600;
    }

    .info-table td{
        color: #ffffff !important;
    }

    .muted-text{
        color: rgba(255,255,255,0.68) !important;
    }

    .form-control,
    .form-select{
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.22);
        color: #ffffff !important;
        border-radius: 12px;
        padding: 12px 14px;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus{
        background: rgba(255,255,255,0.18);
        border: 1px solid #4facfe;
        box-shadow: 0 0 12px rgba(79,172,254,0.6);
        color: #ffffff !important;
    }

    .form-control::placeholder,
    textarea.form-control::placeholder{
        color: rgba(255,255,255,0.55) !important;
    }

    .form-select option{
        color: #111827;
        background: #ffffff;
    }

    .form-label{
        color: #ffffff;
        font-weight: 500;
    }

    .status-history-title{
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 14px;
    }
</style>
@endsection

@section('content')
<div class="container page-container">
    <div class="mb-4">
        <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-glass btn-modern btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Inquiries
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card glass-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <span class="text-soft">Inquiry #</span>
                        <strong class="ms-1 header-primary">{{ $inquiry->inquiry_number }}</strong>
                    </div>

                    <div>
                        @switch($inquiry->status)
                            @case('pending_review')
                                <span class="glass-badge badge-pending">Pending Review</span>
                                @break
                            @case('under_investigation')
                                <span class="glass-badge badge-investigating">Under Investigation</span>
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
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="main-title">{{ $inquiry->title }}</h3>

                    <div class="mb-4 d-flex flex-wrap gap-2">
                        <span class="glass-badge badge-category">
                            {{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}
                        </span>

                        @if($inquiry->is_public)
                            <span class="glass-badge badge-public">Public</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="section-title">Description</div>
                        <div class="content-text">{{ $inquiry->description }}</div>
                    </div>

                    @if($inquiry->source_url)
                        <div class="mb-4">
                            <div class="section-title">Source URL</div>
                            <a href="{{ $inquiry->source_url }}" target="_blank" rel="noopener noreferrer" class="glass-link">
                                {{ $inquiry->source_url }}
                            </a>
                        </div>
                    @endif

                    @if($inquiry->evidences->count() > 0)
                        <div class="mb-4">
                            <div class="section-title">Evidence Files</div>

                            <div class="evidence-list">
                                @foreach($inquiry->evidences as $evidence)
                                    <a href="{{ asset('storage/' . $evidence->file_path) }}" target="_blank" class="evidence-item">
                                        <div class="evidence-left">
                                            <span class="evidence-icon">
                                                <i class="bi bi-paperclip"></i>
                                            </span>
                                            <span class="evidence-name">{{ $evidence->original_filename }}</span>
                                        </div>

                                        <span class="evidence-size">
                                            {{ number_format($evidence->file_size / 1024, 2) }} KB
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($inquiry->statusHistories->count() > 0)
                        <div class="status-history-title">Status History</div>
                        <div class="table-wrapper">
                            <div class="table-responsive mb-0">
                                <table class="table glass-table table-sm align-middle">
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
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card glass-card mb-4">
                <div class="card-header">
                 <h6 class="mb-0 header-primary">Inquiry Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table glass-table table-sm info-table">
                                <tr>
                                    <th>Submitter</th>
                                    <td>
                                        {{ $inquiry->user->name }}
                                        <br>
                                        <small class="muted-text">{{ $inquiry->user->email }}</small>
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
                                                <span class="glass-badge badge-pending">Pending</span>
                                                @break
                                            @case('accepted')
                                                <span class="glass-badge badge-accepted">Accepted</span>
                                                @break
                                            @case('rejected')
                                                <span class="glass-badge badge-assignment-rejected">Rejected</span>
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

            @if($inquiry->status === 'pending_review')
            <div class="card glass-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 header-cyan">Assign to Agency</h6>
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
                            <label for="assign_notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="assign_notes" name="notes" rows="2" placeholder="Optional notes for the agency"></textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient btn-modern w-100">Assign Inquiry</button>
                    </form>
                </div>
            </div>
            @endif

            @if($inquiry->currentAssignment && $inquiry->currentAssignment->status === 'rejected')
            <div class="card glass-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 header-danger">Assignment Rejected - Reassign</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-glass-danger mb-3">
                        <strong>Rejection Reason:</strong> {{ $inquiry->currentAssignment->rejection_reason }}
                    </div>
                    <form method="POST" action="{{ route('mcmc.inquiries.reassign', $inquiry) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reassign_agency_id" class="form-label">Select New Agency</label>
                            <select class="form-select" id="reassign_agency_id" name="agency_id" required>
                                <option value="">Select Agency</option>
                                @foreach(\App\Models\Agency::active()->get() as $agency)
                                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reassign_notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="reassign_notes" name="notes" rows="2" placeholder="Optional notes for the new agency"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger-modern btn-modern w-100">Reassign Inquiry</button>
                    </form>
                </div>
            </div>
            @endif

            <div class="card glass-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 header-warning">Update Status</h6>
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
                            <label for="status_notes" class="form-label">Internal Notes</label>
                            <textarea class="form-control" id="status_notes" name="notes" rows="3" placeholder="Add notes about this status change (visible to user)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning-modern btn-modern w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection