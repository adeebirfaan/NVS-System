<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('inquiry_number', 20)->unique();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['news', 'social_media', 'message', 'video', 'image', 'other'])->default('other');
            $table->string('source_url', 500)->nullable();
            $table->string('content_snippet', 1000)->nullable();
            $table->enum('status', [
                'pending_review',
                'under_investigation',
                'verified_true',
                'identified_fake',
                'rejected'
            ])->default('pending_review');
            $table->boolean('is_public')->default(false);
            $table->text('mcmc_notes')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->string('submission_ip', 45)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('inquiry_number');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
