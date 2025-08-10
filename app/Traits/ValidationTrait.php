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
    // User Validation Trait
        function validateUser($data) {
            try{
                $rules = [
                    'role_id' => ['required', 'exists:roles,id'],
                    'username' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255'],
                    'date_of_birth' => ['required', 'date'],
                    'address' => ['required', 'string', 'max:255'],                    
                ];
                
                $messages = [
                    'role_id.required' => 'The role field is required.',
                    'role_id.exists' => 'The selected role does not exist.',
                    'username.required' => 'The username field is required.',
                    'username.string' => 'The username must be a string.',
                    'username.max' => 'The username may not be greater than 255 characters.',
                    'name.required' => 'The name field is required.',
                    'name.string' => 'The name must be a string.',
                    'name.max' => 'The name may not be greater than 255 characters.',
                    'phone.required' => 'The phone field is required.',
                    'phone.string' => 'The phone must be a string.',
                    'phone.max' => 'The phone may not be greater than 255 characters.',
                    'email.required' => 'The email field is required.',
                    'email.string' => 'The email must be a string.',
                    'email.max' => 'The email may not be greater than 255 characters.',
                    'date_of_birth.required' => 'The date of birth field is required.',
                    'date_of_birth.date' => 'The date of birth must be a string.',
                    'address.required' => 'The address field is required.',
                    'address.string' => 'The address must be a string.',
                    'address.max' => 'The address may not be greater than 255 characters.',
                ];
                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'required' && empty($value)) {
                            $errors[$field][] = $messages["{$field}.required"];

                        } elseif ($rule === 'exists' && !isset($value)) {
                            $errors[$field][] = $messages["{$field}.exists"];

                        } elseif ($rule === 'string' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.string"];

                        } elseif (Str::startsWith($rule, 'max:')) {
                            $max = (int)Str::after($rule, 'max:');
                            if (strlen($value) > $max) {
                                $errors[$field][] = $messages["{$field}.max"];
                            }
                        } elseif ($rule === 'date' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.date"];

                        }
                    }
                }

                return $errors;

            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
        }
    // User Validation Trait


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

    // Department Validation Trait
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
    // Department Validation Trait


    // Designation Validation Trait
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
    // Designation Validation Trait

    
    // Role Validation Trait 
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

        public function updateRoleValidationTrait($data) {
            try {
                $rules = [
                    'role' => ['string', 'max:255'],
                ];

                $messages = [
                    'role.string' => 'The name must be a string.',
                    'role.max' => 'The name may not be greater than 255 characters.',
                ];

                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'string' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.string"];

                        } elseif (Str::startsWith($rule, 'max:')) {
                            $max = (int) Str::after($rule, 'max:');
                            if (strlen($value) > $max) {
                                $errors[$field][] = $messages["{$field}.max"];
                            }
                        }
                    }
                }
                return $errors;

            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
        }
    // Role Validation Trait 


    // Permission Validation Trait
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

        public function updatePermissionValidationTrait($data) {
            try {
                $rules = [
                    'permission' => ['string', 'max:255'],
                ];

                $messages = [
                    'permission.string' => 'The name must be a string.',
                    'permission.max' => 'The name may not be greater than 255 characters.',
                ];

                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'string' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.string"];

                        } elseif (Str::startsWith($rule, 'max:')) {
                            $max = (int)Str::after($rule, 'max:');
                            if (strlen($value) > $max) {
                                $errors[$field][] = $messages["{$field}.max"];
                            }
                        }
                    }
                }
                return $errors;

            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
        }
    // Permission Validation Trait


    // Role Permission Mapping Validation Trait
        public function rolePermissionMappingValidation($data) {
            try {
                $rules = [
                    'role_id' => ['required', 'exists:roles,id'],
                    'permission_id' => ['required', 'array'],
                    'permission_id.*' => ['exists:permissions,id']
                ];
                
                $messages = [
                    'role_id.required' => 'The role field is required.',
                    'role_id.exists' => 'The selected role does not exist.',
                    'permission_id.required' => 'The permission field is required.',
                    'permission_id.array' => 'The permission must be an array.',
                    'permission_id.*.exists' => 'One or more selected permissions do not exist.'
                ];
                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'required' && empty($value)) {
                            $errors[$field][] = $messages["{$field}.required"];

                        } elseif ($rule === 'exists' && !isset($value)) {
                            $errors[$field][] = $messages["{$field}.exists"];

                        } elseif ($rule === 'array' && !is_array($value)) {
                            $errors[$field][] = $messages["{$field}.array"];
                        }
                    }
                }

                return $errors;

            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
        }
}

