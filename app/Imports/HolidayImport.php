<?php

namespace App\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HolidayImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnFailure, WithBatchInserts, WithChunkReading {
    use Importable, SkipsFailures;

    protected $errorReportId;

    public function __construct($errorReportId) {
        $this->errorReportId = $errorReportId;
    }

    public function model(array $row) {
        return [
            'branch_id' => $row['branch_id'] ?? null,
            'branch_name' => $row['branch_name'] ?? null,
            'holiday_name' => $row['holiday_name'] ?? null,
            'holiday_image' => $row['holiday_image'] ?? null,
            'holiday_category' => $row['holiday_category'] ?? null,
            'holiday_day' => $row['holiday_day'] ?? null,
            'holiday_month' => $row['holiday_month'] ?? null,
            'holiday_year' => $row['holiday_year'] ?? null,
            'holiday_color' => $row['holiday_color'] ?? null,
            'description' => $row['start_date'] ?? null,
            'start_date'   => $this->transformDate($row['start_date'] ?? null),
            'end_date'     => $this->transformDate($row['end_date'] ?? null),
        ];
    }


    private function transformDate($value, $format = 'Y-m-d') {
        try {
            // Excel serial number case
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format($format);
            }
            
            // Agar Excel cell me serial number (45683) hai → wo 2025-01-26 ban jayega.
            // Agar Excel cell me string (26-01-2025) hai → wo bhi 2025-01-26 ban jayega.
            // Agar value galat hai → null return karega.
            // String case (agar user ne manually "26-01-2025" dala hai)
            if (!empty($value)) {
                // yaha pe pehle check karlo kis format me aa raha hai
                $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d'];
                foreach ($formats as $f) {
                    try {
                        return Carbon::createFromFormat($f, $value)->format($format);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }


    public function prepareForValidation($data, $index) {
        return $data;
    }

    public function batchSize(): int {
        return 100;
    }

    public function chunkSize(): int {
        return 100;
    }

    public function rules(): array {
        return [];
    }

    public function onFailure(Failure ...$failures) {
        $this->failures = array_merge($this->failures, $failures);
    }

    // public function failures() {
    //     return $this->failures;
    // }
}
