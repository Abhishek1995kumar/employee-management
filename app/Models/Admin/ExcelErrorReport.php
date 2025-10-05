<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExcelErrorReport extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'excel_error_reports';
    protected $guarded = [];


    const SUCCESS = 1;
    const FAILED = 2;
    const PROCESSING = 3;
    const JOB_FAILED = 4;
    const EMPLOYEE_ADD = 5;
    const EMPLOYEE_DELETE = 6;
    const EMPLOYEE_UPDATE = 7;

    public function employeeExcel() {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
    
    public function departmentExcel() {
        return $this->hasOne(User::class, 'department_id', 'id');
    }
    
}
