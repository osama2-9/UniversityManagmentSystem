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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained('quiz_attempts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('answer_id')->nullable()->constrained('answers')->onDelete('cascade')->onUpdate('cascade');
            $table->text('submitted_answer')->nullable();
            $table->date('created_at')->default(now());
            $table->date('updated_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
