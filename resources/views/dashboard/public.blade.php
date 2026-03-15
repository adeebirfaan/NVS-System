@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>

body{
    background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
}

/* dashboard container */

.dashboard-container{
    min-height: calc(100vh - 140px);
}

/* page title */

.dashboard-title{
    font-family: 'Orbitron', sans-serif;
    letter-spacing:1px;
    color:white;
}

/* glass cards */

.dashboard-card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:18px;
    box-shadow:0 10px 35px rgba(0,0,0,0.5);
    color:white;
    transition:0.3s;
}

.dashboard-card:hover{
    transform: translateY(-4px);
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
}

/* stat numbers */

.dashboard-number{
    font-size:3rem;
    font-weight:600;
}

/* quick action card */

.quick-card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:18px;
    box-shadow:0 10px 35px rgba(0,0,0,0.5);
    color:white;
}

/* header */

.quick-header{
    border-bottom:1px solid rgba(255,255,255,0.15);
}

/* futuristic buttons */

.btn-modern{
    border-radius:10px;
    padding:10px 18px;
    font-weight:500;
    letter-spacing:0.5px;
    transition:0.3s;
}

.btn-modern:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.4);
}

/* primary glow */

.btn-primary{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border:none;
}

.btn-secondary{
    background: rgba(255,255,255,0.15);
    border:none;
    color:white;
}

.btn-outline-primary,
.btn-outline-warning,
.btn-outline-success{
    border-radius:10px;
}

</style>
@endsection


@section('content')
<div class="container dashboard-container mt-5">

    <div class="row">
        <div class="col-12">
            <h2 class="dashboard-title">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-light">News Verification System - Public Dashboard</p>
        </div>
    </div>


    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-file-earmark-text"></i> My Inquiries
                    </h5>

                    <p class="dashboard-number">
                        {{ \App\Models\Inquiry::where('user_id', auth()->id())->count() }}
                    </p>

                    <a href="{{ route('inquiries.my') }}" class="btn btn-outline-primary btn-sm btn-modern">
                        View All
                    </a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-hourglass-split"></i> Pending
                    </h5>

                    <p class="dashboard-number">
                        {{ \App\Models\Inquiry::where('user_id', auth()->id())->whereIn('status', ['pending_review','under_investigation'])->count() }}
                    </p>

                    <a href="{{ route('inquiries.my', ['status' => 'pending_review']) }}"
                       class="btn btn-outline-warning btn-sm btn-modern">
                        View All
                    </a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-check-circle"></i> Completed
                    </h5>

                    <p class="dashboard-number">
                        {{ \App\Models\Inquiry::where('user_id', auth()->id())->whereIn('status', ['verified_true','identified_fake','rejected'])->count() }}
                    </p>

                    <a href="{{ route('inquiries.my', ['status' => 'verified_true']) }}"
                       class="btn btn-outline-success btn-sm btn-modern">
                        View All
                    </a>
                </div>
            </div>
        </div>

    </div>



    <div class="row mt-4">
        <div class="col-12">

            <div class="card quick-card">

                <div class="card-header quick-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>

                <div class="card-body">

                    <a href="{{ route('inquiries.create') }}"
                       class="btn btn-primary btn-modern">
                        <i class="bi bi-plus-circle"></i>
                        Submit New Inquiry
                    </a>

                    <a href="{{ route('inquiries.my') }}"
                       class="btn btn-secondary btn-modern">
                        <i class="bi bi-list-ul"></i>
                        My Inquiries
                    </a>

                </div>

            </div>

        </div>
    </div>

</div>
@endsection