<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_bios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->text('biography')->nullable();
            $table->date('date_of_birth');
            $table->string('education_background', 1000)->nullable();
            $table->string('professional_background', 1000)->nullable();
            $table->string('campaign_promises', 2000)->nullable();
            $table->string('achievements', 1000)->nullable();  
            $table->string('social_media_handles')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_bios');
    }
};
