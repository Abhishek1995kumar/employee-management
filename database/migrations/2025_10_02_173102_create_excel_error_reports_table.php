<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('excel_error_reports', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id');
            $table->bigInteger('department_id')->nullable();
            $table->unsignedBigInteger('document_type_id');
            $table->string('original_document_url')->nullable();
            $table->string('error_document_url')->nullable();
            $table->tinyInteger('has_errors')->nullable();
            $table->longText('errors')->nullable();
            $table->tinyInteger('is_processed')->nullable()->comment('1=Complete, 2=Pending')->default(2);
            $table->tinyInteger('is_validated')->nullable()->comment('1=Validate, 2=Not validate')->default(2);
            $table->tinyInteger('status')->nullable()->comment('1=Success, 2=Failed')->default(2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excel_error_reports');
    }
};
