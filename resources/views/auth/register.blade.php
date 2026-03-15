@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .register-container{
        min-height: calc(100vh - 140px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 15px;
    }

    .register-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        padding: 40px;
        color: white;
    }

    .register-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 2px;
        color: white;
    }

    .register-subtitle{
        color: rgba(255,255,255,0.85);
        font-weight: 500;
    }

    .register-card label,
    .register-card p,
    .register-card a,
    .register-card .form-text{
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

    .register-btn{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: 0.3s;
        color: white;
    }

    .register-btn:hover{
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,242,254,0.45);
        color: white;
    }

    .register-link{
        color: #8fd3ff !important;
        text-decoration: none;
        transition: 0.3s;
    }

    .register-link:hover{
        color: #ffffff !important;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container register-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6">
            <div class="card register-card">
                <div class="card-body p-0">
                    <h3 class="text-center mb-3 register-title">
                        <i class="bi bi-shield-check"></i> NVS-System
                    </h3>

                    <h5 class="text-center mb-4 register-subtitle">Register as Public User</h5>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number (Optional)</label>
                            <input
                                type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Enter your phone number"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address (Optional)</label>
                            <textarea
                                class="form-control @error('address') is-invalid @enderror"
                                id="address"
                                name="address"
                                rows="2"
                                placeholder="Enter your address"
                            >{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn register-btn w-100">
                            Register
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="register-link">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection