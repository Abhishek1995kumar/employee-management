<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\DesignationController;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'createDepartment'])->name('admin.department.create');
        Route::post('save', [DepartmentController::class, 'saveDepartment'])->name('admin.department.save');
    });


    Route::group(['prefix' => 'designation'], function () {
        Route::get('/', [DesignationController::class, 'create'])->name('admin.designation.create');
        Route::post('save', [DesignationController::class, 'save'])->name('admin.designation.save');
    });


    Route::group(['prefix' => 'role'], function () {
        Route::get('/', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('save', [RoleController::class, 'save'])->name('admin.role.save');
    });


    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', [PermissionController::class, 'create'])->name('admin.permission.create');
        Route::post('save', [PermissionController::class, 'save'])->name('admin.permission.save');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [PermissionController::class, 'create'])->name('admin.user.create');
        Route::post('save', [PermissionController::class, 'save'])->name('admin.user.save');
    });




});
