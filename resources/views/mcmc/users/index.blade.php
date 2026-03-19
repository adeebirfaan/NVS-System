@extends('layouts.app')

@section('title', 'Manage Users')

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

    /* =========================
       FILTER INPUTS
       ========================= */
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
        color: rgba(255,255,255,0.58) !important;
    }

    .form-select{
        color: #ffffff !important;
    }

    .form-select option{
        color: #111827;
        background: #ffffff;
    }

    /* =========================
       BUTTONS
       ========================= */
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

    .action-btn-warning{
        background: linear-gradient(135deg,#f59e0b,#fbbf24);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 6px 10px;
    }

    .action-btn-warning:hover{
        color: white;
        box-shadow: 0 6px 14px rgba(245,158,11,0.25);
    }

    .action-btn-danger{
        background: linear-gradient(135deg,#ef4444,#f87171);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 6px 10px;
    }

    .action-btn-danger:hover{
        color: white;
        box-shadow: 0 6px 14px rgba(239,68,68,0.25);
    }

    /* =========================
       GLASS TABLE
       ========================= */
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

    .table-wrapper::before{
        content: "";
        position: absolute;
        inset: 0;
        padding: 1px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(79,172,254,0.50), rgba(0,242,254,0.18));
        -webkit-mask:
            linear-gradient(#000 0 0) content-box,
            linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
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
        padding: 16px 18px;
    }

    .table.glass-table thead{
        background: rgba(255,255,255,0.06) !important;
    }

    .table.glass-table thead th{
        border-bottom: 1px solid rgba(255,255,255,0.12) !important;
        color: rgba(255,255,255,0.92) !important;
        font-weight: 600;
        white-space: nowrap;
        letter-spacing: 0.2px;
    }

    .table.glass-table tbody tr{
        transition: background 0.2s ease;
    }

    .table.glass-table tbody tr:nth-child(even){
        background: rgba(255,255,255,0.03);
    }

    .table.glass-table.table-hover tbody tr:hover{
        background: rgba(79,172,254,0.10) !important;
    }

    .muted-text{
        color: rgba(255,255,255,0.68) !important;
    }

    /* =========================
       BADGES
       ========================= */
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
        color: #e2e8f0;
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

    /* =========================
       PAGINATION
       ========================= */
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
        <h2 class="page-title mb-0">Manage Users</h2>

        <a href="{{ route('mcmc.users.create') }}" class="btn btn-gradient btn-modern">
            <i class="bi bi-plus-circle"></i> Add User
        </a>
    </div>

    <div class="card glass-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by name or email"
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="public" {{ request('role') == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="mcmc" {{ request('role') == 'mcmc' ? 'selected' : '' }}>MCMC</option>
                        <option value="agency" {{ request('role') == 'agency' ? 'selected' : '' }}>Agency</option>
                    </select>
                </div>

                <div class="col-md-5 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-gradient btn-modern">Filter</button>
                    <a href="{{ route('mcmc.users.index') }}" class="btn btn-glass btn-modern">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card glass-card">
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
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <span class="muted-text">{{ $user->id }}</span>
                                    </td>

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

                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('mcmc.users.show', $user) }}" class="btn btn-sm action-btn" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('mcmc.users.edit', $user) }}" class="btn btn-sm action-btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form method="POST" action="{{ route('mcmc.users.destroy', $user) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm action-btn-danger"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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

            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection