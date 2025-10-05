<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class HolidayExport implements WithStrictNullComparison, WithEvents, WithHeadings, ShouldAutoSize{
    protected $columns, $branch_id_index, $branch_id_option, $holiday_category_index, $holiday_category, $holiday_day_index;
    protected $holiday_day_option, $alphabetsArray, $rows, $holiday_year_option, $holiday_year_index;
    protected $holiday_month_option, $holiday_month_index, $holiday_color_code_index, $holiday_color_code_option;

    public function __construct($headers, $holidaySheetRow, $data) {
        $this->columns = $headers;
        $this->rows = $holidaySheetRow;
        $this->branch_id_index = $data['branch_id_index'];
        $this->branch_id_option = @$data['branch_id_option'];
        $this->holiday_category_index = @$data['holiday_category_index'];
        $this->holiday_category = @$data['holiday_category_option'];
        $this->holiday_day_index = @$data['holiday_day_index'];
        $this->holiday_day_option = @$data['holiday_day_option'];
        $this->holiday_month_index = @$data['holiday_month_index'];
        $this->holiday_month_option = @$data['holiday_month_option'];
        $this->holiday_year_index = @$data['holiday_year_index'];
        $this->holiday_year_option = @$data['holiday_year_option'];
        $this->holiday_color_code_index = @$data['holiday_color_code_index'];
        $this->holiday_color_code_option = @$data['holiday_color_code_option'];
        $this->alphabetsArray = array_merge(range('A', 'Z'), ['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ']);
        // dd($this->rows, $this->branch_id_index, $this->branch_id_option, "Holiday Category", $this->holiday_category, "Holiday Days Details",$this->holiday_day_option, $this->holiday_month_option, $this->holiday_year_option);

    }
    
    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if ($this->branch_id_index !== null && count($this->branch_id_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->branch_id_index];
                    $branchIdOption = $this->branch_id_option;
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a branch value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $branchIdOption)));

                    for ($i = 2; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->holiday_category_index && count($this->holiday_category) > 0) {
                    $drop_column = $this->alphabetsArray[$this->holiday_category_index];
                    $holidayCategoryOption = $this->holiday_category;
                    $lengthOfholidayCategory = strlen(implode(',', $holidayCategoryOption));
                    if($lengthOfholidayCategory>255) {

                    }
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a category value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $holidayCategoryOption)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->holiday_day_index && count($this->holiday_day_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->holiday_day_index];
                    $options = $this->holiday_day_option;
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a holiday days value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->holiday_year_index && count($this->holiday_year_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->holiday_year_index];
                    $options = $this->holiday_year_option;
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a month value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->holiday_month_index && count($this->holiday_month_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->holiday_month_index];
                    $options = $this->holiday_month_option;
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a year value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->holiday_color_code_index && count($this->holiday_color_code_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->holiday_color_code_index];
                    $options = $this->holiday_color_code_option;
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a color code value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }
            },
        ];
    }

    public function collection() {
        $details = [
            $this->branch_id_index,
            $this->branch_id_option,
            $this->holiday_category_index,
            $this->holiday_category,
            $this->holiday_day_index,
            $this->holiday_day_option,
            $this->holiday_month_index,
            $this->holiday_month_option,
            $this->holiday_year_index,
            $this->holiday_year_option,
        ];
        return $details;
    }

    public function headings(): array {
        return $this->columns;
    }

}
