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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            
            $table->string('subject');
            $table->timestamp('time');

            $table->foreignId('trainee_id');
            $table->foreign('trainee_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('advisor_id');
            $table->foreign('advisor_id')->references('id')->on('users')->cascadeOnDelete();

            $table->text('url')->nullable();
            $table->boolean('is_accepted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
