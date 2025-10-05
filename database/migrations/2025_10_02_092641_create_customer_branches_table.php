<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer_branches', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('branch_id');
            $table->string('branch_name');
            $table->string('branch_city')->nullable();
            $table->string('branch_state')->nullable();
            $table->string('branch_country')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=active, 0=inactive')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_branches');
    }
};
