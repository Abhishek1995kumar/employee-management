<?php

namespace App\Jobs;

use App\Models\Admin\CustomerBranch;
use Exception;
use Throwable;
use App\Models\Admin\Holiday;
use Illuminate\Support\Carbon;
use App\Models\Admin\DumpHoliday;
use Illuminate\Support\Facades\DB;
use App\Traits\CommanFunctionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class HolidayJob implements ShouldQueue {
   use Dispatchable,  SerializesModels;
    use CommanFunctionTrait;
    protected $errorReportId;
    public function __construct($errorReportId) {
        $this->errorReportId = $errorReportId;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        
    }


    public function handle() {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            $holidayDumpData = $this->errorReportId;
            $dataToValidate = DumpHoliday::where('error_excel_report_id', $this->errorReportId)
                                            ->where('is_validated', 0)
                                            ->where('is_processed', 0)
                                            ->get();
            if(!empty($dataToValidate)) {
                $holidayRecords = [];
                if($dataToValidate->isNotEmpty()) {
                    foreach($dataToValidate as $holiday) {
                        try {
                            $this->validationValue($holiday);
                        } catch (Exception $e) { 
                            Log::info("Line number 43, data not found in foreach.");
                            Log::error($e->getMessage());
                            Log::info($e->getTrace());
                        }

                    }
                }

                $totalValidatedData = $dataToValidate->where('is_validated', 1)->where("has_error", 0);
                foreach($totalValidatedData as $holidayDetails) {
                    if (is_numeric($holidayDetails['start_date'])) {
                        $startDate = Date::excelToDateTimeObject($holidayDetails['start_date'])->format('Y-m-d');
                    } else {
                        $startDate = null;
                        if (!empty($holidayDetails['start_date'])) {
                            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d'];
                            foreach ($formats as $f) {
                                try {
                                    $startDate = Carbon::createFromFormat($f, $holidayDetails['start_date'])->format('Y-m-d');
                                    break; // ek format match hote hi break kar do
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                    }

                    if (is_numeric($holidayDetails['end_date'])) {
                        $endDate = Date::excelToDateTimeObject($holidayDetails['end_date'])->format('Y-m-d');
                    } else {
                        $endDate = null;
                        if (!empty($holidayDetails['end_date'])) {
                            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d'];
                            foreach ($formats as $f) {
                                try {
                                    $endDate = Carbon::createFromFormat($f, $holidayDetails['end_date'])->format('Y-m-d');
                                    break;
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                    }

                    if($holiday) {
                        DB::beginTransaction();
                        try {
                            $holiday = new Holiday();
                            $holiday->branch_id = $holidayDetails['branch_id'] ?? '';
                            $holiday->branch_name = $holidayDetails['branch_name'] ?? '';
                            $holiday->holiday_name = $holidayDetails['holiday_name'];
                            $holiday->holiday_image = $this->uploadImageTrait($holidayDetails['holiday_image'], 'holiday');
                            $holiday->holiday_category = $holidayDetails['holiday_category'];
                            $holiday->holiday_day = $holidayDetails['holiday_day'];
                            $holiday->holiday_month = $holidayDetails['holiday_month'];
                            $holiday->holiday_year = $holidayDetails['holiday_year'];
                            $holiday->holiday_color = $holidayDetails['holiday_color'];
                            $holiday->start_date = $startDate;
                            $holiday->end_date = $endDate;
                            $holiday->description = $holidayDetails['description'];
                            $holiday->created_at = Carbon::parse(now())->format('Y-m-d H:i:s');
                            $holiday->updated_at = NULL;
                            $holiday->status = 1;
                            $holiday->created_by = Auth::user()->id;
                            $holiday->created_name = Auth::user()->name;
                            $holiday->save();
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();
                            Log::error('Failed to save DumpHoliday: ' . $e->getMessage());
                            throw $e;
                        }
                    } else {
                        Log::warning('Branch not found for holiday: ' . json_encode($holiday));
                        throw new Exception('Branch not found, transaction rolled back.');
                    }
                }
            } else {

            }
        } catch (Exception $e) {
            Log::info("Data not found in foreach.");
            Log::error($e->getMessage());
            Log::info($e->getTraceAsString());
        }

    }


    public function validationValue($holiday) {
        try {
            $messages = [
                'branch_id_is_required' => 'Branch name is required.',
                'branch_id_is_invalid' => 'Branch name is invalid.',
                'branch_id_is_not_exist' => 'Branch name is not exist.',
                'holiday_name_is_required' => 'Holiday name is required.',
                'holiday_category_is_required' => 'Holiday category is required.',
                'holiday_day_is_required' => 'Holiday day is required.',
                'holiday_month_is_required' => 'Holiday month is required.',
                'holiday_year_is_required' => 'Holiday year is required.',
                'holiday_color_is_required' => 'Holiday color is required.',
                'start_date_is_required' => 'Holiday start date is required.',
                'end_date_is_required' => 'Holiday end date is required.',
                'start_date_is_invalid' => 'Holiday start date format is invalid.',
                'end_date_is_invalid' => 'Holiday end date format is invalid.',
            ];

            $hasErrors = 0;
            $errors = [];
            Log::info('single data', [$holiday]);

            if($holiday) {
                if(isset($data['branch_id'])) {
                    $branchIdFromDB = CustomerBranch::where('branch_id', $data['branch_id'])->first();
                    if($holiday['branch_id'] != $branchIdFromDB->branch_id){
                        $hasErrors = 1;
                        $errors[] = $messages['branch_id_is_not_exist'];

                    } elseif($holiday['branch_id'] == NULL || $holiday['branch_id'] == 0){
                        $hasErrors = 1;
                        $errors[] = $messages['branch_id_is_invalid'];
                    }
                
                } else {
                    $hasErrors = 1;
                    $errors[] = $messages['branch_id_is_required'];
                }

                if($holiday['holiday_name'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_name_is_required'];
                }

                if($holiday['holiday_category'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_category_is_required'];
                }

                if($holiday['holiday_day'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_day_is_required'];
                }

                if($holiday['holiday_month'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_month_is_required'];
                }
                
                if($holiday['holiday_year'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_year_is_required'];
                }
                
                if($holiday['holiday_color'] == '') {
                    $hasErrors = 1;
                    $errors[] = $messages['holiday_color_is_required'];
                }
                
                // if(isset($holiday['start_date'])) {
                //     $requestStart = $holiday['start_date'];
                //     if(!$this->dateValidation($requestStart)) {
                //         $hasErrors = 1;
                //         $errors[] = $messages['start_date_is_invalid'];
                //     }
                // } else {
                //     $hasErrors = 1;
                //     $errors[] = $messages['start_date_is_required'];
                // }

                // if(isset($holiday['end_date'])) {
                //     $requestEnd = $holiday['end_date'];
                //     if(!$this->dateValidation($requestEnd)) {
                //         $hasErrors = 1;
                //         $errors[] = $messages['end_date_is_invalid'];
                //     }
                // } else {
                //     $hasErrors = 1;
                //     $errors[] = $messages['end_date_is_required'];
                // }

                if(isset($holiday['start_date'])) {
                    $hasErrors = 1;
                    $errors[] = $messages['start_date_is_required'];
                }

                if(isset($holiday['end_date'])) {
                    $hasErrors = 1;
                    $errors[] = $messages['end_date_is_required'];
                }

                $holiday->is_validated = 1;
                $holiday->update();
            }

            if($hasErrors == 1){
                $holiday->has_errors = $hasErrors;
                $holiday->errors = $errors;
                $holiday->update();
            }
        } catch(Throwable $th) {
            $holiday->errors = json_encode(['failed_to_process' => 'Validation Failed : ' . $th->getMessage()]);
            $holiday->update();
        }
    }


    public function dateValidation($date, $format = 'Y-m-d') {
        if (ctype_digit($date)) {
            $date = Carbon::instance(Date::excelToDateTimeObject($date))->format($format);
            return $date;

        } else {
            $date = Carbon::parse($date)->format($format);
            return $date;
        }
        if (ctype_alpha($date)) {
            return false;

        }
    }
}
