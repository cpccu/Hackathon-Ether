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
        Schema::create('events', function (Blueprint $table) {
             $table->id();
             $table->foreignId('event_category_id')->constrained()->onDelete('cascade');
             $table->string('title');
             $table->string('banner'); // Stores the webp path
             $table->dateTime('date_time');
             $table->string('location');
             $table->text('description');
             $table->string('tags')->nullable();
             $table->json('custom_fields')->nullable(); // Stores extra info needed like payment method, trx id, etc.
             $table->timestamps();
        });
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
