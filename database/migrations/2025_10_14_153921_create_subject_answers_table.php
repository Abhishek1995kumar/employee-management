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
        Schema::create('subject_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->string('type')->nullable();
            $table->string('question_text');
            $table->string('option_text')->nullable();
            $table->integer('next_question_id')->nullable();
            $table->integer('previous_question_id')->nullable();
            $table->string('flag')->nullable();
            $table->string('validation_rules')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_answers');
    }
};
