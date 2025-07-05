<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\CommanFunctionTrait;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;

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
}
