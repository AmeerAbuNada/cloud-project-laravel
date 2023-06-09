<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['trainee', 'manager', 'advisor'])->default('trainee');
            $table->string('image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('id_card')->nullable();
            $table->longText('accomplishments')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->string('type')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'Ameer Abunada',
            'email' => 'ameer@app.com',
            'password' => bcrypt('amir1212'),
            'role' => 'manager',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
