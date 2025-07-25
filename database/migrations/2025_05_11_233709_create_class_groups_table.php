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
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_class_id')->constrained('subject_classes')->cascadeOnDelete();
            $table->integer('group');
            $table->integer('capacity')->default(0);
            $table->foreignId('lecturer')->nullable(); 
            $table->foreign('lecturer')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_groups');
    }
};
