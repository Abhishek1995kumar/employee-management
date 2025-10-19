<?php

namespace App\Jobs;

use App\Models\Admin\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Throwable;

class DumpEmployeeOnboardingJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $onboard, $errorReportId;
    public function __construct($onboard, $errorReportId) {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $this->onboard = $onboard;
        $this->errorReportId = $errorReportId;
    }

    public function handle(): void {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
            set_time_limit(0);

            $onboarding = $this->onboard;
            $errorId = $this->errorReportId;

            if($onboarding) {
                $insertArray = [];
                foreach($onboarding as $data) {
                    $role = Role::where('')->first();
                }
            }

        } catch(Throwable $th) {

        }
    }
}
