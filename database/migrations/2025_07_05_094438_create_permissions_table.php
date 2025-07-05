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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->string("description")->nullable();
            $table->tinyInteger("status")->nullable()->comment('1=active permission, 0=inactive permission')->default(1);
            $table->tinyInteger("created_by")->nullable();
            $table->tinyInteger("updated_by")->nullable();
            $table->tinyInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
