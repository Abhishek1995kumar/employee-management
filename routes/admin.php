<?php


use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\UserOnboardingController;


Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AuthController::class, 'loadLogin'])->name('login');
    Route::post('auth', [AuthController::class, 'login'])->name('admin.auth');
    Route::post('admin/verify-otp', [AuthController::class, 'otpVerified'])->name('admin.verify-otp');
    Route::post('forgetPassword', [AuthController::class, 'forgetpassword'])->name('forget.password');
});


Route::group(['middleware' => ['isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

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
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permission.index');
        Route::get('ajax', [PermissionController::class, 'index'])->name('admin.permission.ajax'); 

        Route::post('save', [PermissionController::class, 'save'])->name('admin.permission.save');

        Route::post('show', [PermissionController::class, 'show'])->name('admin.permission.show');
        Route::post('update', [PermissionController::class, 'update'])->name('admin.permission.update');
        Route::post('delete', [PermissionController::class, 'delete'])->name('admin.permission.delete');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserOnboardingController::class, 'create'])->name('admin.user.create');
        Route::post('save', [UserOnboardingController::class, 'save'])->name('admin.user.save');
    });


    Route::get('forgetPassword', [AuthController::class, 'showforget']);
    Route::post('changePassword', [AuthController::class, 'changepassword']);
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');




});
