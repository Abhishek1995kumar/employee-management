<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller {
    use ValidationTrait, CommanFunctionTrait;
    public function create() {
        return view('admin.user-management.roles.index');
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->roleValidationTrait($data);
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator
                ], 201);
            }
            $role = new Role();
            $role->name = $request->role;
            $role->slug = str_replace(' ', '_', strtolower($request->role));
            $role->status = 1;
            $role->updated_at = NULL;
            $role->created_by = Auth::user()->id;
            $role->created_at = Carbon::now();
            $role->updated_by = NULL;
            $role->deleted_by = NULL;
            $role->save();
            $this->storeLog('Role', 'save', 'Role');
            return response()->json([
                'success' => true,
                'message' => 'New role created successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => __('Error creating role: ') . $e->getMessage()
            ], 500);
        }
      
    }
}
