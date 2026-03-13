@extends('layouts.app')

@section('title', 'My Profile')

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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile Details</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">Edit Profile</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                {{ $user->email }}
                                @if(!$user->hasVerifiedEmail())
                                    <span class="badge bg-warning">Unverified</span>
                                @else
                                    <span class="badge bg-success">Verified</span>
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
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
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
