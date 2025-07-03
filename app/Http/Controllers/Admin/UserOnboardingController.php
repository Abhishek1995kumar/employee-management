<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Http\Controllers\Controller;

class UserOnboardingController extends Controller {
    use ValidationTrait;

    public function create() {
        return view('admin.user-management.users.create');
    }


    public function save(Request $request) {
        // Validate and save the user data here

        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }
}
