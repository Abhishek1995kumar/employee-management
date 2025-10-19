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
        Schema::create('subject_interviews', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id')->nullable();
            $table->string('interview_name')->nullable();
            $table->string('interview_time')->nullable();
            $table->date('interview_date')->nullable();
            $table->integer('attempted')->nullable();
            $table->tinyInteger('status')->comment('1=active, 0=inactive');
            $table->tinyInteger('created_by')->nullable();
            $table->string('created_name')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->string('updated_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('subject_interviews');
    }
};
