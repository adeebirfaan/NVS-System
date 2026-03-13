@extends('layouts.app')

@section('title', 'Submit Inquiry')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Submit News for Verification</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Submit news content, social media posts, or messages that you want us to verify for authenticity.
                    </p>

                    <form method="POST" action="{{ route('inquiries.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Brief title for your inquiry" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
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
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" 
                                      placeholder="Provide detailed information about the content you want verified. Include the full text, context, and any other relevant details." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 20 characters. Be as detailed as possible.</div>
                        </div>

                        <div class="mb-3">
                            <label for="source_url" class="form-label">Source URL (if available)</label>
                            <input type="url" class="form-control @error('source_url') is-invalid @enderror" 
                                   id="source_url" name="source_url" value="{{ old('source_url') }}"
                                   placeholder="https://example.com/article">
                            @error('source_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Link to the original source of the content (optional).</div>
                        </div>

                        <div class="mb-3">
                            <label for="evidences" class="form-label">Supporting Evidence</label>
                            <input type="file" class="form-control @error('evidences.*') is-invalid @enderror" 
                                   id="evidences" name="evidences[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                            @error('evidences.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload screenshots, photos, or documents. Max 10MB per file. Allowed types: jpg, png, gif, pdf, doc, docx.</div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3"
                                      placeholder="Any additional information or context that might help...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_public" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">
                                Make this inquiry public when resolved
                            </label>
                            <div class="form-text">If checked, the final result (verified true/fake) will be visible to everyone.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit Inquiry</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
