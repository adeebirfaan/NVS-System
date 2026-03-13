@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit User</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mcmc.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="public" {{ old('role', $user->role) == 'public' ? 'selected' : '' }}>Public User</option>
                                <option value="mcmc" {{ old('role', $user->role) == 'mcmc' ? 'selected' : '' }}>MCMC Staff</option>
                                <option value="agency" {{ old('role', $user->role) == 'agency' ? 'selected' : '' }}>Agency Staff</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="agencyField" style="display: {{ $user->role == 'agency' ? 'block' : 'none' }};">
                            <label for="agency_id" class="form-label">Agency</label>
                            <select class="form-select" id="agency_id" name="agency_id">
                                <option value="">Select Agency</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->id }}" {{ old('agency_id', $user->agency_id) == $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('mcmc.users.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                    <hr>

                    <form method="POST" action="{{ route('mcmc.users.reset-password', $user) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Reset Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password">
                        </div>
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Reset password for this user?')">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('role').addEventListener('change', function() {
        const agencyField = document.getElementById('agencyField');
        agencyField.style.display = this.value === 'agency' ? 'block' : 'none';
    });
</script>
@endsection
