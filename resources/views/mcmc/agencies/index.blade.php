@extends('layouts.app')

@section('title', 'Manage Agencies')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Agencies</h2>
        <a href="{{ route('mcmc.agencies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Agency
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or code" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Contact Email</th>
                        <th>Contact Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agencies as $agency)
                        <tr>
                            <td>{{ $agency->id }}</td>
                            <td><span class="badge bg-secondary">{{ $agency->code }}</span></td>
                            <td>{{ $agency->name }}</td>
                            <td>{{ $agency->contact_email }}</td>
                            <td>{{ $agency->contact_phone ?? '-' }}</td>
                            <td>
                                @if($agency->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('mcmc.agencies.show', $agency) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('mcmc.agencies.edit', $agency) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('mcmc.agencies.destroy', $agency) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No agencies found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $agencies->links() }}
        </div>
    </div>
</div>
@endsection
