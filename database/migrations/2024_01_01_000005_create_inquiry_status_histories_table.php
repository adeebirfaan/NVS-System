<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained('inquiries')->onDelete('cascade');
            $table->string('from_status', 50)->nullable();
            $table->string('to_status', 50);
            $table->text('notes')->nullable();
            $table->string('officer_name', 255)->nullable();
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('inquiry_id');
            $table->index('to_status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_status_histories');
    }
};
