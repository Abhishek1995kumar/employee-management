<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller {
    use ValidationTrait, CommanFunctionTrait;
    public function index(Request $request) {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $limit = 4;
        $offset = ($page - 1) * $limit;

        $query = "SELECT id, name, created_by, created_at FROM permissions WHERE deleted_at IS NULL";
        $countQuery = "SELECT COUNT(*) as total FROM permissions WHERE deleted_at IS NULL";

        $params = [];
        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $query .= " AND name LIKE ?";
            $countQuery .= " AND name LIKE ?";
            $params[] = $searchParam;
        }

        $query .= " LIMIT $limit OFFSET $offset";

        $permissions = DB::select($query, $params);
        $totalData = DB::select($countQuery, $params)[0]->total;
        $totalPages = ceil($totalData / $limit);

        if ($request->ajax()) {
            return view('admin.user-management.premissions.ajax-data', compact('permissions', 'page', 'totalPages'))->render();
        }

        return view('admin.user-management.premissions.index', compact('permissions', 'page', 'totalPages', 'search'));
    }


    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->permissionValidationTrait($data);
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator
                ], 404);
            }

            $permission = new Permission();
            $permission->name = $request->permission;
            $permission->slug = str_replace(' ', '_', strtolower($request->permission));
            $permission->status = 1;
            $permission->updated_at = NULL;
            $permission->created_by = Auth::user()->id;
            $permission->created_at = Carbon::now();
            $permission->updated_by = NULL;
            $permission->deleted_by = NULL;
            $permission->save();
            $this->storeLog('Permission', 'save', 'Permission');
            return response()->json([
                'success' => true,
                'message' => 'New permission created successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => __('Error creating permission: ') . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request) {

    }
    
    public function show(Request $request) {

    }

    public function delete(Request $request) {

    }
}
