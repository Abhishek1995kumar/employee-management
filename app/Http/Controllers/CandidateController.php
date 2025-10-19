<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Throwable;

class CandidateController extends Controller {
    public function loginPage() {
        return view("examination-online/candidate-login");
    }

    public function login(Request $request){
        try {
            $data = $request->only(['name', 'phone', 'password']);

            if (empty($data['phone']) || empty($data['password'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Please enter valid login details or create a new account.",
                    'code' => 2,
                ]);
            }

            $candidate = Candidate::where('phone', $data['phone'])->first();

            // If candidate exists
            if ($candidate) {
                if ($candidate->password === $data['password']) {
                    return response()->json([
                        'success' => true,
                        'code' => 1,
                        'message' => 'Candidate login successful.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid password. Please try again.',
                        'code' => 3,
                    ]);
                }
            }

            // If candidate not found and name is not provided, ask to show name field
            if (empty($data['name'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide your name to create a new account.',
                    'code' => 5, // special code for frontend to show name field
                ]);
            }

            // If name provided, create new candidate
            $candidate = new Candidate();
            $candidate->name = ucfirst(strtolower(trim($data['name'])));
            $candidate->phone = $data['phone'];
            $candidate->password = $data['password'];
            $candidate->save();
            return response()->json([
                'success' => true,
                'message' => 'Candidate created successfully.',
                'code' => 0,
            ]);

        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'code' => 4,
            ]);
        }
    }

}
