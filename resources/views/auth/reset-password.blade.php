@extends('layouts.app')

@section('title', 'Reset Password')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .reset-container{
        min-height: calc(100vh - 140px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 15px;
    }

    .reset-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        padding: 40px;
        color: white;
    }

    .reset-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 2px;
        color: white;
    }

    .reset-card label,
    .reset-card p,
    .reset-card a{
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

    .form-control.is-invalid{
        border-color: #ff6b6b;
    }

    .invalid-feedback{
        color: #ffd1d1;
    }

    .reset-btn{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: 0.3s;
        color: white;
    }

    .reset-btn:hover{
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,242,254,0.45);
        color: white;
    }

    .reset-link{
        color: #8fd3ff !important;
        text-decoration: none;
    }

    .reset-link:hover{
        color: white !important;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container reset-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card reset-card">
                <div class="card-body p-0">
                    <h3 class="text-center mb-4 reset-title">
                        <i class="bi bi-key"></i> Reset Password
                    </h3>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Enter new password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm new password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn reset-btn w-100">
                            Reset Password
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="reset-link">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection