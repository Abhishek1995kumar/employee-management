<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Models\Admin\Meeting;
use App\Traits\ValidationTrait;
use App\Models\Admin\SlotBooking;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SlotBookingController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;
    public function index() {
        
    }


    public function save(Request $request) {
        //
    }


    public function update(Request $request, SlotBooking $slotBooking) {
        
    }


    public function delete(SlotBooking $slotBooking) {
        //
    }

    
    public function show(SlotBooking $slotBooking) {
        //
    }
}
