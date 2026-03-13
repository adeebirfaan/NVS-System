@extends('layouts.app')

@section('title', 'User Statistics')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>User Statistics</h2>
        <a href="{{ route('mcmc.users.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Overview</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total Users</th>
                            <td class="h4">{{ $stats['total_users'] }}</td>
                        </tr>
                        <tr>
                            <th>Active Users</th>
                            <td class="h4 text-success">{{ $stats['active_users'] }}</td>
                        </tr>
                        <tr>
                            <th>Inactive Users</th>
                            <td class="h4 text-danger">{{ $stats['inactive_users'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Users by Role</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Public Users</th>
                            <td class="h4">{{ $stats['public_users'] }}</td>
                        </tr>
                        <tr>
                            <th>MCMC Staff</th>
                            <td class="h4 text-primary">{{ $stats['mcmc_staff'] }}</td>
                        </tr>
                        <tr>
                            <th>Agency Staff</th>
                            <td class="h4 text-info">{{ $stats['agency_staff'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
