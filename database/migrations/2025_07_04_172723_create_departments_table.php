<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the department');
            $table->string('slug')->unique();
            $table->string('description')->nullable()->comment('Description of the department');
            $table->string('status')->default('active')->comment('1=active, 2=archived, 0=inactive');
            $table->string('created_by')->nullable()->comment('User ID of the creator');
            $table->string('updated_by')->nullable()->comment('User ID of the last updater');
            $table->string('deleted_reason')->nullable()->comment('Reason for deletion, if applicable'); // 
            $table->softDeletes()->comment('For soft delete functionality');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('departments');
    }


};
