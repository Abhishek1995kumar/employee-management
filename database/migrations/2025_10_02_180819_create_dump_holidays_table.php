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
        Schema::create('dump_holidays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('error_excel_report_id');
            $table->string('branch_id');
            $table->string('branch_name');
            $table->string('holiday_name');
            $table->string('holiday_category');
            $table->string('holiday_day');
            $table->string('holiday_month');
            $table->string('holiday_year');
            $table->string('holiday_color');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('holiday_image')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('has_errors')->comment('1=find error, 0=success');
            $table->longText('errors')->nullable();
            $table->tinyInteger('is_processed')->comment('0=process complete, 1=process failed, 2=process pending');
            $table->tinyInteger('is_validated')->comment('0=validation failed, 1=validate')->default(0);
            $table->tinyInteger('status')->comment('0=error, 1=success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dump_holidays');
    }
};
