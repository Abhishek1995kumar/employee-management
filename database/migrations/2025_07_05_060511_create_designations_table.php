<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->string(column: 'name');
            $table->string(column: 'slug')->unique(indexName: 'slug')->nullable(value: false);
            $table->string(column: 'description')->nullable();
            $table->tinyInteger(column: 'created_by')->nullable();
            $table->tinyInteger(column:'updated_by')->nullable();
            $table->tinyInteger(column:'deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
