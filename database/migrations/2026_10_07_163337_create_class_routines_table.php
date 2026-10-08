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
        Schema::create('class_routines', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->string('day'); // e.g., Sunday, Monday
            $table->string('course_title');
            $table->string('course_code');
            $table->string('course_teacher');
            $table->string('room');
            $table->string('class_time');
            $table->boolean('is_cancelled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_routines');
    }
};
