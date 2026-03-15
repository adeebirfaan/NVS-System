@extends('layouts.app')

@section('title', 'Forgot Password')

@section('styles')
<style>
body{
    background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
}

/* center container */
.forgot-container{
    min-height: calc(100vh - 140px);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 15px;
}

/* glass card */
.forgot-card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius:18px;
    border:1px solid rgba(255,255,255,0.15);
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
    padding:40px;
    color:white;
}

/* title */
.forgot-title{
    font-family:'Orbitron', sans-serif;
    letter-spacing:2px;
}

/* description text */
.forgot-card p,
.forgot-card label,
.forgot-card a{
    color:white;
}

/* input */
.form-control{
    background: rgba(255,255,255,0.15);
    border:1px solid rgba(255,255,255,0.25);
    color:#111827;
    border-radius:12px;
    padding:12px;
}

.form-control:focus{
    background: rgba(255,255,255,0.25);
    border:1px solid #4facfe;
    box-shadow:0 0 10px rgba(79,172,254,0.6);
}

/* button */
.forgot-btn{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    letter-spacing:1px;
    color:white;
    transition:0.3s;
}

.forgot-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,242,254,0.5);
}

/* link */
.forgot-link{
    color:#8fd3ff;
    text-decoration:none;
}

.forgot-link:hover{
    color:white;
    text-decoration:underline;
}

/* alert */
.alert{
    border:none;
    border-radius:10px;
}

</style>
@endsection


@section('content')
<div class="container forgot-container">

    <div class="col-md-6 col-lg-5">

        <div class="card forgot-card">

            <h3 class="text-center mb-3 forgot-title">
                <i class="bi bi-key"></i> Forgot Password
            </h3>

            <p class="text-center mb-4">
                Enter your email address and we'll send you a link to reset your password.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email">Email Address</label>

                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        required
                        autofocus>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn forgot-btn w-100">
                    Send Password Reset Link
                </button>

            </form>

            <div class="text-center mt-4">
                <p class="mb-0">
                    Remember your password?
                    <a href="{{ route('login') }}" class="forgot-link">
                        Login here
                    </a>
                </p>
            </div>

        </div>

    </div>

</div>
@endsection