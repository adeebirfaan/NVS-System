@extends('layouts.app')

@section('title', 'Edit Profile')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .edit-profile-container{
        min-height: calc(100vh - 140px);
        padding: 40px 0;
        display: flex;
        align-items: center;
    }

    .edit-profile-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
    }

    .edit-profile-card .card-header{
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px 18px 0 0 !important;
        padding: 18px 22px;
    }

    .edit-profile-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
        color: white;
        margin: 0;
    }

    .edit-profile-card .card-body{
        padding: 24px 22px;
    }

    .edit-profile-card label,
    .edit-profile-card .form-text{
        color: white;
    }

    .form-control{
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #111827;
        border-radius: 12px;
        padding: 12px 14px;
        transition: 0.3s;
    }

    .form-control:focus{
        background: rgba(255,255,255,0.25);
        border: 1px solid #4facfe;
        box-shadow: 0 0 12px rgba(79,172,254,0.6);
        color: #111827;
    }

    .form-control::placeholder{
        color: rgba(17,24,39,0.45);
    }

    textarea.form-control{
        resize: none;
    }

    .form-control.is-invalid{
        border-color: #ff6b6b;
    }

    .invalid-feedback{
        color: #ffd1d1;
    }

    .verified-text{
        color: #bbf7d0 !important;
    }

    .warning-text{
        color: #fde68a !important;
    }

    .btn-update-profile{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        color: white;
        transition: 0.3s;
    }

    .btn-update-profile:hover{
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,242,254,0.35);
        color: white;
    }

    .btn-cancel-profile{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 500;
        color: white;
        transition: 0.3s;
    }

    .btn-cancel-profile:hover{
        background: rgba(255,255,255,0.14);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container edit-profile-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-6">
            <div class="card edit-profile-card">
                <div class="card-header">
                    <h5 class="edit-profile-title">Edit Profile</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($user->hasVerifiedEmail())
                                <div class="form-text verified-text">Email is verified.</div>
                            @else
                                <div class="form-text warning-text">Changing email will require re-verification.</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Enter your phone number"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label">Address</label>
                            <textarea
                                class="form-control"
                                id="address"
                                name="address"
                                rows="3"
                                placeholder="Enter your address"
                            >{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-update-profile">
                                Update Profile
                            </button>

                            <a href="{{ route('profile.show') }}" class="btn btn-cancel-profile">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection