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
        $roles = Role::where('status', 1)->get();
        return view('admin.user-management.roles.index', [
            'roles' => $roles
        ]);
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

    public function update(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->updateRoleValidationTrait($data, $request->id);
            if ($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator
                ], 201);
            }
            $id = (int) $request->id;
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role ID is required.'
                ], 400);
            }
            $role = Role::where('id', $id)->first();
            if (!$role) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role not found.'
                ], 404);
            }
            $role->name = $request->role;
            $role->slug = str_replace(' ', '_', strtolower($request->role));
            $role->updated_at = Carbon::now();
            $role->updated_by = Auth::user()->id;
            $role->save();
            $this->storeLog('Role', 'update', 'Role');
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error updating role: ') . $e->getMessage()
            ], 500);
        }
    }


    public function delete(Request $request) {
        dd("hello delete");
    }
}
