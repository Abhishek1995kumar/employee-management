<?php

namespace App\Jobs;


use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use App\Models\Designation;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Models\Admin\DumpHoliday;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\CommanFunctionTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Date AS FacadesDate;

class DumpHolidayJob implements ShouldQueue {
    use Dispatchable,  SerializesModels;
    use CommanFunctionTrait;
    protected $holiday, $errorReportId;
    public function __construct($holiday, $errorReportId) {
        $this->holiday = $holiday;
        $this->errorReportId = $errorReportId;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        
    }

    /**
     * Execute the job.
     */
    public function handle() {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            $holidayDetails = $this->holiday;
            $errorReportId = $this->errorReportId;
            if(!empty($holidayDetails)) {
                $holidayRecords = [];
                foreach($holidayDetails as $holiday) {
                    if (is_numeric($holiday['start_date'])) {
                        $startDate = Date::excelToDateTimeObject($holiday['start_date'])->format('Y-m-d');
                    } else {
                        $startDate = null;
                        if (!empty($holiday['start_date'])) {
                            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d'];
                            foreach ($formats as $f) {
                                try {
                                    $startDate = Carbon::createFromFormat($f, $holiday['start_date'])->format('Y-m-d');
                                    break; // ek format match hote hi break kar do
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                    }

                    if (is_numeric($holiday['end_date'])) {
                        $endDate = Date::excelToDateTimeObject($holiday['end_date'])->format('Y-m-d');
                    } else {
                        $endDate = null;
                        if (!empty($holiday['end_date'])) {
                            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d'];
                            foreach ($formats as $f) {
                                try {
                                    $endDate = Carbon::createFromFormat($f, $holiday['end_date'])->format('Y-m-d');
                                    break;
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                    }
                    


                    $branch = explode('|', $holiday['branch_id']);
                    
                    if($branch) {
                        DB::beginTransaction();
                        try {
                            $dumpHoliday = new DumpHoliday();
                            $dumpHoliday->error_excel_report_id = $errorReportId;
                            $dumpHoliday->branch_id = $branch[0] ?? '';
                            $dumpHoliday->branch_name = $branch[1] ?? '';
                            $dumpHoliday->holiday_name = $holiday['holiday_name'];
                            $dumpHoliday->holiday_image = $this->uploadImageTrait($holiday['holiday_image'], 'holiday');
                            $dumpHoliday->holiday_category = $holiday['holiday_category'];
                            $dumpHoliday->holiday_day = $holiday['holiday_day'];
                            $dumpHoliday->holiday_month = $holiday['holiday_month'];
                            $dumpHoliday->holiday_year = $holiday['holiday_year'];
                            $dumpHoliday->holiday_color = $holiday['holiday_color'];
                            $dumpHoliday->start_date = $startDate;
                            $dumpHoliday->end_date = $endDate;
                            $dumpHoliday->description = $holiday['description'];
                            $dumpHoliday->created_at = Carbon::parse(now())->format('Y-m-d H:i:s');
                            $dumpHoliday->updated_at = NULL;
                            $dumpHoliday->is_processed = 0;
                            $dumpHoliday->is_validated = 0;
                            $dumpHoliday->status = 1;
                            $dumpHoliday->has_errors = 0;
                            $dumpHoliday->errors = NULL;
                            $dumpHoliday->save();
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Failed to save DumpHoliday: ' . $e->getMessage());
                            throw $e;
                        }
                    } else {
                        Log::warning('Branch not found for holiday: ' . json_encode($holiday));
                        throw new Exception('Branch not found, transaction rolled back.');
                    }
                }
            }
        } catch (Exception $e) {
            Log::info("Data not found in foreach.");
            Log::error($e->getMessage());
            Log::info($e->getTraceAsString());
        }
    }
}
