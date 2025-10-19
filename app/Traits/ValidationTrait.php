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
                    'app_url' => ['required', 'string', 'max:255'],
                    'module' => ['integer', 'required'],
                ];

                $messages = [
                    'permission.required' => 'The name field is required.',
                    'permission.string' => 'The name must be a string.',
                    'permission.max' => 'The name may not be greater than 255 characters.',
                    'app_url.required' => 'The application url field is required.',
                    'app_url.string' => 'The application url must be a string.',
                    'app_url.max' => 'The application url may not be greater than 255 characters.',
                    'module.required' => 'The module name field is required.',
                    'module.integer' => 'The module name must be a integer.',
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
                        } elseif ($rule === 'integer' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.integer"];

                        }
                    }
                }

                if(!empty($permissions)) {
                    $errors['permission'][] = 'Permission name is already exists, please enter anyother permission name.';
                }

                return $errors;

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
                    'app_url' => ['string', 'max:255'],
                    'module' => ['integer']
                ];

                $messages = [
                    'permission.string' => 'The name must be a string.',
                    'permission.max' => 'The name may not be greater than 255 characters.',
                    'app_url.string' => 'The application url must be a string.',
                    'app_url.max' => 'The application url may not be greater than 255 characters.',
                    'module.integer' => 'The module name must be a integer.',

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
                        } elseif ($rule === 'integer' && !is_string($value)) {
                            $errors[$field][] = $messages["{$field}.integer"];

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
                    'permission_id.*' => ['exists:permissions,id'],
                    'route_url' => ['required', 'array'],
                    'route_url.*' => ['exists:permissions,app_url']
                ];
                
                $messages = [
                    'role_id.required' => 'The role field is required.',
                    'role_id.exists' => 'The selected role does not exist.',
                    'permission_id.required' => 'The permission field is required.',
                    'permission_id.array' => 'The permission must be an array.',
                    'permission_id.*.exists' => 'One or more selected permissions do not exist.',
                    'route_url.required' => 'The route url field is required.',
                    'route_url.array' => 'The route url must be an array.',
                    'route_url.*.exists' => 'One or more selected route url do not exist.'
                ];
                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'required' && !array_key_exists($field, $data)) {
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
    // Role Permission Mapping Validation Trait



    // Role Permission Mapping Validation Trait
        public function routePermissionMappingValidation($data) {
            try {
                $rules = [
                    'permission_id' => ['required', 'exists:permissions,id'],
                    'route_name' => ['required', 'array'],
                ];
                
                $messages = [
                    'permission_id.required' => 'The permission field is required.',
                    'permission_id.exists' => 'The selected permission does not exist.',
                    'route_name.required' => 'The route name field is required.',
                    'route_name.array' => 'The route name must be an array.',
                ];

                $errors = [];

                foreach ($rules as $field => $fieldRules) {
                    $value = $data[$field] ?? null;
                    foreach ($fieldRules as $rule) {
                        if ($rule === 'required' && empty($value)) {
                            $errors[$field][] = $messages["{$field}.required"];
                        } elseif ($rule === 'exists:permissions,id' && !\DB::table('permissions')->where('id', $value)->exists()) {
                            $errors[$field][] = $messages["{$field}.exists"];
                        } elseif ($rule === 'array' && !is_array($value)) {
                            $errors[$field][] = $messages["{$field}.array"];
                        }
                    }
                }
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
        }
    // Role Permission Mapping Validation Trait


    public function holidayValidationTrait($data) {
        try {
            $rules = [
                'firm_id'            => ['required', 'string'],
                'holiday_name'       => ['required', 'string', 'max:255'],
                'day_of_holiday'     => ['required', 'string'],
                'month_of_holiday'   => ['required', 'string'],
                'year_of_holiday'    => ['required', 'string'],
                'holiday_start_date' => ['required', 'date'],
                'holiday_end_date'   => ['required', 'date'],
                'color'              => ['required', 'string'],
                'holiday_image'      => ['nullable', 'string', 'max:500'],
                'description'        => ['nullable', 'string', 'max:500'],
                'category'           => ['required', 'integer'],
            ];

            $messages = [
                'holiday_name.required'       => 'The holiday name field is required.',
                'holiday_name.string'         => 'The holiday name must be a string.',
                'holiday_name.max'            => 'The holiday name may not be greater than 255 characters.',
                'day_of_holiday.required'     => 'The day of holiday field is required.',
                'day_of_holiday.string'       => 'The day of holiday must be a string.',
                'month_of_holiday.required'   => 'The month of holiday field is required.',
                'month_of_holiday.string'     => 'The month of holiday must be a string.',
                'year_of_holiday.required'    => 'The year of holiday field is required.',
                'year_of_holiday.string'      => 'The year of holiday must be a string.',
                'holiday_start_date.required' => 'The holiday start date field is required.',
                'holiday_start_date.date'     => 'The holiday start date must be a date type like (2025-06-21).',
                'holiday_end_date.required'   => 'The holiday end date field is required.',
                'holiday_end_date.date'       => 'The holiday end date must be a date type like (2025-06-21).',
                'color.required'              => 'The color field is required.',
                'color.string'                => 'The color must be a string.',
                'holiday_image.string'        => 'The holiday image must be a string.',
                'holiday_image.max'           => 'The holiday image may not be greater than 255 characters.',
                'description.string'          => 'The description must be a string.',
                'description.max'             => 'The description may not be greater than 255 characters.',
                'category.required'           => 'The category field is required.',
                'category.integer'            => 'The category must be a integer.',
            ];

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;

                foreach ($fieldRules as $rule) {
                    // handle nullable fields
                    if ($rule === 'nullable' && is_null($value)) {
                        continue 2; // skip remaining rules for this field
                    }

                    // required
                    if ($rule === 'required' && (is_null($value) || $value === '')) {
                        $errors[$field][] = $messages["{$field}.required"];
                    }

                    // string
                    elseif ($rule === 'string' && !is_string($value)) {
                        $errors[$field][] = $messages["{$field}.string"];
                    }

                    // max length
                    elseif (Str::startsWith($rule, 'max:')) {
                        $max = (int) Str::after($rule, 'max:');
                        if (!is_null($value) && strlen($value) > $max) {
                            $errors[$field][] = $messages["{$field}.max"];
                        }
                    }

                    // integer
                    elseif ($rule === 'integer' && !is_numeric($value)) {
                        $errors[$field][] = $messages["{$field}.integer"];
                    }

                    // date
                    elseif ($rule === 'date' && (strtotime($value) === false)) {
                        $errors[$field][] = $messages["{$field}.date"];
                    }
                }
            }

            return $errors;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }


    public function subjectValidationTrait($data) {
        try {
            $rules = [
                'subject_name'       => ['required', 'string', 'max:255'],
                'description'        => ['nullable', 'string', 'max:500'],
            ];

            $messages = [
                'subject_name.required'       => 'The holiday name field is required.',
                'subject_name.string'         => 'The holiday name must be a string.',
                'subject_name.max'            => 'The holiday name may not be greater than 255 characters.',
                'description.string'          => 'The description must be a string.',
                'description.max'             => 'The description may not be greater than 255 characters.',
            ];

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;

                foreach ($fieldRules as $rule) {
                    // handle nullable fields
                    if ($rule === 'nullable' && is_null($value)) {
                        continue 2; // skip remaining rules for this field
                    }

                    // required
                    if ($rule === 'required' && (is_null($value) || $value === '')) {
                        $errors[$field][] = $messages["{$field}.required"];
                        
                    } elseif ($rule === 'string' && !is_string($value)) {
                        $errors[$field][] = $messages["{$field}.string"];

                    } elseif (Str::startsWith($rule, 'max:')) {
                        $max = (int) Str::after($rule, 'max:');
                        if (!is_null($value) && strlen($value) > $max) {
                            $errors[$field][] = $messages["{$field}.max"];
                        }
                    }
                }
            }

            return $errors;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }


    public function interviewValidationTrait($data) {
        try {
            $rules = [
                'subject_id'            => ['required', 'integer'],
                'interview_name'        => ['required', 'string', 'max:500'],
                'interview_time'        => ['required', 'string'],
                'interview_date'        => ['required', 'string', 'date'],
                'attempted'             => ['required', 'integer'],
            ];

            $messages = [
                'subject_id.required'     => 'The subject name field is required.',
                'subject_id.integer'      => 'Please enter the valid subject name.',
                'interview_name.required' => 'The subject name field i required.',
                'interview_name.string'   => 'The subject name must be a integer.',
                'interview_name.max'      => 'The interview name may not be greater than 255 characters.',
                'interview_time.required' => 'The interview time field i required.',
                'interview_time.string'   => 'The interview time must be a string.',
                'interview_date.required' => 'The interview date field i required.',
                'interview_date.string'   => 'The interview date must be a string.',
                'interview_date.date'     => 'The interview date must be a date type like (2025-06-21).',
                'attempted.required'      => 'The interview attempted field i required.',
                'attempted.integer'       => 'The interview attempted must be a integer.',
            ];

            $errors = [];

            foreach ($rules as $field => $fieldRules) {
                $value = $data[$field] ?? null;
                foreach ($fieldRules as $rule) {
                    // handle nullable fields
                    if ($rule === 'nullable' && is_null($value)) {
                        continue 2; // skip remaining rules for this field
                    }

                    // required
                    if ($rule === 'required' && (is_null($value) || $value === '')) {
                        $errors[$field][] = $messages["{$field}.required"];
                        
                    } elseif ($rule === 'string' && !is_string($value)) {
                        $errors[$field][] = $messages["{$field}.string"];

                    } elseif (Str::startsWith($rule, 'max:')) {
                        $max = (int) Str::after($rule, 'max:');
                        if (!is_null($value) && strlen($value) > $max) {
                            $errors[$field][] = $messages["{$field}.max"];
                        }
                    } elseif ($rule === 'integer' && !is_numeric($value)) {
                        $errors[$field][] = $messages["{$field}.integer"];
                        
                    } elseif ($rule === 'date' && (strtotime($value) === false)) {
                        $errors[$field][] = $messages["{$field}.date"];
                    }
                }
            }

            return $errors;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

}

