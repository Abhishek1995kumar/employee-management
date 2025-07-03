<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller {
    public function create() {
        return view('admin.user-management.premissions.index');
    }

    public function save(Request $request) {
        try {
            // Logic to save the permission
        
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('Error creating permission: ') . $e->getMessage()], 500);
        }
    }
}
