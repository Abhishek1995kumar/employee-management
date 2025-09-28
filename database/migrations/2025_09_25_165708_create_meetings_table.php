<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('data getting from users table');
            $table->string('client_name');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('meeting_time');
            $table->integer('distance_time');
            $table->integer('distance_in_km')->comment('distance in kilometer');
            $table->integer('duration_in_minutes')->comment('distance coverd in total minutes');
            $table->date('meeting_date')->comment('which date meeting schedule');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
