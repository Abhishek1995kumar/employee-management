<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin\LoginOtp;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
   use ValidationTrait, CommanFunctionTrait;
    public function loadLogin() {
        return view("admin.auth.login");
    }

    public function login(Request $request) {
        try {
            $data = $request->all();
            $validation = $this->loginValidationTrait($data);

            if(!empty($validation)) {
                return $validation;
            }
            return $this->loginTrait($data);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function otpVerified(Request $request) {
        try {
            $otp = $request->otp;
            $userId = json_decode($request->user_id);
            $otpRecord = LoginOtp::where('user_id', $userId)->first();
            $user = User::where('id', $userId)->first();
            if (!$otpRecord || !$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User or OTP Record'
                ]);
            }

            if($otpRecord->otp == $otp) {
                $user->is_otp_verified = 1;
                $user->login_status = 1;
                $user->save();
                Auth::login($user);
                $this->storeLog('Login', 'login', 'User');
                return response()->json([
                    'success' => true,
                    'message' => 'OTP Verified'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect OTP'
                ]);
            }

        } catch(Throwable $e) {

        }
    }

    public function logout(Request $request) {
        try {
            return $this->logoutTrait();
        } catch(Throwable $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
}
