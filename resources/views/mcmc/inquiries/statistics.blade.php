@extends('layouts.app')

@section('title', 'Inquiry Statistics')

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
        margin-bottom: 0;
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

    .glass-card .card-header{
        background: rgba(255,255,255,0.04);
        border-bottom: 1px solid rgba(255,255,255,0.10);
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

    .btn-glass{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        color: white;
    }

    .btn-glass:hover{
        background: rgba(255,255,255,0.14);
        color: white;
    }

    /* Top stat cards */
    .stat-card{
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.14);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.38);
        color: white;
        height: 100%;
    }

    .stat-card .card-body{
        padding: 22px;
    }

    .stat-card .card-title{
        font-weight: 600;
        margin-bottom: 10px;
        color: rgba(255,255,255,0.92);
    }

    .stat-value{
        font-size: 2.3rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0;
        color: white;
    }

    .stat-primary{
        background: linear-gradient(135deg, rgba(59,130,246,0.55), rgba(0,242,254,0.25));
    }

    .stat-warning{
        background: linear-gradient(135deg, rgba(245,158,11,0.50), rgba(251,191,36,0.22));
    }

    .stat-info{
        background: linear-gradient(135deg, rgba(6,182,212,0.50), rgba(34,211,238,0.22));
    }

    .stat-success{
        background: linear-gradient(135deg, rgba(16,185,129,0.50), rgba(74,222,128,0.22));
    }

    /* Colored header titles */
    .card-header.status-header h6{
        color: #8fd3ff !important;
    }

    .card-header.category-header h6{
        color: #c4b5fd !important;
    }

    .card-header.quick-header h6{
        color: #fcd34d !important;
    }

    /* Glass table */
    .table-wrapper{
        position: relative;
        border-radius: 16px;
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
        border-radius: 16px;
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

    .table.glass-table tbody tr:nth-child(even){
        background: rgba(255,255,255,0.03);
    }

    .table.glass-table tbody tr:hover{
        background: rgba(79,172,254,0.08) !important;
    }

    .table.glass-table td:last-child{
        text-align: right;
        font-weight: 600;
    }

    .muted-text{
        color: rgba(255,255,255,0.68) !important;
    }

    .glass-badge{
        display: inline-block;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid transparent;
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

    .badge-category{
        background: rgba(148,163,184,0.18);
        color: #e2e8f0;
        border-color: rgba(148,163,184,0.30);
    }

    .metric-value{
        color: #ffffff;
        font-weight: 700;
    }

    .empty-text{
        color: rgba(255,255,255,0.72);
        margin-bottom: 0;
    }

    @media (max-width: 991.98px){
        .page-container{
            padding: 28px 0;
        }

        .stat-value{
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container page-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="page-title">Inquiry Statistics</h2>
        <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-glass btn-modern">
            <i class="bi bi-arrow-left"></i> Back to Inquiries
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card stat-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Inquiries</h5>
                    <p class="stat-value">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card stat-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Review</h5>
                    <p class="stat-value">{{ $stats['pending_review'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card stat-info">
                <div class="card-body">
                    <h5 class="card-title">Under Investigation</h5>
                    <p class="stat-value">{{ $stats['under_investigation'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card stat-success">
                <div class="card-body">
                    <h5 class="card-title">Verified True</h5>
                    <p class="stat-value">{{ $stats['verified_true'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card glass-card h-100">
                <div class="card-header status-header">
                    <h6 class="mb-0">By Status</h6>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table glass-table align-middle">
                                <tr>
                                    <td>Pending Review</td>
                                    <td><span class="glass-badge badge-pending">{{ $stats['pending_review'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Under Investigation</td>
                                    <td><span class="glass-badge badge-investigating">{{ $stats['under_investigation'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Verified True</td>
                                    <td><span class="glass-badge badge-verified">{{ $stats['verified_true'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Identified Fake</td>
                                    <td><span class="glass-badge badge-fake">{{ $stats['identified_fake'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Rejected</td>
                                    <td><span class="glass-badge badge-rejected">{{ $stats['rejected'] }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card glass-card h-100">
                <div class="card-header category-header">
                    <h6 class="mb-0">By Category</h6>
                </div>
                <div class="card-body">
                    @if($stats['by_category']->count() > 0)
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table glass-table align-middle">
                                    @foreach($stats['by_category'] as $category => $count)
                                        <tr>
                                            <td>{{ ucfirst(str_replace('_', ' ', $category)) }}</td>
                                            <td><span class="glass-badge badge-category">{{ $count }}</span></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @else
                        <p class="empty-text">No data available.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card glass-card h-100">
                <div class="card-header quick-header">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    @php
                        $resolved = $stats['verified_true'] + $stats['identified_fake'] + $stats['rejected'];
                        $rate = $stats['total'] > 0 ? round(($resolved / $stats['total']) * 100) : 0;

                        $verified = $stats['verified_true'] + $stats['identified_fake'];
                        $vRate = $resolved > 0 ? round(($verified / $resolved) * 100) : 0;
                    @endphp

                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table glass-table align-middle">
                                <tr>
                                    <td>Resolved Rate</td>
                                    <td class="metric-value">{{ $rate }}%</td>
                                </tr>
                                <tr>
                                    <td>Verification Rate</td>
                                    <td class="metric-value">{{ $vRate }}%</td>
                                </tr>
                                <tr>
                                    <td>Total Resolved</td>
                                    <td class="metric-value">{{ $resolved }}</td>
                                </tr>
                                <tr>
                                    <td>Total Verified</td>
                                    <td class="metric-value">{{ $verified }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection