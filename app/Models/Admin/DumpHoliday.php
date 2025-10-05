<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DumpHoliday extends Model {
    use HasFactory;
    protected $table = 'dump_holidays';
    protected $guarded = [];
}
