@extends('layouts.app')

@section('title', 'Inquiry Statistics')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inquiry Statistics</h2>
        <a href="{{ route('mcmc.inquiries.index') }}" class="btn btn-secondary">Back to Inquiries</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Inquiries</h5>
                    <p class="display-4">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Review</h5>
                    <p class="display-4">{{ $stats['pending_review'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Under Investigation</h5>
                    <p class="display-4">{{ $stats['under_investigation'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Verified True</h5>
                    <p class="display-4">{{ $stats['verified_true'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">By Status</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Pending Review</td>
                            <td><span class="badge bg-warning">{{ $stats['pending_review'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Under Investigation</td>
                            <td><span class="badge bg-info">{{ $stats['under_investigation'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Verified True</td>
                            <td><span class="badge bg-success">{{ $stats['verified_true'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Identified Fake</td>
                            <td><span class="badge bg-danger">{{ $stats['identified_fake'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <td><span class="badge bg-secondary">{{ $stats['rejected'] }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">By Category</h6>
                </div>
                <div class="card-body">
                    @if($stats['by_category']->count() > 0)
                        <table class="table">
                            @foreach($stats['by_category'] as $category => $count)
                                <tr>
                                    <td>{{ ucfirst(str_replace('_', ' ', $category)) }}</td>
                                    <td><span class="badge bg-secondary">{{ $count }}</span></td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-muted">No data available.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Resolved Rate</td>
                            <td>
                                @php
                                    $resolved = $stats['verified_true'] + $stats['identified_fake'] + $stats['rejected'];
                                    $rate = $stats['total'] > 0 ? round(($resolved / $stats['total']) * 100) : 0;
                                @endphp
                                {{ $rate }}%
                            </td>
                        </tr>
                        <tr>
                            <td>Verification Rate</td>
                            <td>
                                @php
                                    $verified = $stats['verified_true'] + $stats['identified_fake'];
                                    $vRate = $resolved > 0 ? round(($verified / $resolved) * 100) : 0;
                                @endphp
                                {{ $vRate }}%
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
