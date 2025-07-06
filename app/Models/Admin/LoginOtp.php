<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginOtp extends Model {
    use HasFactory;

    protected $table = 'login_otp';

    protected $guarded = [];
}
