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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->nullable()->constrained('elections')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete(); 
            $table->string('token');
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_used')->default(false);
            $table->dateTime('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};
