@extends('layouts.app')

@section('title', 'Reset Email Preview')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .mail-preview-container{
        min-height: calc(100vh - 140px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 15px;
    }

    .preview-shell{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.45);
        padding: 28px;
        color: white;
    }

    .preview-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1.5px;
        color: #fff;
    }

    .demo-pill{
        display: inline-block;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(79,172,254,0.15);
        border: 1px solid rgba(79,172,254,0.35);
        color: #cfe9ff;
        font-size: 0.9rem;
    }

    .mail-window{
        margin-top: 20px;
        background: rgba(10,16,32,0.72);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0,0,0,0.30);
    }

    .mail-topbar{
        background: rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mail-dot{
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.35);
    }

    .mail-header{
        padding: 22px 22px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .mail-subject{
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 16px;
    }

    .mail-meta{
        display: grid;
        gap: 8px;
        color: rgba(255,255,255,0.82);
        font-size: 0.95rem;
    }

    .mail-meta strong{
        color: #fff;
        min-width: 56px;
        display: inline-block;
    }

    .mail-body{
        padding: 24px 22px 26px;
        color: rgba(255,255,255,0.90);
        line-height: 1.75;
    }

    .mail-body p{
        margin-bottom: 14px;
    }

    .mail-cta{
        display: inline-block;
        margin: 16px 0 12px;
        padding: 12px 20px;
        border-radius: 12px;
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        color: white;
        text-decoration: none;
        font-weight: 600;
        letter-spacing: 0.4px;
        transition: 0.25s ease;
        box-shadow: 0 8px 18px rgba(0,242,254,0.20);
    }

    .mail-cta:hover{
        transform: translateY(-1px);
        color: white;
        box-shadow: 0 10px 22px rgba(0,242,254,0.28);
    }

    .mail-link-box{
        margin-top: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.10);
        font-size: 0.9rem;
        color: #dbeafe;
        word-break: break-all;
    }

    .preview-actions{
        margin-top: 22px;
        display: grid;
        gap: 12px;
    }

    .preview-btn{
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: 0.25s ease;
    }

    .preview-btn-primary{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        color: white;
        border: none;
    }

    .preview-btn-primary:hover{
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(0,242,254,0.28);
    }

    .preview-btn-secondary{
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.14);
        color: white;
    }

    .preview-btn-secondary:hover{
        color: white;
        background: rgba(255,255,255,0.10);
    }

    .preview-note{
        margin-top: 16px;
        color: rgba(255,255,255,0.72);
        font-size: 0.92rem;
    }
</style>
@endsection

@section('content')
<div class="container mail-preview-container">
    <div class="row justify-content-center w-100">
        <div class="col-lg-8 col-xl-7">
            <div class="preview-shell">
                <div class="text-center mb-3">
                    <span class="demo-pill">Demo Email Preview</span>
                </div>

                <h3 class="text-center preview-title mb-2">
                    <i class="bi bi-envelope-paper-heart"></i> Password Reset Email
                </h3>

                <p class="text-center mb-0" style="color: rgba(255,255,255,0.78);">
                    This simulates the email your system would send in a production environment.
                </p>

                <div class="mail-window">
                    <div class="mail-topbar">
                        <span class="mail-dot"></span>
                        <span class="mail-dot"></span>
                        <span class="mail-dot"></span>
                    </div>

                    <div class="mail-header">
                        <div class="mail-subject">Reset Your NVS-System Password</div>

                        <div class="mail-meta">
                            <div><strong>From:</strong> NVS-System &lt;noreply@nvs-system.demo&gt;</div>
                            <div><strong>To:</strong> {{ $email }}</div>
                            <div><strong>Date:</strong> {{ now()->format('d M Y, h:i A') }}</div>
                        </div>
                    </div>

                    <div class="mail-body">
                        <p>Hello,</p>

                        <p>We received a request to reset the password for your NVS-System account associated with <strong>{{ $email }}</strong>.</p>

                        <p>Click the button below to choose a new password:</p>

                        <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="mail-cta">
                            Reset Password
                        </a>

                        <p>If the button does not work, use this link:</p>

                        <div class="mail-link-box">
                            {{ route('password.reset', ['token' => $token, 'email' => $email]) }}
                        </div>

                        <p class="mt-3">If you did not request a password reset, you can ignore this message.</p>

                        <p>Regards,<br>NVS-System Security Team</p>
                    </div>
                </div>

                <div class="preview-actions">
                    <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}"
                       class="preview-btn preview-btn-primary">
                        Open Reset Page
                    </a>

                    <a href="{{ route('login') }}" class="preview-btn preview-btn-secondary">
                        Back to Login
                    </a>
                </div>

                <p class="text-center preview-note">
                    For demonstration purposes, this page previews the reset email instead of sending it to a real inbox.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection