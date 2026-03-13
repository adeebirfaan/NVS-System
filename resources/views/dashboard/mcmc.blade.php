@extends('layouts.app')

@section('title', 'MCMC Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2>MCMC Dashboard</h2>
            <p class="text-muted">Welcome, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people"></i> Total Users</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-file-earmark-check"></i> Total Inquiries</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-split"></i> Pending</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-building"></i> Agencies</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('mcmc.users.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-people"></i> Manage Users
                        </a>
                        <a href="{{ route('mcmc.agencies.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-building"></i> Manage Agencies
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="bi bi-file-earmark-text"></i> View All Inquiries
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Reports</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('mcmc.users.statistics') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-bar-chart"></i> User Statistics
                        </a>
                        <a href="{{ route('mcmc.users.report') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-graph-up"></i> User Report
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="bi bi-file-earmark-ruled"></i> Inquiry Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
