<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('created_name')->nullable();
            $table->string('holiday_name');
            $table->string('day_of_holiday');
            $table->string('month_of_holiday');
            $table->string('year_of_holiday');
            $table->date('holiday_start_date');
            $table->date('holiday_end_date');
            $table->string('holiday_image')->nullable();
            $table->string('color');
            $table->string('description')->nullable();
            $table->tinyInteger('category')->comment('1=National Holiday, 2=State Holiday')->default(1)->nullable();
            $table->tinyInteger('status')->comment('1=Active, 2=Inactive')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void {
        Schema::dropIfExists('holidays');
    }
};
