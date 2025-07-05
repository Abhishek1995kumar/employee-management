<?php

namespace App\Traits;

use Exception;
use Pusher\Pusher;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait CommanFunctionTrait {
    public function generateTokenTrait() {
        return bin2hex(random_bytes(16));
    }

    public function loginTrait($data) {
        try {
            $result = User::where("email", $data['login'])->orWhere('phone', $data['login'])->orWhere("username", $data['login'])->first();
            if($result) {
                if ($result->status == 1 && $result->deleted_at == null && $result->login_status == 0){
                    if(Hash::check($data['password'], $result->password)){
                        $result->login_status = 1;
                        $result->api_token = $this->generateTokenTrait();
                        $result->save();
                        Auth::login($result);
                        $this->storeLog('Login', 'login', 'User');
                        return response()->json([
                            'status' => 200,
                            'message' => 'Logged In successfully',
                        ]);

                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Incorrect Password',
                        ]);
                    }
                } else {
                    if ($result->status != 1) {
                        return response()->json([
                            'status' => false,
                            'message' => 'User Not Active',
                        ]);
                    } elseif ($result->deleted_at != null) {
                        return response()->json([
                            'status' => false,
                            'message' => 'User Deleted',
                        ]);
                    } elseif ($result->login_status == 1) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Already User Login',
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Details',
                ]);
            }
        } catch (Exception $e) { 
            return response()->json([
                "error"=> $e->getMessage()
            ], 422);
        }
    }

    public function storeLog($action, $type, $model) {
        $log = new Logs();
        $log->action = $action;
        $log->function_name = $type;
        $log->data = $model;
        $log->user_id = Auth::user()->id;
        $log->save();
        // $this->sendNotification($action, $type, $model);
    }

    // public function sendNotification($action, $type, $model) {
    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         [
    //             'cluster' => env('PUSHER_APP_CLUSTER'),
    //             'useTLS' => true,
    //         ]
    //     );
    //     $data = [
    //         'action' => $action,
    //         'type' => $type,
    //         'model' => $model,
    //     ];
    //     $pusher->trigger('my-channel', 'my-event', $data);
    //     return response()->json(['success' => true]);
    // }
}