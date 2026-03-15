@extends('layouts.app')

@section('title', 'MCMC Dashboard')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-wrapper{
        min-height: calc(100vh - 140px);
        padding: 45px 0;
    }

    .dashboard-hero{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.45);
        margin-bottom: 30px;
        color: white;
    }

    .dashboard-title{
        font-family: 'Orbitron', sans-serif;
        font-size: 2rem;
        letter-spacing: 1px;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .dashboard-subtitle{
        color: rgba(255,255,255,0.75);
        margin-bottom: 0;
        font-size: 1rem;
    }

    .stat-card{
        position: relative;
        overflow: hidden;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.35);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        color: white;
        height: 100%;
    }

    .stat-card:hover{
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.45);
        border-color: rgba(255,255,255,0.18);
    }

    .stat-card::before{
        content: "";
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }

    .stat-card .card-body{
        padding: 26px;
        position: relative;
        z-index: 1;
    }

    .stat-icon{
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .stat-card h5{
        color: rgba(255,255,255,0.85);
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .stat-number{
        font-size: 2.6rem;
        font-weight: 700;
        line-height: 1;
        color: #ffffff;
        margin-bottom: 0;
    }

    .glow-blue .stat-icon{
        background: linear-gradient(135deg, rgba(59,130,246,0.95), rgba(96,165,250,0.75));
        color: white;
    }

    .glow-green .stat-icon{
        background: linear-gradient(135deg, rgba(16,185,129,0.95), rgba(52,211,153,0.75));
        color: white;
    }

    .glow-yellow .stat-icon{
        background: linear-gradient(135deg, rgba(245,158,11,0.95), rgba(251,191,36,0.75));
        color: #111827;
    }

    .glow-cyan .stat-icon{
        background: linear-gradient(135deg, rgba(6,182,212,0.95), rgba(34,211,238,0.75));
        color: white;
    }

    .panel-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 24px;
        box-shadow: 0 12px 34px rgba(0,0,0,0.38);
        color: white;
        height: 100%;
    }

    .panel-card .card-header{
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 22px 24px 14px;
    }

    .panel-card .card-header h5{
        margin: 0;
        color: #ffffff;
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
    }

    .panel-card .card-body{
        padding: 24px;
    }

    .dashboard-btn{
        border-radius: 14px;
        padding: 13px 16px;
        font-weight: 600;
        letter-spacing: 0.3px;
        border-width: 1px;
        transition: all 0.25s ease;
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(8px);
        color: white;
    }

    .dashboard-btn:hover{
        transform: translateY(-2px);
        color: white;
    }

    .btn-blue{
        border-color: rgba(96,165,250,0.55);
        box-shadow: 0 0 0 rgba(96,165,250,0);
    }

    .btn-blue:hover{
        border-color: #60a5fa;
        box-shadow: 0 8px 20px rgba(96,165,250,0.20);
        background: rgba(59,130,246,0.12);
    }

    .btn-green{
        border-color: rgba(52,211,153,0.55);
    }

    .btn-green:hover{
        border-color: #34d399;
        box-shadow: 0 8px 20px rgba(52,211,153,0.18);
        background: rgba(16,185,129,0.12);
    }

    .btn-cyan{
        border-color: rgba(34,211,238,0.55);
    }

    .btn-cyan:hover{
        border-color: #22d3ee;
        box-shadow: 0 8px 20px rgba(34,211,238,0.18);
        background: rgba(6,182,212,0.12);
    }

    .btn-slate{
        border-color: rgba(203,213,225,0.35);
    }

    .btn-slate:hover{
        border-color: #cbd5e1;
        box-shadow: 0 8px 20px rgba(203,213,225,0.12);
        background: rgba(148,163,184,0.10);
    }

    .alert{
        border: none;
        border-radius: 16px;
    }

    @media (max-width: 768px){
        .dashboard-title{
            font-size: 1.6rem;
        }

        .stat-number{
            font-size: 2.2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container dashboard-wrapper">
    <div class="dashboard-hero">
        <h2 class="dashboard-title">MCMC Dashboard</h2>
        <p class="dashboard-subtitle">Welcome back, {{ auth()->user()->name }}. Monitor users, inquiries, reports, and agency activity from one place.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card glow-blue">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5>Total Users</h5>
                    <p class="stat-number">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card glow-green">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h5>Total Inquiries</h5>
                    <p class="stat-number">{{ \App\Models\Inquiry::count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card glow-yellow">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h5>Pending Review</h5>
                    <p class="stat-number">{{ \App\Models\Inquiry::where('status', 'pending_review')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card glow-cyan">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h5>Agencies</h5>
                    <p class="stat-number">{{ \App\Models\Agency::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="card panel-card">
                <div class="card-header">
                    <h5><i class="bi bi-lightning-charge me-2"></i>Quick Links</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('mcmc.inquiries.index') }}" class="btn dashboard-btn btn-blue">
                            <i class="bi bi-file-earmark-text me-2"></i>Manage Inquiries
                        </a>
                        <a href="{{ route('mcmc.users.index') }}" class="btn dashboard-btn btn-green">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                        <a href="{{ route('mcmc.agencies.index') }}" class="btn dashboard-btn btn-cyan">
                            <i class="bi bi-building me-2"></i>Manage Agencies
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card panel-card">
                <div class="card-header">
                    <h5><i class="bi bi-bar-chart-line me-2"></i>Reports & Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('mcmc.inquiries.statistics') }}" class="btn dashboard-btn btn-slate">
                            <i class="bi bi-bar-chart me-2"></i>Inquiry Statistics
                        </a>
                        <a href="{{ route('mcmc.users.statistics') }}" class="btn dashboard-btn btn-slate">
                            <i class="bi bi-people me-2"></i>User Statistics
                        </a>
                        <a href="{{ route('mcmc.users.report') }}" class="btn dashboard-btn btn-slate">
                            <i class="bi bi-file-earmark-ruled me-2"></i>User Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection