@extends('layouts.app')

@section('title', 'Agency Dashboard')

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

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2>Agency Dashboard</h2>
            <p class="text-muted">{{ auth()->user()->agency->name ?? 'Agency' }} - Welcome, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-inbox"></i> Assigned</h5>
                    <p class="card-text display-4">{{ $assigned }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-split"></i> Pending Action</h5>
                    <p class="card-text display-4">{{ $pending }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle"></i> Accepted</h5>
                    <p class="card-text display-4">{{ $inProgress }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('agency.inquiries.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-task"></i> View Assigned Inquiries
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
