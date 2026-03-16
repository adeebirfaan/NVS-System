@extends('layouts.app')

@section('title', 'User Report')

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

    .card-header.details-header h5{
        color: #8fd3ff !important;
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

    .btn-gradient{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        color: white;
    }

    .btn-gradient:hover{
        color: white;
    }

    .form-label{
        color: #ffffff;
        font-weight: 500;
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

    .form-control::placeholder{
        color: rgba(255,255,255,0.55) !important;
    }

    .form-select option{
        color: #111827;
        background: #ffffff;
    }

    input[type="date"]{
        color: #ffffff !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator{
        filter: invert(1);
        opacity: 0.9;
        cursor: pointer;
    }

    /* Top stats cards */
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
        background: linear-gradient(135deg, rgba(59,130,246,0.55), rgba(0,242,254,0.22));
    }

    .stat-purple{
        background: linear-gradient(135deg, rgba(139,92,246,0.50), rgba(196,181,253,0.22));
    }

    .stat-success{
        background: linear-gradient(135deg, rgba(16,185,129,0.50), rgba(74,222,128,0.22));
    }

    .role-list,
    .status-list{
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .role-list li,
    .status-list li{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        color: #f8fafc;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .role-list li:last-child,
    .status-list li:last-child{
        border-bottom: none;
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

    .table.glass-table tbody tr:hover{
        background: rgba(79,172,254,0.08) !important;
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

    .badge-public{
        background: rgba(148,163,184,0.18);
        color: #e5e7eb;
        border-color: rgba(148,163,184,0.30);
    }

    .badge-mcmc{
        background: rgba(59,130,246,0.18);
        color: #bfdbfe;
        border-color: rgba(59,130,246,0.30);
    }

    .badge-agency{
        background: rgba(34,211,238,0.18);
        color: #a5f3fc;
        border-color: rgba(34,211,238,0.30);
    }

    .badge-active{
        background: rgba(16,185,129,0.18);
        color: #bbf7d0;
        border-color: rgba(16,185,129,0.30);
    }

    .badge-inactive{
        background: rgba(239,68,68,0.18);
        color: #fecaca;
        border-color: rgba(239,68,68,0.30);
    }

    .metric-pill{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        background: rgba(255,255,255,0.08);
        color: #ffffff;
        border: 1px solid rgba(255,255,255,0.10);
    }

    .empty-text{
        color: rgba(255,255,255,0.75);
        padding: 18px 0;
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
        <h2 class="page-title">User Report</h2>
        <a href="{{ route('mcmc.dashboard') }}" class="btn btn-glass btn-modern">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card glass-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div class="col-md-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="public" {{ $role == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="mcmc" {{ $role == 'mcmc' ? 'selected' : '' }}>MCMC</option>
                        <option value="agency" {{ $role == 'agency' ? 'selected' : '' }}>Agency</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-gradient btn-modern w-100">
                        <i class="bi bi-funnel"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stat-card stat-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="stat-value">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card stat-purple">
                <div class="card-body">
                    <h5 class="card-title">By Role</h5>
                    <ul class="role-list">
                        @foreach($stats['by_role'] as $roleName => $count)
                            <li>
                                <span>{{ ucfirst($roleName) }}</span>
                                <span class="metric-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card stat-success">
                <div class="card-body">
                    <h5 class="card-title">By Status</h5>
                    <ul class="status-list">
                        <li>
                            <span>Active</span>
                            <span class="metric-pill">{{ $stats['by_status'][true] ?? 0 }}</span>
                        </li>
                        <li>
                            <span>Inactive</span>
                            <span class="metric-pill">{{ $stats['by_status'][false] ?? 0 }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card glass-card">
        <div class="card-header details-header">
            <h5 class="mb-0">User Details</h5>
        </div>

        <div class="card-body">
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table glass-table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Agency</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'mcmc')
                                            <span class="glass-badge badge-mcmc">MCMC</span>
                                        @elseif($user->role == 'agency')
                                            <span class="glass-badge badge-agency">Agency</span>
                                        @else
                                            <span class="glass-badge badge-public">Public</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->agency->name ?? '-' }}</td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="glass-badge badge-active">Active</span>
                                        @else
                                            <span class="glass-badge badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center empty-text">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection