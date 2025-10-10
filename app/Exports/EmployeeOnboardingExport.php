<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class EmployeeOnboardingExport implements WithStrictNullComparison, WithEvents, WithHeadings, ShouldAutoSize {
    protected $columns, $alphabetsArray, $rows, $roles_index, $roles_option, $gender_index, $gender_option, $employee_performance_label_index;
    protected $employee_performance_label_option,  $start_month_index, $start_month_option;
    protected $financial_year_index, $financial_year_option, $salary_type_details_index, $salary_type_details_option;
    protected $salary_deduction_type_index,$salary_deduction_type_option;
    protected $shift_applicable_index, $shift_applicable_option, $outside_punch_applicable_index, $outside_punch_applicable_option;
    protected $work_type_index, $work_type_option, $overtime_applicable_index, $overtime_applicable_option;
    protected $sandwich_leave_applicable_index, $sandwich_leave_applicable_option, $employee_firm_location_index, $employee_firm_location_option;
    protected $late_applicable_index, $late_applicable_option, $late_day_index, $late_day_option, $late_hours_index, $late_hours_option;
    protected $leave_period_index, $leave_period_option;
    protected $leave_should_be_accured_from_index, $leave_should_be_accured_from_option;
    protected $asset_name_index, $asset_name_option;
    protected $sub_asset_name_index, $sub_asset_name_option;
    protected $document_type_index, $document_type_option;

    // protected $indexArray = [$roles_index, $gender_index, $employee_performance_label_index, $financial_year_index,
    //     $start_month_index, $salary_type_details_index, $salary_deduction_type_index, $shift_applicable_index,
    //     $outside_punch_applicable_index, $work_type_index, $overtime_applicable_index, $sandwich_leave_applicable_index,
    //     $employee_firm_location_index, $late_applicable_index, $late_day_index, $late_hours_index, $leave_period_index,

    // ];
    protected $optionArray = [];

    public function __construct($headers, $userOnboardingSheet, $data) {
        $this->columns                              = $headers;
        $this->rows                                 = $userOnboardingSheet;
        $this->roles_index                          = @$data['roles_index'];
        $this->roles_option                         = @$data['roles_option'];
        $this->gender_index                         = @$data['gender_index'];
        $this->gender_option                        = @$data['gender_option'];
        $this->employee_performance_label_index     = @$data['employee_performance_label_index'];
        $this->employee_performance_label_option    = @$data['employee_performance_label_option'];
        $this->financial_year_index                 = @$data['financial_year_index'];
        $this->financial_year_option                = @$data['financial_year_option'];
        $this->start_month_index                    = @$data['start_month_index'];
        $this->start_month_option                   = @$data['start_month_option'];
        $this->salary_type_details_index            = @$data['salary_type_details_index'];
        $this->salary_type_details_option            = @$data['salary_type_details_option'];
        $this->salary_deduction_type_index          = @$data['salary_deduction_type_index'];
        $this->salary_deduction_type_option         = @$data['salary_deduction_type_option'];
        $this->shift_applicable_index               = @$data['shift_applicable_index'];
        $this->shift_applicable_option              = @$data['shift_applicable_option'];
        $this->outside_punch_applicable_index       = @$data['outside_punch_applicable_index'];
        $this->outside_punch_applicable_option      = @$data['outside_punch_applicable_option'];
        $this->work_type_index                      = @$data['work_type_index'];
        $this->work_type_option                     = @$data['work_type_option'];
        $this->overtime_applicable_index            = @$data['overtime_applicable_index'];
        $this->overtime_applicable_option           = @$data['overtime_applicable_option'];
        $this->sandwich_leave_applicable_index      = @$data['sandwich_leave_applicable_index'];
        $this->sandwich_leave_applicable_option     = @$data['sandwich_leave_applicable_option'];
        $this->employee_firm_location_index         = @$data['employee_firm_location_index'];
        $this->employee_firm_location_option        = @$data['employee_firm_location_option'];
        $this->late_applicable_index                = @$data['late_applicable_index'];
        $this->late_applicable_option               = @$data['late_applicable_option'];
        $this->late_day_index                       = @$data['late_day_index'];
        $this->late_day_option                      = @$data['late_day_option'];
        $this->late_hours_index                     = @$data['late_hours_index'];
        $this->late_hours_option                    = @$data['late_hours_option'];
        $this->leave_period_index                   = @$data['leave_period_index'];
        $this->leave_period_option                  = @$data['leave_period_option'];
        $this->leave_should_be_accured_from_index   = @$data['leave_should_be_accured_from_index'];
        $this->leave_should_be_accured_from_option  = @$data['leave_should_be_accured_from_option'];
        $this->asset_name_index                     = @$data['asset_name_index'];
        $this->asset_name_option                    = @$data['asset_name_option'];
        $this->sub_asset_name_index                 = @$data['sub_asset_name_index'];
        $this->sub_asset_name_option                = @$data['sub_asset_name_option'];
        $this->document_type_index                  = @$data['document_type_index'];
        $this->document_type_option                 = @$data['document_type_option'];
        $this->alphabetsArray = array_merge(range('A', 'Z'), ['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ']);
        // dd($this->rows, $this->roles_index, $this->roles_option, "Holiday Category", $this->gender_option, "Holiday Days Details",$this->employee_performance_label_option, $this->financial_year_index, $this->start_month_index);

    }


    public function registerEvents(): array {
        $sheet = [
            AfterSheet::class => function (AfterSheet $event) {
                if ($this->roles_index !== null && count($this->roles_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->roles_index];
                    $branchIdOption = $this->roles_option;
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
                    $validation->setPrompt('Please pick a role value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $branchIdOption)));

                    for ($i = 2; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->gender_index && count($this->gender_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->gender_index];
                    $options = $this->gender_option;
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
                    $validation->setPrompt('Please pick a gender value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->employee_performance_label_index && count($this->employee_performance_label_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->employee_performance_label_index];
                    $options = $this->employee_performance_label_option;
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
                    $validation->setPrompt('Please pick a employee performance label value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->start_month_index && count($this->start_month_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->start_month_index];
                    $options = $this->start_month_option;
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
                    $validation->setPrompt('Please pick a start month value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->financial_year_index && count($this->financial_year_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->financial_year_index];
                    $options = $this->financial_year_option;
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
                    $validation->setPrompt('Please pick a financial year value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }
                
                if ($this->salary_type_details_index && count($this->salary_type_details_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->salary_type_details_index];
                    $options = $this->salary_type_details_option;
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
                    $validation->setPrompt('Please pick a salary type details value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }
                
                if ($this->salary_deduction_type_index && count($this->salary_deduction_type_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->salary_deduction_type_index];
                    $options = $this->salary_deduction_type_option;
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
                    $validation->setPrompt('Please pick a salary deduction type value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->shift_applicable_index && count($this->shift_applicable_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->shift_applicable_index];
                    $options = $this->shift_applicable_option;
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
                    $validation->setPrompt('Please pick a shift applicable value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->outside_punch_applicable_index && count($this->outside_punch_applicable_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->outside_punch_applicable_index];
                    $options = $this->outside_punch_applicable_option;
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
                    $validation->setPrompt('Please pick a outside punch applicable value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->work_type_index && count($this->work_type_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->work_type_index];
                    $options = $this->work_type_option;
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
                    $validation->setPrompt('Please pick a work type value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->overtime_applicable_index && count($this->overtime_applicable_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->overtime_applicable_index];
                    $options = $this->overtime_applicable_option;
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
                    $validation->setPrompt('Please pick a overtime applicable value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->sandwich_leave_applicable_index && count($this->sandwich_leave_applicable_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->sandwich_leave_applicable_index];
                    $options = $this->sandwich_leave_applicable_option;
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
                    $validation->setPrompt('Please pick a sandwich leave applicable value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->employee_firm_location_index && count($this->employee_firm_location_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->employee_firm_location_index];
                    $options = $this->employee_firm_location_option;
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
                    $validation->setPrompt('Please pick a employee firm location value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->late_applicable_index && count($this->late_applicable_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->late_applicable_index];
                    $options = $this->late_applicable_option;
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
                    $validation->setPrompt('Please pick a late applicable value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->late_day_index && count($this->late_day_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->late_day_index];
                    $options = $this->late_day_option;
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
                    $validation->setPrompt('Please pick a late day value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->late_hours_index && count($this->late_hours_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->late_hours_index];
                    $options = $this->late_hours_option;
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
                    $validation->setPrompt('Please pick a late hours value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->leave_period_index && count($this->leave_period_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->leave_period_index];
                    $options = $this->leave_period_option;
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
                    $validation->setPrompt('Please pick a leave period value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->leave_should_be_accured_from_index && count($this->leave_should_be_accured_from_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->leave_should_be_accured_from_index];
                    $options = $this->leave_should_be_accured_from_option;
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
                    $validation->setPrompt('Please pick a leave should be accured from value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->asset_name_index && count($this->asset_name_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->asset_name_index];
                    $options = $this->asset_name_option;
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
                    $validation->setPrompt('Please pick a asset name value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->sub_asset_name_index && count($this->sub_asset_name_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->sub_asset_name_index];
                    $options = $this->sub_asset_name_option;
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
                    $validation->setPrompt('Please pick a sub asset name value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                if ($this->document_type_index && count($this->document_type_option) > 0) {
                    $drop_column = $this->alphabetsArray[$this->document_type_index];
                    $options = $this->document_type_option;
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
                    $validation->setPrompt('Please pick a document type value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    for ($i = 3; $i <= $this->rows; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }
            },
        ];
        
        return $sheet;
    }

    public function collection() {
        $details = [
            $this->roles_index,
            $this->roles_option,
            $this->gender_index,
            $this->gender_option,
            $this->employee_performance_label_index,
            $this->employee_performance_label_option,
            $this->financial_year_option,
            $this->financial_year_index,
            $this->start_month_option,
            $this->start_month_index,
            $this->salary_type_details_index,
            $this->salary_type_details_option,
            $this->salary_deduction_type_index,
            $this->salary_deduction_type_option,
            $this->shift_applicable_index,
            $this->shift_applicable_option,
            $this->outside_punch_applicable_index,
            $this->outside_punch_applicable_option,
            $this->work_type_index,
            $this->work_type_option,
            $this->overtime_applicable_index,
            $this->overtime_applicable_option,
            $this->sandwich_leave_applicable_index,
            $this->sandwich_leave_applicable_option,
            $this->employee_firm_location_index,
            $this->employee_firm_location_option,
            $this->late_applicable_index,
            $this->late_applicable_option,
            $this->late_day_index,
            $this->late_day_option,
            $this->late_hours_index,
            $this->late_hours_option,
            $this->leave_period_index,
            $this->leave_period_option,
            $this->leave_should_be_accured_from_index,
            $this->leave_should_be_accured_from_option,
            $this->asset_name_index,
            $this->asset_name_option,
            $this->sub_asset_name_index,
            $this->sub_asset_name_option,
            $this->document_type_index,
            $this->document_type_option,
        ];
        return $details;
    }

    public function headings(): array {
        return $this->columns;
    }
}
