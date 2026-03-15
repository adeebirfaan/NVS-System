@extends('layouts.app')

@section('title', 'Agency Dashboard')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-container{
        min-height: calc(100vh - 140px);
        padding: 40px 0;
    }

    .dashboard-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
        color: white;
    }

    .dashboard-subtitle{
        color: rgba(255,255,255,0.82);
    }

    .dashboard-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
        transition: 0.3s;
        height: 100%;
    }

    .dashboard-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.6);
    }

    .dashboard-card .card-body{
        padding: 26px 20px;
    }

    .dashboard-card h5{
        color: white;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .dashboard-number{
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        color: white;
        margin-bottom: 0;
    }

    .icon-pill{
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 1.3rem;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .pill-blue{
        background: linear-gradient(135deg, #2563eb, #60a5fa);
    }

    .pill-yellow{
        background: linear-gradient(135deg, #d97706, #fbbf24);
        color: #111827;
    }

    .pill-green{
        background: linear-gradient(135deg, #059669, #34d399);
    }

    .quick-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
    }

    .quick-card .card-header{
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        color: white;
    }

    .quick-card .card-header h5{
        margin: 0;
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 0.5px;
        font-size: 1rem;
    }

    .quick-card .card-body{
        padding: 22px 20px;
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

    .btn-dashboard-primary{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        color: white;
    }

    .btn-dashboard-primary:hover{
        color: white;
    }
</style>
@endsection

@section('content')
<?php
$assigned = \App\Models\Inquiry::whereHas('assignments', function ($q) {
    $q->where('agency_id', auth()->user()->agency_id);
})->count();

$pending = \App\Models\Inquiry::whereHas('assignments', function ($q) {
    $q->where('agency_id', auth()->user()->agency_id)->where('status', 'pending');
})->count();

$inProgress = \App\Models\Inquiry::whereHas('assignments', function ($q) {
    $q->where('agency_id', auth()->user()->agency_id)->where('status', 'accepted');
})->count();
?>

<div class="container dashboard-container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="dashboard-title">Agency Dashboard</h2>
            <p class="dashboard-subtitle">
                {{ auth()->user()->agency->name ?? 'Agency' }} — Welcome, {{ auth()->user()->name }}
            </p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="icon-pill pill-blue">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5>Assigned</h5>
                    <p class="dashboard-number">{{ $assigned }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="icon-pill pill-yellow">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h5>Pending Action</h5>
                    <p class="dashboard-number">{{ $pending }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="icon-pill pill-green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h5>Accepted</h5>
                    <p class="dashboard-number">{{ $inProgress }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card quick-card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('agency.inquiries.index') }}" class="btn btn-dashboard-primary btn-modern">
                        <i class="bi bi-list-task"></i> View Assigned Inquiries
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection