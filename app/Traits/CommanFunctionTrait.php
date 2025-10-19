<?php

namespace App\Traits;

use Throwable;
use Exception;
use Pusher\Pusher;
use App\Models\Logs;
use App\Models\User;
use App\Mail\OtpVerified;
use App\Models\Admin\LoginOtp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait CommanFunctionTrait {
    public function storeLog($action, $type, $model) {
        $log = new Logs();
        $log->action = $action;
        $log->function_name = $type;
        $log->data = $model;
        $log->user_id = Auth::user()->id;
        $log->ip = request()->ip(); // User ka IP address yaha se milega
        $log->created_by = Auth::user()->id;
        $log->save();
        // $this->sendNotification($action, $type, $model);
    }

    public function loginTrait($data) {
        try {
            $result = User::where("email", $data['login'])->orWhere('phone', $data['login'])->orWhere("username", $data['login'])->first();
            if($result) {
                if ($result->status == 1 && $result->deleted_at == null && $result->login_status == 0){
                    if(Hash::check($data['password'], $result->password)){
                        $result->api_token = $this->generateTokenTrait();
                        $result->save();
                        $otp = $this->generateOtp();
                        $this->loginOtpTrait($result->id, $result->email, $otp, $result->name);
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => 'Generate otp successfully',
                            'data' => [
                                'otp_verified' => $result->is_otp_verified,
                                'api_token' => $result->api_token,
                                'user_email' => $result->email,
                                'user_id' => $result->id,
                                'name' => $result->name,
                            ]
                        ]);

                    } else {
                        return response()->json([
                            'success' => false,
                            'code' => 201,
                            'message' => 'Incorrect Password',
                        ]);
                    }
                } else {
                    if ($result->status != 1) {
                        return response()->json([
                            'success' => false,
                            'code' => 202,
                            'message' => 'You have been deactivated from logging into the panel. Kindly contact the admin to reinstate your privileges',
                        ]);
                    } elseif (!is_null($result->deleted_at)) {
                        return response()->json([
                            'success' => false,
                            'code' => 203,
                            'message' => 'User Deleted',
                        ]);
                    } elseif ($result->login_status == 1 && $result->is_otp_verified == 1) {
                        return response()->json([
                            'success' => false,
                            'code' => 204,
                            'message' => 'Already User Login',
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'code' => 205,
                            'message' => 'You are not authorised to log into Admin Panel.',
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 206,
                    'message' => 'User not found in our records',
                ]);
            }
        } catch (Exception $e) { 
            return response()->json([
                "success"=> false,
                "code"=> 422,
                "message"=> $e->getMessage()
            ]);
        }
    }

    private function loginOtpTrait($userId, $email, $otp, $name) {
        try {
            $loginOtp = LoginOtp::where('user_id', $userId)->first();
            if($loginOtp != NULL) {
                $loginOtp->otp = $otp;
                $this->sendOtpOnEmailTrait($name, $email, $otp);
                $loginOtp->save();
            } else {
                $loginOtp = new LoginOtp();
                $loginOtp->otp = $otp;
                $loginOtp->user_id = $userId;
                $loginOtp->user_email = $email;
                $loginOtp->created_by = $userId;
                $this->sendOtpOnEmailTrait($userId, $email, $otp);
                $loginOtp->save();

            }
            return true;
        } catch (Exception $e) {
            Log::error('Failed to save login OTP: ' . $e->getMessage());
            return false;
        }
    }

    private function generateOtp() {
        return rand(100000, 999999);
    }

    private function generateTokenTrait() {
        return bin2hex(random_bytes(16));
    }

    private function sendOtpOnEmailTrait($name, $email, $otp) {
        try {
            $username = $name;
            $email = $email;
            $otp = $otp;
            $data = [
                'name' => $username,
                'otp' => $otp
            ];

            $subject = 'Your otp generate successfully';
            $view = 'admin.emails.login-email';
            Log::info('Sending email to: ', ['data' => $data]);

            Mail::to($email)->send(new OtpVerified($data, $subject, $view));

        } catch(Throwable $e) {

        }
    }

    public function logoutTrait() {
        try {
            $user = Auth::user();
            if ($user) {
                $user->login_status = 0;
                $user->api_token = null;
                $user->is_otp_verified = 0;
                $user->save();
                $this->storeLog('Logout', 'logout', 'User');
                Auth::logout();
                return redirect('/admin/login')->with(['success' => 200, 'message' => 'Logged out successfully',]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No user is currently logged in',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 422);
        }
    }

    public function strtolowerWithTrimTrait($data) {
        if($data) {
            return strtolower(trim($data));
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data is found',
            ]);
        }
    }


    public function uploadImageTrait($file, $path) {
        try {
            $fileName = null;

            // Agar file array hai aur valid tmp_name hai
            if (is_array($file) && isset($file['tmp_name'], $file['name']) && is_uploaded_file($file['tmp_name'])) {

                // Directory check/create
                $uploadDir = public_path('uploads/' . trim($path, '/') . '/');
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Unique file name
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('img_', true) . '.' . $ext;

                // Move file
                $destination = $uploadDir . $fileName;
                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    $fileName = null;
                }
            }

            // Agar string pass hua hai (edit ke time already image ka naam)
            elseif (is_string($file) && !empty($file)) {
                $fileName = $file;
            } 
            // else {
            //     $oldImagePath = public_path('uploads/' . trim($path, '/') . '/');
            //     if (file_exists($oldImagePath)) {
            //         unlink($oldImagePath);
            //     }
            //     $fileName = $file;
            // }

            return $fileName;
        } catch (\Throwable $th) {
            return null;
        }
    }


    public function sendNotification($action, $type, $model) {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );
        $data = [
            'action' => $action,
            'type' => $type,
            'model' => $model,
        ];
        $pusher->trigger('my-channel', 'my-event', $data);
        return response()->json(['success' => true]);
    }


}