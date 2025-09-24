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
            $table->integer("module_id")->comment('module id getting from modules table');
            $table->string("module_name")->nullable()->comment('module name getting from modules table');
            $table->string("name")->unique();
            $table->string("slug")->unique();
            $table->string("app_url")->unique();
            $table->string("app_url_slug")->unique();
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
