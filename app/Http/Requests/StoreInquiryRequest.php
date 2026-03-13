<?php

namespace App\Http\Requests;

use App\Models\Inquiry;
use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPublic();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20|max:5000',
            'source_url' => 'nullable|string|url|max:500',
            'category' => 'required|in:' . implode(',', Inquiry::CATEGORIES),
            'notes' => 'nullable|string|max:1000',
            'evidences.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:10240',
            'is_public' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for your inquiry.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Please provide details about the news content you want verified.',
            'description.min' => 'Description must be at least 20 characters.',
            'description.max' => 'Description cannot exceed 5000 characters.',
            'source_url.url' => 'Please provide a valid URL.',
            'category.required' => 'Please select a category.',
            'category.in' => 'Invalid category selected.',
            'evidences.*.max' => 'Each file cannot exceed 10MB.',
            'evidences.*.mimes' => 'Allowed file types: jpg, jpeg, png, gif, pdf, doc, docx.',
        ];
    }
}
