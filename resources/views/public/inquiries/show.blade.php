@extends('layouts.app')

@section('title', 'Inquiry Details')

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

/* Titles */
.page-title{
    font-family: 'Orbitron', sans-serif;
    letter-spacing: 1px;
    color: #ffffff;
}

/* Glass cards */
.glass-card{
    background: rgba(15,23,42,0.65);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.5);
    color: white;
    overflow: hidden;
}

.glass-card .card-header{
    background: rgba(255,255,255,0.05);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    color: white;
    padding: 16px 20px;
}

.glass-card .card-body{
    padding: 22px;
}

/* Text */
.text-soft{
    color: rgba(255,255,255,0.72) !important;
}

.content-label{
    font-size: 0.92rem;
    font-weight: 600;
    color: rgba(255,255,255,0.88);
    margin-bottom: 8px;
}

.content-text{
    color: #f8fafc;
    line-height: 1.7;
}

/* Buttons */
.btn-gradient{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border: none;
    color: white;
    border-radius: 10px;
    font-weight: 500;
    padding: 8px 16px;
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
    padding: 8px 16px;
}

.btn-glass:hover{
    background: rgba(255,255,255,0.16);
    color: white;
}

/* Custom glass badges */
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

.badge-category{
    background: rgba(148,163,184,0.18);
    color:#e2e8f0;
}

.badge-public{
    background: rgba(59,130,246,0.18);
    color:#bfdbfe;
}

.badge-assignment-pending{
    background: rgba(245,158,11,0.18);
    color:#fde68a;
}

.badge-assignment-accepted{
    background: rgba(16,185,129,0.18);
    color:#bbf7d0;
}

.badge-assignment-rejected{
    background: rgba(239,68,68,0.18);
    color:#fecaca;
}

/* Links */
a.glass-link,
.content-text a{
    color: #8fd3ff;
    text-decoration: none;
    word-break: break-word;
}

a.glass-link:hover,
.content-text a:hover{
    color: #ffffff;
    text-decoration: underline;
}

/* Evidence list */
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

/* Timeline */
.timeline-item{
    position: relative;
    padding-left: 22px;
    margin-bottom: 22px;
    border-left: 2px solid rgba(255,255,255,0.12);
}

.timeline-item:last-child{
    margin-bottom: 0;
}

.timeline-item::before{
    content: "";
    position: absolute;
    left: -7px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    box-shadow: 0 0 12px rgba(79,172,254,0.6);
}

.timeline-title{
    color: #ffffff;
    font-weight: 600;
}

.timeline-time,
.timeline-meta,
.timeline-note{
    color: rgba(255,255,255,0.7);
}

.timeline-note{
    margin: 6px 0 4px;
}

/* Info table */
.info-table{
    margin-bottom: 0;
}

.info-table.glass-table{
    --bs-table-color: #f8fafc;
    --bs-table-bg: transparent;
    --bs-table-border-color: rgba(255,255,255,0.08);
    color: #f8fafc !important;
    margin-bottom: 0;
}

.info-table.glass-table > :not(caption) > * > *{
    background-color: transparent !important;
    color: #f8fafc !important;
    border-bottom-color: rgba(255,255,255,0.08) !important;
    padding: 14px 8px;
    vertical-align: middle;
}

.info-table.glass-table th{
    width: 42%;
    color: rgba(255,255,255,0.82) !important;
    font-weight: 600;
}

.info-table.glass-table td{
    color: #ffffff !important;
}

/* Section spacing */
.section-divider{
    height: 1px;
    background: rgba(255,255,255,0.08);
    margin: 20px 0;
}

/* Main title */
.inquiry-main-title{
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 14px;
}

/* Responsive */
@media (max-width: 991.98px){
    .page-container{
        padding: 28px 0;
    }
}
</style>
@endsection

@section('content')
<div class="container page-container">

    <div class="mb-4">
        <a href="{{ route('inquiries.my') }}" class="btn btn-glass btn-sm">
            <i class="bi bi-arrow-left"></i> Back to My Inquiries
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">

            <div class="card glass-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <span class="text-soft">Inquiry #</span>
                        <strong class="ms-1">{{ $inquiry->inquiry_number }}</strong>
                    </div>

                    <div>
                        @switch($inquiry->status)
                            @case('pending_review')
                                <span class="badge-glass badge-pending">Pending Review</span>
                                @break
                            @case('under_investigation')
                                <span class="badge-glass badge-investigating">Under Investigation</span>
                                @break
                            @case('verified_true')
                                <span class="badge-glass badge-verified">Verified True</span>
                                @break
                            @case('identified_fake')
                                <span class="badge-glass badge-fake">Identified as Fake</span>
                                @break
                            @case('rejected')
                                <span class="badge-glass badge-rejected">Rejected</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="inquiry-main-title">{{ $inquiry->title }}</h3>

                    <div class="mb-4 d-flex flex-wrap gap-2">
                        <span class="badge-glass badge-category">
                            {{ ucfirst(str_replace('_', ' ', $inquiry->category)) }}
                        </span>

                        @if($inquiry->is_public)
                            <span class="badge-glass badge-public">Public</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="content-label">Description</div>
                        <div class="content-text">
                            {{ $inquiry->description }}
                        </div>
                    </div>

                    @if($inquiry->source_url)
                        <div class="mb-4">
                            <div class="content-label">Source URL</div>
                            <div class="content-text">
                                <a href="{{ $inquiry->source_url }}" target="_blank" rel="noopener noreferrer" class="glass-link">
                                    {{ $inquiry->source_url }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($inquiry->evidences->count() > 0)
                        <div class="mb-1">
                            <div class="content-label">Evidence Files</div>

                            <div class="evidence-list">
                                @foreach($inquiry->evidences as $evidence)
                                    <a href="{{ asset('storage/' . $evidence->file_path) }}" target="_blank" class="evidence-item">
                                        <div class="evidence-left">
                                            <span class="evidence-icon">
                                                <i class="bi bi-paperclip"></i>
                                            </span>
                                            <span class="evidence-name">
                                                {{ $evidence->original_filename }}
                                            </span>
                                        </div>

                                        <span class="evidence-size">
                                            {{ number_format($evidence->file_size / 1024, 2) }} KB
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($inquiry->statusHistories->count() > 0)
                <div class="card glass-card">
                    <div class="card-header">
                        <h6 class="mb-0">Status History</h6>
                    </div>

                    <div class="card-body">
                        @foreach($inquiry->statusHistories as $history)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div class="timeline-title">{{ $history->getStatusLabelAttribute() }}</div>
                                    <div class="timeline-time">{{ $history->created_at->format('d/m/Y H:i') }}</div>
                                </div>

                                @if($history->notes)
                                    <div class="timeline-note">{{ $history->notes }}</div>
                                @endif

                                <div class="timeline-meta">By: {{ $history->officer_name ?? 'System' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <div class="col-lg-4">
            <div class="card glass-card">
                <div class="card-header">
                    <h6 class="mb-0">Inquiry Information</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm info-table glass-table">
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
                                                <span class="badge-glass badge-assignment-pending">Pending</span>
                                                @break
                                            @case('accepted')
                                                <span class="badge-glass badge-assignment-accepted">Accepted</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge-glass badge-assignment-rejected">Rejected</span>
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
</div>
@endsection