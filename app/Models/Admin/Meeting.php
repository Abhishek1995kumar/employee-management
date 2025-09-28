<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'meetings';
    protected $guarded = [];
}
