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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id')->nullable()->comment('Department id fetch from department table');
            $table->integer('designation_id')->nullable()->comment('Designation id fetch from designation table');
            $table->integer('role_id')->nullable()->comment('role id fetch from roles table');
            $table->string('name');
            $table->string('username')->unique()->comment('Unique username for the user');
            $table->longText('profile_picture')->nullable();
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->string('email_verified_at')->nullable();
            // $table->string('slug')->unique()->comment('Unique slug for the user, typically derived from the name or username');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('status')->default(1)->comment('1=active, 2=archived, 0=inactive');
            $table->integer('created_by')->nullable()->comment('User ID of the creator');
            $table->integer('updated_by')->nullable()->comment('User ID of the last updater');
            $table->string('api_token')->nullable();
            $table->string('api_token_expiry')->nullable();
            $table->string('is_otp_verified')->nullable()->comment('0=not verify, 1=varified, 2=pending varification');
            $table->softDeletes()->comment('Timestamp when the user was deleted, if applicable');
            $table->rememberToken()->comment('Token for remembering the user session');
            $table->timestamps();
            $table->string('last_login_ip')->nullable()->comment('IP address of the last login');
            $table->string('login_status')->nullable()->comment('1=user is currently logged in, 2=user is currently logout, 0=user is currently inactive')->default(1);
            $table->timestamp('last_login_at')->nullable()->comment('Timestamp of the last login');
            $table->string('last_login_browser')->nullable()->comment('Browser used during the last login');
            $table->string('last_login_device')->nullable()->comment('Device used during the last login');
            $table->string('last_login_location')->nullable()->comment('Location of the last login');
            $table->string('last_login_country')->nullable()->comment('Country of the last login');
            $table->string('last_login_city')->nullable()->comment('City of the last login');
            $table->string('last_login_region')->nullable()->comment('Region of the last login');
            $table->string('last_login_postal_code')->nullable()->comment('Postal code of the last login');
            $table->string('last_login_latitude')->nullable()->comment('Latitude of the last login location');
            $table->string('last_login_longitude')->nullable()->comment('Longitude of the last login location');
            $table->string('last_login_timezone')->nullable()->comment('Timezone of the last login');
            $table->string('last_login_device_type')->nullable()->comment('Type of device used during the last login (e.g., desktop, mobile, tablet)');
            $table->string('last_login_os')->nullable()->comment('Operating system used during the last login');
            $table->string('last_login_os_version')->nullable()->comment('Version of the operating system used during the last login');
            $table->string('last_login_browser_version')->nullable()->comment('Version of the browser used during the last login');
            $table->integer('deleted_by')->nullable()->comment('User ID of the person who deleted the user, if applicable');
            $table->string('deleted_reason')->nullable()->comment('Reason for deletion, if applicable');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
