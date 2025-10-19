<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('subject_questions', function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable();
            $table->string('type')->comment('question, option')->nullable();
            $table->string('question_text');
            $table->string('name')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('required')->nullable()->comment('yes, no')->default('no');
            $table->integer('sequence')->nullable();
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
        Schema::dropIfExists('subject_questions');
    }
};
