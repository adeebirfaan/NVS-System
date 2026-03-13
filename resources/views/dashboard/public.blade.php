@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2>Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">News Verification System - Public Dashboard</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-file-earmark-text"></i> My Inquiries</h5>
                    <p class="card-text display-4">{{ \App\Models\Inquiry::where('user_id', auth()->id())->count() }}</p>
                    <a href="{{ route('inquiries.my') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-split"></i> Pending</h5>
                    <p class="card-text display-4">{{ \App\Models\Inquiry::where('user_id', auth()->id())->whereIn('status', ['pending_review', 'under_investigation'])->count() }}</p>
                    <a href="{{ route('inquiries.my', ['status' => 'pending_review']) }}" class="btn btn-outline-warning btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle"></i> Completed</h5>
                    <p class="card-text display-4">{{ \App\Models\Inquiry::where('user_id', auth()->id())->whereIn('status', ['verified_true', 'identified_fake', 'rejected'])->count() }}</p>
                    <a href="{{ route('inquiries.my', ['status' => 'verified_true']) }}" class="btn btn-outline-success btn-sm">View All</a>
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
                    <a href="{{ route('inquiries.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Submit New Inquiry
                    </a>
                    <a href="{{ route('inquiries.my') }}" class="btn btn-secondary">
                        <i class="bi bi-list-ul"></i> My Inquiries
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
