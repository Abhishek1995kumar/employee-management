<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Models\Admin\Subject;
use App\Models\Admin\Interview;
use App\Traits\ValidationTrait;
use App\Traits\CommanFunctionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller {
    use ValidationTrait, CommanFunctionTrait, QueryTrait;
    public function index() {
        $subjects = $this->getSubject();
        return view('admin.interview.index', [
            'subjects' => $subjects
        ]);
    }

    public function saveSubject(Request $request) {
        try {
            $data = $request->all();
            $validation = $this->subjectValidationTrait($data);
            if($validation) {
                return response()->json([
                    'success' => false, 
                    'message' => $validation,
                    'code' => 1
                ], 422);
            }

            $subject = new Subject();
            $subject->subject_name = ucfirst(strtolower(trim($data['subject_name'])));
            $subject->description  = ucfirst(strtolower(trim($data['description'])));
            $subject->created_by   = Auth::id();
            $subject->created_name = User::where('id', Auth::id())->first()->name;
            $subject->status       = 1;
            $subject->updated_by   = NULL;
            $subject->updated_name = NULL;
            $subject->save();
            $this->storeLog('Subject', 'save', 'Subject');
            return response()->json([
                'success' => true,
                'message' => 'New subject created successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 200);
        }
    }

    public function saveInterview(Request $request) {
        try {
            $data = $request->all();
            $validation = $this->interviewValidationTrait($data);
            if($validation) {
                return response()->json([
                    'success' => false, 
                    'message' => $validation,
                    'code' => 1
                ], 422);
            }

            $interview = new Interview();
            $interview->subject_id      = (int) strtolower(trim($data['subject_id']));
            $interview->interview_name  = ucfirst(strtolower(trim($data['interview_name'])));
            $interview->interview_time  = ucfirst(strtolower(trim($data['interview_time'])));
            $interview->interview_date  = strtolower(trim($data['interview_date']));
            $interview->attempted       = trim($data['attempted']);
            $interview->created_by      = Auth::id();
            $interview->created_name    = User::where('id', Auth::id())->first()->name;
            $interview->status          = 1;
            $interview->updated_by      = NULL;
            $interview->updated_name    = NULL;
            $interview->save();
            $this->storeLog('Interview', 'save', 'Interview');
            return response()->json([
                'success' => true,
                'message' => 'New interview created successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 200);
        }
    }


    public function updateDetails() {

    }

    public function deleteDetails(Request $request) {
        try {
            $data = $request->all();
            $interview = Interview::where('id', (int)$data['id'])->first();
            if(!$interview) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No interview found.',
                    'code' => 1
                ], 422);
            }
            $interview->delete();
            $this->storeLog('Interview', 'delete', 'Interview');
            return response()->json([
                'success' => true,
                'message' => 'Interview deleted successfully.',
                'code' => 0
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getTraceAsString(),
                'code' => 2
            ], 200);
        }
    }

    public function showDetails() {

    }


    // QUESTION ANSWER RELATED FUNCTIONS START
        
    // QUESTION ANSWER RELATED FUNCTIONS END

}



