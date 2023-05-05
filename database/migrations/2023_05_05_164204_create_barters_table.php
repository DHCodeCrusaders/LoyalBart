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
        Schema::create('barters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initiator_id');
            $table->foreignId('offered_program_id');
            $table->unsignedInteger('offered_points');
            $table->foreignId('requested_program_id');
            $table->unsignedInteger('requested_points');
            $table->foreignId('acceptor_id')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barters');
    }
};
