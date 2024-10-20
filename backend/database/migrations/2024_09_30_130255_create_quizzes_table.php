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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade')->onUpdate('cascade');
            $table->string('quiz_title');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('total_marks');
            $table->boolean('isQuizActive')->default(false);
            $table->date('created_at')->default(now());
            $table->date('updated_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qiuzs');
    }
};
