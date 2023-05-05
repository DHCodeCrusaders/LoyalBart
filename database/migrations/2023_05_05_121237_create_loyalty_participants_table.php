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
        Schema::create('loyalty_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loyalty_program_id');
            $table->foreignId('participant_id');
            $table->integer('points');
            $table->unique(['loyalty_program_id', 'participant_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_participants');
    }
};
