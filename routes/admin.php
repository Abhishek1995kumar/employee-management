<?php

use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'createDepartment'])->name('admin.department.create');
        Route::post('save', [DepartmentController::class, 'saveDepartment'])->name('admin.department.save');
    });
});
