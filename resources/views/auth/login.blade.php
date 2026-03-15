@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .login-container{
        min-height: calc(100vh - 140px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 15px;
    }

    .login-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        padding: 40px;
        color: white;
    }

    .login-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 2px;
        color: white;
    }

    .login-subtitle{
        color: rgba(255,255,255,0.85);
        font-weight: 500;
    }

    .login-card label,
    .login-card .form-check-label,
    .login-card p,
    .login-card a{
        color: white;
    }

    .form-control{
        background: rgba(255,255,255,0.15);
        border:1px solid rgba(255,255,255,0.25);
        color:#1f2937;   /* dark text */
        border-radius:10px;
        padding:12px;
        transition:0.3s;
    }

    .form-control:focus{
        background: rgba(255,255,255,0.25);
        border:1px solid #4facfe;
        box-shadow:0 0 10px #4facfe;
        color:#111827;   /* dark when typing */
    }

    .form-control::placeholder{
        color: rgba(255,255,255,0.6);
    }

    .form-control.is-invalid{
        border-color: #ff6b6b;
    }

    .invalid-feedback{
        color: #ffd1d1;
    }

    label{
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-check-input{
        background-color: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .form-check-input:checked{
        background-color: #4facfe;
        border-color: #4facfe;
    }

    .login-btn{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: 0.3s;
        color: white;
    }

    .login-btn:hover{
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,242,254,0.45);
        color: white;
    }

    .login-link{
        color: #8fd3ff !important;
        text-decoration: none;
        transition: 0.3s;
    }

    .login-link:hover{
        color: #ffffff !important;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container login-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="card-body p-0">
                    <h3 class="text-center mb-3 login-title">
                        <i class="bi bi-shield-check"></i> NVS-System
                    </h3>

                    <h5 class="text-center mb-4 login-subtitle">Login</h5>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                autofocus
                            >
                            @error('email')
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

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <button type="submit" class="btn login-btn w-100">
                            Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-2">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="login-link">Register here</a>
                        </p>
                        <p class="mt-2 mb-0">
                            <a href="{{ route('password.request') }}" class="login-link">Forgot your password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection