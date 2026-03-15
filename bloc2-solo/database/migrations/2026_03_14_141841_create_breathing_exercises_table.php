<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breathing_exercises', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->integer('inhale_duration');

            $table->integer('hold_duration')->nullable();

            $table->integer('exhale_duration');

            $table->integer('cycles');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breathing_exercises');
    }
};
