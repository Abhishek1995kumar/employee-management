<?php

namespace App\Traits;

use Exception;
use Throwable;
use App\Models\Admin\Role;
use Illuminate\Support\Str;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;

trait ValidationTrait {
    public function departmentValidationTrait($data) {
        try {
            $department = Department::where('name', $data['name'])->first();
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string', 'max:255'],
            ];

            $messages = [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'description.string' => 'The description must be a string.',
                'description.max' => 'The description may not be greater than 255 characters.',
            ];

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;
                foreach ($fieldRules as $rule) {
                    if ($rule === 'required' && empty($value)) {
                        $errors[$field][] = $messages["{$field}.required"];

                    } elseif ($rule === 'string' && !is_string($value)) {
                        $errors[$field][] = $messages["{$field}.string"];

                    } elseif (Str::startsWith($rule, 'max:')) {
                        $max = (int)Str::after($rule, 'max:');
                        if (strlen($value) > $max) {
                            $errors[$field][] = $messages["{$field}.max"];
                        }
                    }
                }
            }

            if(!empty($department)) {
                $errors['name'][] = 'Already department exists, please enter anyother department name.';
            }

            return response()->json([
                'success' => true,
                'message' => 'Valid data.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }
    }

    public function designationValidationTrait($data) {
        try {
            $departments = Department::where('deleted_at', null)->where('id', json_decode($data['department_name']))->get();
            $designation = Designation::where('name', $data['name'])->first();
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string', 'max:255'],
                'department_name' => ['required']
            ];

            $messages = [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'description.string' => 'The description must be a string.',
                'description.max' => 'The description may not be greater than 255 characters.',
                'department_name.required' => 'The department field is required.',
            ];

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;
                foreach ($fieldRules as $rule) {
                    if ($rule === 'required' && empty($value)) {
                        $errors[$field][] = $messages["{$field}.required"];

                    } elseif ($rule === 'string' && !is_string($value)) {
                        $errors[$field][] = $messages["{$field}.string"];

                    } elseif (Str::startsWith($rule, 'max:')) {
                        $max = (int)Str::after($rule, 'max:');
                        if (strlen($value) > $max) {
                            $errors[$field][] = $messages["{$field}.max"];
                        }
                    }
                }
            }

            if(empty($departments)){
                $errors['department_name'][] = 'Invalid department selected.';
            }
            
            if(!empty($designation)){
                $errors['name'][] = 'Already designation exists, please enter anyother designation name.';
            }

            return response()->json([
                'success' => true,
                'message' => 'Valid data.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }
    }

    public function roleValidationTrait($data) {
        try {
            $role = Role::where('name', $data['name'])->first();
            $rules = [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ];

            $messages = [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'description.required' => 'The description field is required.',
                'description.string' => 'The description must be a string.',
            ];

            $errors = [];

            foreach($rules as $field => $rule) {
                $value = $data[$field];

                if(strpos($rule, 'required') !== false && !empty($value)) {
                    $errors[$field][] = $messages["{$field}.required"];
                }

                if (strpos($rule, 'string') !== false && !is_string($value)) {
                    $errors[$field][] = $messages["{$field}.string"];
                }

                if (strpos($rule, 'max') !== false) {
                    preg_match('/max:(\d+)/', $rule, $matches);
                    if (isset($matches[1]) && strlen($value) > (int)$matches[1]) {
                        $errors[$field][] = $messages["{$field}.max"];
                    }
                }
            }

            if(!empty($role)) {
                $errors['name'][] = 'Already role exists, please enter anyother role name.';
            }

            return response()->json([
                'success' => empty($errors),
                'errors' => $errors
            ], empty($errors) ? 200 : 422);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

}

