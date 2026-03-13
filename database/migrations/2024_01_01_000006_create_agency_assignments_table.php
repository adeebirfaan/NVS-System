<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agency_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained('inquiries')->onDelete('cascade');
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('assignment_group_id')->nullable()->constrained('agency_assignments')->nullOnDelete();
            $table->text('assignment_notes')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'reassigned'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->index('inquiry_id');
            $table->index('agency_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agency_assignments');
    }
};
