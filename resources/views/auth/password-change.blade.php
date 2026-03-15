@extends('layouts.app')

@section('title', 'Change Password')

@section('styles')
<style>

body{
    background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
}

/* center container */
.password-container{
    min-height: calc(100vh - 140px);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 15px;
}

/* glass card */
.password-card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border-radius:18px;
    border:1px solid rgba(255,255,255,0.15);
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
    padding:40px;
    color:white;
}

/* title */
.password-title{
    font-family:'Orbitron', sans-serif;
    letter-spacing:2px;
}

/* labels */
.password-card label,
.password-card p{
    color:white;
}

/* inputs */
.form-control{
    background: rgba(255,255,255,0.15);
    border:1px solid rgba(255,255,255,0.25);
    color:#111827;
    border-radius:12px;
    padding:12px;
}

/* placeholder */
.form-control::placeholder{
    color:rgba(0,0,0,0.4);
}

/* focus glow */
.form-control:focus{
    background: rgba(255,255,255,0.25);
    border:1px solid #4facfe;
    box-shadow:0 0 10px rgba(79,172,254,0.6);
}

/* helper text */
.form-text{
    color:rgba(255,255,255,0.8);
}

/* button */
.password-btn{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    letter-spacing:1px;
    color:white;
    transition:0.3s;
}

/* hover */
.password-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,242,254,0.5);
}

</style>
@endsection


@section('content')
<div class="container password-container">

    <div class="col-md-6 col-lg-5">

        <div class="card password-card">

            <h3 class="text-center mb-3 password-title">
                <i class="bi bi-key"></i> Change Password
            </h3>

            <p class="text-center mb-4">
                You must change your password before continuing.
            </p>

            <form method="POST" action="{{ route('password.change') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_password">Current Password</label>
                    <input type="password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        id="current_password"
                        name="current_password"
                        placeholder="Enter current password"
                        required>

                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="Enter new password"
                        required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-text">Minimum 8 characters.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        required>
                </div>

                <button type="submit" class="btn password-btn w-100">
                    Change Password
                </button>

            </form>

        </div>

    </div>

</div>
@endsection