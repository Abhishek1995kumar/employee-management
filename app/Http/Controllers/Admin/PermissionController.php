<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Exception;
use Dom\Document;
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
        $moduleNames = DB::select("SELECT id, name FROM modules WHERE deleted_at IS NULL ORDER BY id DESC");
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $limit = 4;
        $offset = ($page - 1) * $limit;
        $query = "SELECT id, name, module_name, module_id, created_by, created_at FROM permissions WHERE deleted_at IS NULL ORDER BY id DESC";
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
        // if ($request->ajax()) {
        //     return view('admin.user-management.premissions.ajax-data', [
        //         'permissions' => $permissions, 
        //         'page' => $page, 
        //         'totalPages' => $totalPages,
        //     ])->render();
        // }

        return view('admin.user-management.premissions.index', [
            'permissions' => $permissions, 
            'page' => $page, 
            'totalPages' => $totalPages,
            'search' => $search,
            'modules' => $moduleNames,
        ]);
    }


    public function save(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->permissionValidationTrait($data);
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'error' => 1
                ], 404);
            }
            $mId = (int) $data['module'];
            $module = DB::select("SELECT name FROM modules WHERE id = ? AND deleted_at IS NULL", [$mId]);
            if (!$module) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid module name selected.',
                    'error' => 2
                ], 400);
            }
            $moduleName = '';
            foreach($module as $mod) {
                $moduleName = $mod->name;
            }
            $permission = new Permission();
            $permission->name = trim(ucwords($request->permission));
            $permission->slug = str_replace(' ', '_', strtolower($request->permission));
            // $permission->module_name = $module[0]->name;
            $permission->module_name = $moduleName;
            $permission->module_id = (int) $data['module'];
            $permission->status = 1;
            $permission->created_by = Auth::user()->id;
            $permission->created_at = Carbon::now();
            $permission->updated_at = NULL;
            $permission->save();
            $this->storeLog('Permission', 'save', 'Permission');
            return response()->json([
                'success' => true,
                'message' => 'New permission created successfully.',
                'error' => 0
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => __('Error creating permission: ') . $e->getMessage(),
                'error' => 3
            ], 500);
        }
    }

    

    public function update(Request $request) {
        try {
            $data = $request->all();
            $validator = $this->updatePermissionValidationTrait($data);
            if($validator) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'error' => 1
                ], 404);
            }

            $mId = (int) $data['module'];
            $module = DB::select("SELECT name FROM modules WHERE id = ? AND deleted_at IS NULL", [$mId]);
            if (!$module) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid module name selected.',
                    'error' => 2
                ], 400);
            }
            $moduleName = '';
            foreach($module as $mod) {
                $moduleName = $mod->name;
            }

            $id = (int) $data['id'];
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission ID is required.',
                    'error' => 3
                ], 400);
            }
            $permission = Permission::where('id', $request->id)->whereNull('deleted_at')->first();
            if (!$permission) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission not found.',
                    'error' => 4
                ], 404);
            }
            
            $permission->name = $data['permission'];
            $permission->slug = str_replace(' ', '_', strtolower($data['permission']));
            $permission->module_name = $moduleName ?? $permission->module_name;
            $permission->module_id = (int) $data['module'] ?? $permission->module_id;
            $permission->updated_by = Auth::user()->id;
            $permission->updated_at = Carbon::now();
            $permission->save();

            $this->storeLog('Role', 'update', 'Role');
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully.',
                'error' => 0
            ], 200);

        } catch(Throwable $e) {
            return response()->json([
                'success' => false, 
                'message' => __('Error updating permission: ') . $e->getMessage(),
                'error' => 5
            ], 500);
        }
    }
    
    public function save2(Request $request) {
        try {
            $fileType = $request->post('file_type');

            $doc = new Document();
            $document = [];
            if(!empty($fileType) || $fileType !=='' || trim($fileType) != '') {
                if($fileType == 'marksheet') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                }
                if($fileType == 'aadhar') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                    
                }
                if($fileType == 'pan_card') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                    
                }
                if($fileType == 'bank_details') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                    
                }
                if($fileType == 'address_proof') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                    
                }
                if($fileType == 'licence') {
                    if ($request->hasFile('document')) {
                        $file = $request->file('document');
                        $name = $fileType . '-' . time() . '-' . $file->getClientOriginalName();
                        $imagePath = 'public/document/' . $name;
                        $file->move($imagePath, $name);
                        chmod($imagePath . '/' . $name, 0777);
                        $document[] = 'uploads/' . $name;
                    } else {
                        return null;
                    }
                    
                }

            }
            $doc->document = $document;
            $doc->save();
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

    public function save1(Request $request) {
        try {
            $fileTypes = $request->file_type;
            $documents = $request->file('document');
            $docPaths = [];

            foreach ($fileTypes as $index => $type) {
                if (!empty($documents[$index])) {
                    $file = $documents[$index];
                    $name = $type . '-' . time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $name);
                    $docPaths[] = [
                        'file_type' => $type,
                        'path' => 'uploads/' . $name
                    ];
                }
            }

            // Save to DB
            foreach ($docPaths as $docPath) {
                $doc = new Document();
                $doc->file_type = $docPath['file_type'];
                $doc->document = $docPath['path'];
                $doc->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'All documents saved successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving documents: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function show(Request $request) {

    }

    public function delete(Request $request) {
        
    }
}
