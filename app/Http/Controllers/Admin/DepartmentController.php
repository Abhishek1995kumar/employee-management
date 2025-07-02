<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\ValidationTraits;
use App\Http\Controllers\Controller;


class DepartmentController extends Controller {

    public function __construct() {
        // $this->middleware('auth');
    }

    public function createDepartment() {
        return view('admin.department.index');
    }

    public function saveDepartment(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->departmentValidate($data);
            dd($validationResponse);

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
}
