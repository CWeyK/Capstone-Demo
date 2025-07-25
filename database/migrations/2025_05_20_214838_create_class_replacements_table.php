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
        Schema::create('class_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->onDelete('cascade');
            $table->string('status');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_replacements');
    }
};
