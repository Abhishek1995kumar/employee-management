<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin\Holiday;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function dashboard() {
        $permissions = $this->routePermission();
        $yearWiseHolidays = DB::select('SELECT holiday_year FROM holidays WHERE deleted_at IS NULL GROUP BY holiday_year');
        return view("admin.dashboard", [
            'permissions' => $permissions,
            'yearWiseHolidays' => $yearWiseHolidays
        ]);
    }

    public function getHolidayDetails(Request $request) {
        try {
            $year = $request->input('holiday_year', date('Y'));
            $yearWiseHolidays = DB::select("SELECT id, holiday_name, holiday_day, holiday_month, start_date, holiday_color FROM holidays WHERE holiday_year=$year AND deleted_at IS NULL");
            return response()->json([
                'success' => true,
                'yearWiseHolidays' => $yearWiseHolidays,
                'code' => 1
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 1
            ], 500);
        }
    }

    public function getIdBaseHolidayDetails(Request $request) {
        try {
            $holidayId = (int) $request->holiday_id;
            $holiday = Holiday::where('id', $holidayId)->where('deleted_at', NULL)->first();
            return response()->json([
                'success' => true,
                'data' => $holiday,
                'code' => 0
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 1
            ], 500);
        }
    }

    public function getEmployeeAttendenceDetails(Request $request) {
        try {
            $employeeId = Auth::user()->id;
            $date = $request->input('regularize_date');
            if (!$employeeId || !$date) {
                return response()->json([
                    'status' => false,
                    'message' => 'Employee ID and date are required.'
                ], 400);
            }

            // Example: Fetch attendance time from database
            $attendance = DB::table('attendances')
                ->where('employee_id', $employeeId)
                ->whereDate('date', $date)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'status' => false,
                    'message' => 'Attendance record not found.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'in_time' => $attendance->in_time,
                    'out_time' => $attendance->out_time
                ]
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
