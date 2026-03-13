<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_evidences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained('inquiries')->onDelete('cascade');
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('file_type', 50)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('description', 500)->nullable();
            $table->timestamps();

            $table->index('inquiry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_evidences');
    }
};
