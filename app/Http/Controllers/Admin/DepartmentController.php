<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use Illuminate\Http\Request;
use App\Traits\QueryTrait;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;


class DepartmentController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;

    public function __construct() {
        // $this->middleware('auth');
    }

    public function index() {
        $permissions = $this->routePermission();
        return view('admin.user-management.departments.index', [
            'permissions' => $permissions
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->departmentValidationTrait($data);

            if ($validationResponse->getStatusCode() !== 200) {
                return $validationResponse;
            }

            return response()->json([
                'success' => true,
                'message' => 'Department created successfully.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the department.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->departmentValidationTrait($data, true);

            if ($validationResponse->getStatusCode() !== 200) {
                return $validationResponse;
            }

            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the department.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->departmentDeleteValidationTrait($data);

            if ($validationResponse->getStatusCode() !== 200) {
                return $validationResponse;
            }

            return response()->json([
                'success' => true,
                'message' => 'Department deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the department.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->departmentShowValidationTrait($data);

            if ($validationResponse->getStatusCode() !== 200) {
                return $validationResponse;
            }

            // Dummy department data for demonstration
            $department = [
                'id' => $data['id'],
                'name' => 'Sample Department',
                'description' => 'This is a sample department description.'
            ];

            return response()->json([
                'success' => true,
                'data' => $department
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the department details.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
