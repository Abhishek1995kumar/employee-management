<?php

namespace App\Traits;

use Exception;
use Throwable;
use App\Models\Admin\Role;
use Illuminate\Support\Str;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Admin\Permission;
use App\Models\User;

trait ValidationTrait {
    public function loginValidationTrait($data) {
        try {
            $rules = [
                'login' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:3', 'max:255'],
            ];

            $messages = [
                'login.required' => 'The login field is required.',
                'login.string' => 'The login must be a string.',
                'login.max' => 'The login may not be greater than 255 characters.',
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password may not be less than 3 characters.',
                'password.max' => 'The password may not be greater than 255 characters.',
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
                    } elseif (Str::startsWith($rule, 'min:')) {
                        $min = (int)Str::after($rule, 'min:');
                        if (strlen($value) < $min) {
                            $errors[$field][] = $messages["{$field}.min"];
                        }
                    } 
                }
            }

            $email = User::where("email", $data["login"])->orWhere('phone', $data['login'])->orWhere("username", $data["login"])->first();

            if (!$email) {
                $errors["login"][] = "Invalid user credential";

            }

            if (!empty($errors)) {
                return  $errors;
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

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

            return $errors;

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function designationValidationTrait($data) {
        try {
            $departments = Department::where('deleted_at', null)->where('id', json_decode($data['department_id']))->get();
            $designation = Designation::where('name', $data['name'])->first();
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string', 'max:255'],
                'department_id' => ['required']
            ];

            $messages = [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'description.string' => 'The description must be a string.',
                'description.max' => 'The description may not be greater than 255 characters.',
                'department_id.required' => 'The department field is required.',
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
                $errors['department_id'][] = 'Invalid department selected.';
            }
            
            if(!empty($designation)){
                $errors['name'][] = 'Already designation exists, please enter anyother designation name.';
            }

            return $errors;
            
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function roleValidationTrait($data) {
        try {
            $role = Role::where('name', $data['role'])->first();
            $rules = [
                'role' => ['required', 'string', 'max:255'],
                // 'description' => ['string', 'max:255'],
            ];

            $messages = [
                'role.required' => 'The name field is required.',
                'role.string' => 'The name must be a string.',
                'role.max' => 'The name may not be greater than 255 characters.',
                // 'description.string' => 'The description must be a string.',
                // 'description.max' => 'The description may not be greater than 255 characters.',
                // 'department_id.required' => 'The department field is required.',
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

            if(!empty($role)) {
                $errors['role'][] = 'Already role exists, please enter anyother role name.';
            }

            return $errors;

            // return response()->json([
            //     'success' => empty($errors),
            //     'errors' => $errors
            // ], empty($errors) ? 200 : 422);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function permissionValidationTrait($data) {
        try {
            $permissions = Permission::where('name', $data['permission'])->first();
            $rules = [
                'permission' => ['required', 'string', 'max:255'],
                // 'description' => ['string', 'max:255'],
            ];

            $messages = [
                'permission.required' => 'The name field is required.',
                'permission.string' => 'The name must be a string.',
                'permission.max' => 'The name may not be greater than 255 characters.',
                // 'description.string' => 'The description must be a string.',
                // 'description.max' => 'The description may not be greater than 255 characters.',
                // 'department_id.required' => 'The department field is required.',
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

            if(!empty($permissions)) {
                $errors['permission'][] = 'Already permission exists, please enter anyother permission name.';
            }

            return $errors;

            // return response()->json([
            //     'success' => empty($errors),
            //     'errors' => $errors
            // ], empty($errors) ? 200 : 422);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

}

