@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-envelope-check" style="font-size: 4rem; color: #0d6efd;"></i>
                    <h3 class="mt-4">Verify Your Email Address</h3>
                    <p class="text-muted mt-3">
                        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                    </p>
                    
                    @if(session('resent'))
                        <div class="alert alert-success">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <p class="text-muted">
                        If you didn't receive the email, we will gladly send you another.
                    </p>

                    <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
