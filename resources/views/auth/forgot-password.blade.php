@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">
                        <i class="bi bi-key"></i> Forgot Password
                    </h3>
                    <p class="text-center text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">Remember your password? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
