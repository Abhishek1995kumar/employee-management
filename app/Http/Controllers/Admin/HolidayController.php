<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HolidayController extends Controller {
    public function index() {
        // Return a view for listing holidays
        return view('admin.holidays.index');
    }

    
}
