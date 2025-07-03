<?php

namespace App\Traits;


trait ValidationTrait {
    public function departmentValidate($data) {
        try {
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
                'description.max' => 'The description may not be greater than 255 characters.',
            ];

            $errors = [];

            foreach ($rules as $field => $rule) {
                $value = $data[$field] ?? null;

                if (strpos($rule, 'required') !== false && empty($value)) {
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

