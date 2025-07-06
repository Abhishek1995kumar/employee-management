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
        Schema::create('route_permission', function (Blueprint $table) {
            $table->id();
            $table->string("route_name");
            $table->integer("permission_id");
            $table->tinyInteger("status")->nullable()->comment('1=active role, 0=inactive role')->default(1);
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
        Schema::dropIfExists('route_permission');
    }
};
