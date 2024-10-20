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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('email')->unique();
            $table->string('phone', 15)->unique();
            $table->enum('gender', ['male', 'female']);
            $table->string('semester', 8);
            $table->string('college');
            $table->string('major');
            $table->decimal('balance', 8, 2)->default(0.00);
            $table->date('date_of_birth');
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
