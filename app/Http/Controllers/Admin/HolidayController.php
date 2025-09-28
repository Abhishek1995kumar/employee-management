<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use Carbon\Carbon;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use \App\Models\Admin\Holiday;
use \App\Models\User;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function index() {
        $id = Auth::user()->id;
        $permissions = $this->routePermission();
        return view('admin.holidays.index', [
            'permissions' => $permissions
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validation = $this->holidayValidationTrait($data);
            if($validation) {
                return response()->json([
                    'success' => false, 
                    'message' => $validation,
                    'code' => 1
                ], 422);
            }
            
            $holiday = new Holiday();
            $holiday->firm_id = trim($data['firm_id']);
            $holiday->holiday_name = strtolower(trim($data['holiday_name']));
            $holiday->day_of_holiday = strtolower(trim($data['day_of_holiday']));
            $holiday->month_of_holiday = strtolower(trim($data['month_of_holiday']));
            $holiday->year_of_holiday = strtolower(trim($data['year_of_holiday']));
            $holiday->color = strtolower(trim($data['color']));
            $holiday->description = strtolower(trim($data['description'])) ?? NULL;
            $holiday->category = (int) trim($data['category']) ?? 1;
            $holiday->holiday_start_date = date('Y-m-d', strtotime(trim($data['holiday_start_date'])));
            $holiday->holiday_end_date = date('Y-m-d', strtotime(trim($data['holiday_end_date'])));
            $holiday->created_by = Auth::id();
            $holiday->created_name = User::where('id', Auth::id())->first()->name;
            $holiday->save();
            $this->storeLog('Holiday', 'save', 'Holiday');
            return response()->json([
                'success' => true,
                'message' => 'New holiday created successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 200);
        }
    }
    
}
