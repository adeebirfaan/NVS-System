@extends('layouts.app')

@section('title', 'Change Password')

@section('styles')
<style>

body{
    background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
}

.change-password-container{
    min-height: calc(100vh - 140px);
    display:flex;
    align-items:center;
}

.change-password-card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:18px;
    box-shadow:0 10px 35px rgba(0,0,0,0.5);
    color:white;
}

.change-password-card .card-header{
    background:transparent;
    border-bottom:1px solid rgba(255,255,255,0.12);
    padding:18px 22px;
}

.change-password-title{
    font-family:'Orbitron', sans-serif;
    letter-spacing:1px;
    color:white;
}

.change-password-card .card-body{
    padding:24px 22px;
}

.change-password-card label{
    color:white;
}

.form-control{
    background: rgba(255,255,255,0.15);
    border:1px solid rgba(255,255,255,0.25);
    color:#111827;
    border-radius:12px;
    padding:12px;
    transition:0.3s;
}

.form-control:focus{
    background: rgba(255,255,255,0.25);
    border:1px solid #4facfe;
    box-shadow:0 0 12px rgba(79,172,254,0.6);
    color:#111827;
}

.form-control::placeholder{
    color:rgba(17,24,39,0.45);
}

.form-control.is-invalid{
    border-color:#ff6b6b;
}

.invalid-feedback{
    color:#ffd1d1;
}

.form-text{
    color:#e2e8f0;
}

.btn-change-password{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border:none;
    border-radius:10px;
    padding:10px 18px;
    font-weight:600;
    color:white;
    transition:0.3s;
}

.btn-change-password:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 18px rgba(0,242,254,0.35);
    color:white;
}

.btn-cancel-password{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.18);
    border-radius:10px;
    padding:10px 18px;
    font-weight:500;
    color:white;
    transition:0.3s;
}

.btn-cancel-password:hover{
    background: rgba(255,255,255,0.14);
    color:white;
}

</style>
@endsection


@section('content')
<div class="container change-password-container">

    <div class="row justify-content-center w-100">

        <div class="col-md-6 col-lg-5">

            <div class="card change-password-card">

                <div class="card-header">
                    <h5 class="change-password-title mb-0">Change Password</h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password">Current Password</label>

                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                name="current_password"
                                required
                            >

                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="password">New Password</label>

                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">Minimum 8 characters.</div>
                        </div>


                        <div class="mb-4">
                            <label for="password_confirmation">Confirm New Password</label>

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                            >
                        </div>


                        <div class="d-flex gap-2 flex-wrap">

                            <button type="submit" class="btn btn-change-password">
                                Change Password
                            </button>

                            <a href="{{ route('profile.show') }}" class="btn btn-cancel-password">
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