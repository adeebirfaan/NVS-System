@extends('layouts.app')

@section('title', 'Agency Details')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-building" style="font-size: 4rem;"></i>
                    </div>
                    <h4>{{ $agency->name }}</h4>
                    <span class="badge bg-secondary">{{ $agency->code }}</span>
                    @if($agency->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Agency Details</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <td>{{ $agency->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $agency->name }}</td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td>{{ $agency->code }}</td>
                        </tr>
                        <tr>
                            <th>Contact Email</th>
                            <td>{{ $agency->contact_email }}</td>
                        </tr>
                        <tr>
                            <th>Contact Phone</th>
                            <td>{{ $agency->contact_phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $agency->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $agency->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $agency->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Agency Staff ({{ $agency->users->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($agency->users->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agency->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No staff members assigned to this agency.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('mcmc.agencies.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
