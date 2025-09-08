<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\UserOnboardingController;
use App\Http\Controllers\Admin\RolePermissionMappingController;
use App\Http\Controllers\Admin\RoutePermissionMappingController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AuthController::class, 'loadLogin'])->name('login');
    Route::post('auth', [AuthController::class, 'login'])->name('admin.auth');
    Route::post('admin/verify-otp', [AuthController::class, 'otpVerified'])->name('admin.verify-otp');
    Route::post('forget/password', [AuthController::class, 'forgetpassword'])->name('forget.password');
});


Route::group(['middleware' => ['isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('forgetPassword', [AuthController::class, 'showforget']);
    Route::post('changePassword', [AuthController::class, 'changepassword']);
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => ['isPermission']], function () {
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
            Route::post('update', [RoleController::class, 'update'])->name('admin.role.update');
            Route::post('delete', [RoleController::class, 'delete'])->name('admin.role.delete');
        });


        Route::group(['prefix' => 'permission'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.permission.index');
            Route::get('ajax', [PermissionController::class, 'index'])->name('admin.permission.ajax'); 
            Route::post('save', [PermissionController::class, 'save'])->name('admin.permission.save');
            Route::post('show', [PermissionController::class, 'show'])->name('admin.permission.show');
            Route::post('update', [PermissionController::class, 'update'])->name('admin.permission.update');
            Route::post('delete', [PermissionController::class, 'delete'])->name('admin.permission.delete');
        });


        Route::group(['prefix' => 'role-permission-mapping'], function () {
            Route::get('/', [RolePermissionMappingController::class, 'index'])->name('admin.role-permission-mapping.index');
            Route::post('save', [RolePermissionMappingController::class, 'save'])->name('admin.role-permission-mapping.save');
            Route::post('update', [RolePermissionMappingController::class, 'update'])->name('admin.role-permission-mapping.update');
            Route::post('delete', [RolePermissionMappingController::class, 'delete'])->name('admin.role-permission-mapping.delete');
            Route::post('show', [RolePermissionMappingController::class, 'show'])->name('admin.role-permission-mapping.show');
        });

        
        Route::group(['prefix' => 'route-permission-mapping'], function () {
            Route::get('/', [RoutePermissionMappingController::class, 'index'])->name('admin.route-permission-mapping.index');
            Route::post('/get-permissions-by-role', [RoutePermissionMappingController::class, 'getPermissionsByRole'])->name('get.permissions.by.role');
            Route::post('/get-route-by-permission', [RoutePermissionMappingController::class, 'getRouteByPermissions'])->name('get.route.by.permissions');
            Route::post('save', [RoutePermissionMappingController::class, 'save'])->name('admin.route-permission-mapping.save');
            Route::post('update', [RoutePermissionMappingController::class, 'update'])->name('admin.route-permission-mapping.update');
            Route::post('delete', [RoutePermissionMappingController::class, 'delete'])->name('admin.route-permission-mapping.delete');
            Route::post('show', [RoutePermissionMappingController::class, 'show'])->name('admin.route-permission-mapping.show');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserOnboardingController::class, 'index'])->name('admin.user');
            Route::get('create', [UserOnboardingController::class, 'create'])->name('admin.user.create');
            Route::post('save', [UserOnboardingController::class, 'save'])->name('admin.user.save');
            Route::post('update', [UserOnboardingController::class, 'update'])->name('admin.users.update');
            Route::post('delete', [UserOnboardingController::class, 'delete'])->name('admin.users.delete');
        });

        Route::group(['prefix' => 'holiday'], function () {
            Route::get('/', [HolidayController::class, 'index'])->name('admin.holiday');
        });



    });
});
