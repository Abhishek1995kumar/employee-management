<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function index() {
        $id = Auth::user()->id;
        $permissions = $this->routePermission();
        // Return a view for listing holidays
        return view('admin.holidays.index', [
            'permissions' => $permissions
        ]);
    }

    
}
