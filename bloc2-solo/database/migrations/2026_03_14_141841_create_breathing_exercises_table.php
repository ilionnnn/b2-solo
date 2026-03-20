<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercice_respiration', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->unsignedInteger('duree_inspiration');
            $table->unsignedInteger('duree_apnee')->default(0);
            $table->unsignedInteger('duree_expiration');
            $table->unsignedInteger('duree_totale');
            $table->unsignedInteger('nombre_cycles')->default(5);
            $table->string('type');
            $table->boolean('public')->default(true);
            $table->timestamp('date_creation')->useCurrent();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercice_respiration');
    }
};
