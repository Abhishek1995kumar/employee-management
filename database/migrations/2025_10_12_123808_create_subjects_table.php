<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->comment('1=active subject, 0=inactive');
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
        Schema::dropIfExists('subjects');
    }
};
