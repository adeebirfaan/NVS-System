@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <span class="badge bg-{{ $user->role == 'mcmc' ? 'primary' : ($user->role == 'agency' ? 'info' : 'secondary') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->must_change_password)
                        <span class="badge bg-warning">Must Change Password</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Details</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
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
                        <tr>
                            <th>Agency</th>
                            <td>{{ $user->agency->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('mcmc.users.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
