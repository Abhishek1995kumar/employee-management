<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Module;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller {
    public function index(Request $request) {
        $limit = 4;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;
        $query = ("SELECT id, name FROM modules 
                                WHERE deleted_at IS NULL ORDER BY id DESC 
                                LIMIT $limit OFFSET $offset
                ");
        $countQuery = "SELECT COUNT(*) as total FROM modules WHERE deleted_at IS NULL";
        $search = $request->input('search');
        $params = [];
        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $query .= " AND name LIKE ?";
            $countQuery .= " AND name LIKE ?";
            $params[] = $searchParam;
        }

        $modules = DB::select($query, $params);
        $totalData = DB::select($countQuery, $params)[0]->total;
        $totalPages = ceil($totalData / $limit);

        if ($request->ajax()) {
            return view('admin.user-management.modules.index', [
                'modules' => $modules, 
                'page' => $page, 
                'totalPages' => $totalPages
            ])->render();
        }

        return view('admin.user-management.modules.index', [
            'modules' => $modules, 
            'page' => $page, 
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }

    public function store(Request $request) {
        try {
            $rules = [
                'name' => 'required|string|max:255|unique:modules,name',
            ];

            $messages = [
                'name.required' => 'The module name is required.',
                'name.unique' => 'The module name must be unique.',
                'name.max' => 'The module name may not be greater than 255 characters.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator,
                    'error' => 1
                ], 400);
            }

            $routes = Route::getRoutes();
            $isValidModule = false; // flag
            
            foreach ($routes as $route) {
                $url = $route->uri();
                if ($url !== 'admin/logout') {
                    $parts = explode('/', $url);
                    $authenticatedRoute = [
                        'prefix' => $parts[0] ?? null,
                        'module' => $parts[1] ?? null,
                        'url' => $parts[2] ?? null,
                        'method' => $route->methods()[0],
                        'name' => $route->getName(),
                    ];

                    // check module name match
                    if($authenticatedRoute['module'] === preg_replace('/\s+/', '_', strtolower(trim($request->name)))) {
                        $isValidModule = true;
                        break;
                    }
                }
            }

            // agar koi bhi route match nahi karta
            if(!$isValidModule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Url name and module name are not match.',
                    'error' => 2
                ], 422);
            }

            if(Module::where('name', preg_replace('/\s+/', '_', strtolower(trim($request->name))))->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Module name already exists.',
                    'error' => 3
                ], 409);
            }
            // save module
            $module = new Module();
            $module->name = preg_replace('/\s+/', '_', strtolower(trim($request->name)));
            $module->slug = str_replace('-', '_', $module->name) ?? null;
            $module->updated_at = null;
            $module->save();
            return response()->json([
                'success' => true,
                'message' => 'New module created successfully.',
                'error' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false, 
                'message' => __('Error creating permission: ') . $e->getMessage(),
                'error' => 4
            ], 500);
        }
    }



    public function show(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:modules,id',
        ]);

        try {
            $module = Module::findOrFail($request->id);
            return response()->json(['status' => 'success', 'data' => $module]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Module not found.']);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:modules,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $module = Module::findOrFail($request->id);
            $module->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update module: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:modules,id',
        ]);

        try {
            $module = Module::findOrFail($request->id);
            $module->delete();
            return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete module: ' . $e->getMessage());
        }
    }

}
