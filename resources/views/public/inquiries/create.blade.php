@extends('layouts.app')

@section('title', 'Submit Inquiry')

@section('styles')
<style>
    body{
        background: url("{{ asset('NVS bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .page-container{
        min-height: calc(100vh - 140px);
        padding: 40px 0;
    }

    .glass-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
        color: white;
    }

    .glass-card .card-header{
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px 18px 0 0 !important;
        padding: 18px 22px;
    }

    .glass-title{
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
        color: white;
        margin: 0;
        font-size: 1.05rem;
    }

    .glass-card .card-body{
        padding: 24px 22px;
    }

    .intro-text{
        color: rgba(255,255,255,0.78);
        margin-bottom: 20px;
    }

    .glass-card label,
    .glass-card .form-text,
    .glass-card .form-check-label{
        color: white;
    }

    .required-mark{
        color: #fca5a5;
    }

    .form-control,
    .form-select{
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #111827;
        border-radius: 12px;
        padding: 12px 14px;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus{
        background: rgba(255,255,255,0.25);
        border: 1px solid #4facfe;
        box-shadow: 0 0 12px rgba(79,172,254,0.6);
        color: #111827;
    }

    .form-control::placeholder{
        color: rgba(17,24,39,0.45);
    }

    textarea.form-control{
        resize: vertical;
        min-height: 110px;
    }

    .form-control.is-invalid,
    .form-select.is-invalid{
        border-color: #ff6b6b;
    }

    .invalid-feedback{
        color: #ffd1d1;
    }

    .form-text{
        color: rgba(255,255,255,0.72) !important;
    }

    .form-check-input{
        background-color: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .form-check-input:checked{
        background-color: #4facfe;
        border-color: #4facfe;
    }

    .btn-modern{
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-modern:hover{
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.35);
    }

    .btn-submit{
        background: linear-gradient(135deg,#4facfe,#00f2fe);
        border: none;
        color: white;
    }

    .btn-submit:hover{
        color: white;
    }

    .btn-cancel{
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        color: white;
    }

    .btn-cancel:hover{
        background: rgba(255,255,255,0.14);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container page-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card glass-card">
                <div class="card-header">
                    <h5 class="glass-title">Submit News for Verification</h5>
                </div>

                <div class="card-body">
                    <p class="intro-text">
                        Submit news content, social media posts, or messages that you want us to verify for authenticity.
                    </p>

                    <form method="POST" action="{{ route('inquiries.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Title <span class="required-mark">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Brief title for your inquiry"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">
                                Category <span class="required-mark">*</span>
                            </label>
                            <select
                                class="form-select @error('category') is-invalid @enderror"
                                id="category"
                                name="category"
                                required
                            >
                                <option value="">Select a category</option>
                                <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>News Article</option>
                                <option value="social_media" {{ old('category') == 'social_media' ? 'selected' : '' }}>Social Media Post</option>
                                <option value="message" {{ old('category') == 'message' ? 'selected' : '' }}>Message/Text</option>
                                <option value="video" {{ old('category') == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="image" {{ old('category') == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description <span class="required-mark">*</span>
                            </label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Provide detailed information about the content you want verified. Include the full text, context, and any other relevant details."
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 20 characters. Be as detailed as possible.</div>
                        </div>

                        <div class="mb-3">
                            <label for="source_url" class="form-label">Source URL (if available)</label>
                            <input
                                type="url"
                                class="form-control @error('source_url') is-invalid @enderror"
                                id="source_url"
                                name="source_url"
                                value="{{ old('source_url') }}"
                                placeholder="https://example.com/article"
                            >
                            @error('source_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Link to the original source of the content (optional).</div>
                        </div>

                        <div class="mb-3">
                            <label for="evidences" class="form-label">Supporting Evidence</label>
                            <input
                                type="file"
                                class="form-control @error('evidences.*') is-invalid @enderror"
                                id="evidences"
                                name="evidences[]"
                                multiple
                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx"
                            >
                            @error('evidences.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Upload screenshots, photos, or documents. Max 10MB per file. Allowed types: jpg, png, gif, pdf, doc, docx.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea
                                class="form-control @error('notes') is-invalid @enderror"
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Any additional information or context that might help..."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="is_public"
                                name="is_public"
                                value="1"
                                {{ old('is_public') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="is_public">
                                Make this inquiry public when resolved
                            </label>
                            <div class="form-text">
                                If checked, the final result (verified true/fake) will be visible to everyone.
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-submit btn-modern">Submit Inquiry</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-cancel btn-modern">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection