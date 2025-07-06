<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Admin\Department;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DesignationController extends Controller {
    use ValidationTrait;
    public function create(Request $request) {
        $sql = "SELECT id, name FROM departments WHERE deleted_at IS NULL";
        $query = DB::select($sql);
        if ($query) {
            $departments = collect($query)->mapWithKeys(function($item) {
                return [
                    (int) $item->id => (string) $item->name,
                ];
            }
            )->toArray();
        }  else {
            $departments = [];
        }
        return view('admin.user-management.designations.index', [
            'departments' => $departments,
        ]);
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $validationResponse = $this->designationValidationTrait($data);
            // if ($validationResponse->getStatusCode() !== 200) {
            if ($validationResponse) {
                return $validationResponse;
            }

            return response()->json([
                'success' => true,
                'message' => 'Designation created successfully.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the designation.',
                'message' => $e->getMessage()
            ], 500);
        }
    }



}
