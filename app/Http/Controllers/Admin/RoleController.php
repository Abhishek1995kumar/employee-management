<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller {
    public function create() {
        return view('admin.user-management.roles.index');
    }

    public function save(Request $request) {
        try {
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('Error creating role: ') . $e->getMessage()], 500);
        }
      
    }
}
