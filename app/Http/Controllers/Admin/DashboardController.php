<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use Illuminate\Http\Request;
use App\Traits\QueryTrait;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function dashboard() {
        $permissions = $this->routePermission();
        return view("admin.dashboard", [
            'permissions' => $permissions
        ]);
    }
}
