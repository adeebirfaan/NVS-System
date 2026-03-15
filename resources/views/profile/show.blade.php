@extends('layouts.app')

@section('title', 'My Profile')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .profile-container{
        min-height: calc(100vh - 140px);
        padding: 40px 0;
    }

    .profile-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
        color: white;
    }

    .profile-card,
    .details-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
    }

    .profile-card{
        text-align: center;
    }

    .profile-avatar{
        width: 110px;
        height: 110px;
        margin: 0 auto 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(79,172,254,0.18), rgba(0,242,254,0.12));
        border: 1px solid rgba(255,255,255,0.18);
        box-shadow: 0 8px 20px rgba(0,0,0,0.35);
        font-size: 4rem;
        color: #8fd3ff;
    }

    .profile-name{
        font-weight: 600;
        color: white;
        margin-bottom: 6px;
    }

    .profile-email{
        color: rgba(255,255,255,0.75);
        margin-bottom: 14px;
        word-break: break-word;
    }

    .glass-badge{
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 500;
        display: inline-block;
        margin: 4px 4px 0;
        border: 1px solid transparent;
    }

    .badge-role-mcmc{
        background: rgba(59,130,246,0.18);
        color: #bfdbfe;
        border-color: rgba(59,130,246,0.32);
    }

    .badge-role-agency{
        background: rgba(34,211,238,0.18);
        color: #a5f3fc;
        border-color: rgba(34,211,238,0.32);
    }

    .badge-role-public{
        background: rgba(148,163,184,0.18);
        color: #e2e8f0;
        border-color: rgba(148,163,184,0.32);
    }

    .badge-warning-glass{
        background: rgba(245,158,11,0.18);
        color: #fde68a;
        border-color: rgba(245,158,11,0.32);
    }

    .badge-success-glass{
        background: rgba(16,185,129,0.18);
        color: #bbf7d0;
        border-color: rgba(16,185,129,0.32);
    }

    .badge-danger-glass{
        background: rgba(239,68,68,0.18);
        color: #fecaca;
        border-color: rgba(239,68,68,0.32);
    }

    .details-card .card-header{
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        color: white;
        border-radius: 18px 18px 0 0 !important;
        padding: 18px 22px;
    }

    .details-card .card-header h5{
        color: white;
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 0.5px;
        margin: 0;
        font-size: 1rem;
    }

    .details-card .card-body{
        padding: 20px 22px;
    }

    .profile-table{
        width: 100%;
        margin-bottom: 0;
        color: white;
    }

    .profile-table tr{
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .profile-table tr:last-child{
        border-bottom: none;
    }

    .profile-table th,
    .profile-table td{
        padding: 14px 10px;
        vertical-align: middle;
    }

    .profile-table th{
        width: 34%;
        color: rgba(255,255,255,0.78);
        font-weight: 600;
    }

    .profile-table td{
        color: white;
    }

    .btn-edit-profile{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        border-radius: 10px;
        padding: 9px 16px;
        font-weight: 600;
        color: white;
        transition: 0.3s;
    }

    .btn-edit-profile:hover{
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,242,254,0.35);
        color: white;
    }

    .page-subtitle{
        color: rgba(255,255,255,0.78);
        margin-bottom: 24px;
    }
</style>
@endsection

@section('content')
<div class="container profile-container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="profile-title">My Profile</h2>
            <p class="page-subtitle">View your account information and profile details.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card profile-card h-100">
                <div class="card-body p-4">
                    <div class="profile-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <h4 class="profile-name">{{ $user->name }}</h4>
                    <p class="profile-email">{{ $user->email }}</p>

                    <div>
                        <span class="glass-badge
                            {{ $user->role == 'mcmc' ? 'badge-role-mcmc' : ($user->role == 'agency' ? 'badge-role-agency' : 'badge-role-public') }}">
                            {{ ucfirst($user->role) }}
                        </span>

                        @if($user->must_change_password)
                            <span class="glass-badge badge-warning-glass">
                                Must Change Password
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card details-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Profile Details</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-edit-profile">Edit Profile</a>
                </div>

                <div class="card-body">
                    <table class="profile-table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>
                                {{ $user->email }}
                                @if(!$user->hasVerifiedEmail())
                                    <span class="glass-badge badge-warning-glass ms-2">Unverified</span>
                                @else
                                    <span class="glass-badge badge-success-glass ms-2">Verified</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Address</th>
                            <td>{{ $user->address ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Role</th>
                            <td>{{ ucfirst($user->role) }}</td>
                        </tr>

                        @if($user->agency)
                        <tr>
                            <th>Agency</th>
                            <td>{{ $user->agency->name }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($user->is_active)
                                    <span class="glass-badge badge-success-glass">Active</span>
                                @else
                                    <span class="glass-badge badge-danger-glass">Inactive</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Member Since</th>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection