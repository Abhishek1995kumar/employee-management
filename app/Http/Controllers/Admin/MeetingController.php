<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Models\Admin\Meeting;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MeetingController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function index() {
        try {
            $permissions = $this->routePermission();
            return view('admin.meetings.index', [
                'permissions' => $permissions
            ]);

        } catch(Throwable $th) {

        }
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            // $validation = $this->meetingValidation($data);
            // if ($validation['status'] == 'error') {
            //     return response()->json([
            //         'success' => false, 
            //         'message' => $validation['message'],
            //         'code' => 1
            //     ], 422);
            // }
            $meeting = new Meeting();
            $meeting->user_id = Auth::user()->id;
            $meeting->client_name = $request->client_name ?? 'Abhishek Mishra';
            $meeting->location = $request->location ?? 'Lucknow, UP, India';
            $meeting->latitude = $request->latitude ?? 0;
            $meeting->longitude = $request->longitude ?? 0;
            $meeting->meeting_time = $request->meeting_time ?? 0;
            $meeting->distance_time = $request->distance_time ?? 0;
            $meeting->distance_in_km = $request->distance_in_km ?? 0;
            $meeting->duration_in_minutes = $request->duration_in_minutes ?? 0;
            $meeting->meeting_date = date('Y-m-d');
            $meeting->save();
            return response()->json([
                'success' => true, 
                'message' => 'Meeting saved successfully',
                'code' => 0
            ], 200);

        } catch(Throwable $th) {
            return response()->json([
                'success' => false, 
                'message' => 'Something went wrong',
                'code' => 2
            ], 500);
        }
    }
}
