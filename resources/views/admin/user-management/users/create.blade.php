@extends('layouts.admin')
@section('title') {{ __('Employee')}} @endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/comman.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Add Employee')}}</h1>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{url('/admin/user')}}" class="text-muted text-hover-primary">{{ __('Employee')}}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">{{ __('Add Employee')}}</li>
</ul>
@endsection

@section('content')
<!-- Alerts -->
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(Session::has('alert-' . $msg))
<div class="col-sm-12">
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} </p>
</div>
@endif
@endforeach

@if ($errors->any())
<div class="col-sm-12">
    @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
</div>
@endif
<div class="card">
    <ul class="nav nav-tabs p-4">
        <li class="nav-item"><a class="nav-link active" href="#tab_1_1" data-bs-toggle="tab">{{ __('User Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_2" data-bs-toggle="tab">{{ __('Experience Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_3" data-bs-toggle="tab">{{ __('Bank Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_4" data-bs-toggle="tab">{{ __('Salary Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_5" data-bs-toggle="tab">{{ __('Attendence Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_6" data-bs-toggle="tab">{{ __('Leave Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_7" data-bs-toggle="tab">{{ __('Asset Details')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_8" data-bs-toggle="tab">{{ __('Employee Documents')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_9" data-bs-toggle="tab">{{ __('Employee Exit')}}</a></li>
    </ul>
    <div class="card-body">
        <div class="tab-content">
            <!-- User Details -->
            <div class="tab-pane active" id="tab_1_1">
                <form id="quickForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Role')}}</label>
                                                <select name="role_id" class="form-select" id="roleId" data-control="select2" data-placeholder="Select role name">
                                                    <option></option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="usernameDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Username')}}</label>
                                                <input type="text" name="username" id="username" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="username">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="nameDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Name')}}</label>
                                                <input type="text" name="name" id="name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="phoneDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Contact')}}</label>
                                                <input type="text" name="phone" id="phone" oninput="acceptOnlyNumber(event)" class="form-control" maxlength="10" placeholder="contact number" oninput="acceptOnlyNumber(event)" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="emailDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Email')}}</label>
                                                <input type="text" name="email" id="email"  class="form-control" maxlength="200" placeholder="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="date_of_birthDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Date of Birth')}}</label>
                                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="date of birth" onclick="openFlatpickr(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="addressDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Address')}}</label>
                                                <textarea type="text" name="address" id="address" class="form-control" maxlength="100" placeholder="address" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="genderDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Gender')}}</label>
                                                <select name="gender" class="form-select" id="gender" data-control="select2" data-placeholder="Select gender" >
                                                    <option></option>
                                                    <option value="1">{{ __('Male')}}</option>
                                                    <option value="2">{{ __('Female')}}</option>
                                                    <option value="3">{{ __('Other')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-success" id="userFormBtn" onclick="saveUserForm(event)">{{ __('Next')}}</button>
                                    <!-- <button type="button" form="quickForm" class="btn btn-success" id="salaryForm">{{ __('Next')}}</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Experience Details -->
            <div class="tab-pane" id="tab_1_2">
                <p>{{ __('Experience Details Content')}}</p>
                <form id="experienceDetailsForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12" id="experienceDetailsDiv">
                            <!-- Make sure this div wraps only the table -->
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-bordered" id="experienceDetailsTable" style="min-width: 1800px;">
                                    <thead>
                                        <tr>
                                            <th >{{ __('Action')}}</th>
                                            <th >{{ __('Company Name')}}</th>
                                            <th >{{ __('Role Name')}}</th>
                                            <th >{{ __('Year Experience')}}</th>
                                            <th >{{ __('DOJ')}}</th>
                                            <th >{{ __('DOE')}}</th>
                                            <th >{{ __('Salary')}}</th>
                                            <th >{{ __('HR Name')}}</th>
                                            <th >{{ __('HR Contact')}}</th>
                                            <th >{{ __('Projects')}}</th>
                                            <th >{{ __('Skill')}}</th>
                                            <th >{{ __('Document')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="experienceDetails_1">
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info text-center" onclick="addMoreExperienceDetails(event)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td><input type="text" name="company_name[]" id="company_name_1" oninput="stringValidation(event)" class="form-control" placeholder="previous company name"></td>
                                            <td><input type="text" name="previous_role[]" id="previous_role_1" oninput="stringValidation(event)" class="form-control" placeholder="previous role"></td>
                                            <td><input type="text" name="experience[]" id="experience_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="previous experience"></td>
                                            <td><input type="text" name="previous_doj[]" id="previous_doj_1" onclick="openFlatpickr(event)" class="form-control" placeholder="previous joining working date"></td>
                                            <td><input type="text" name="previous_doe[]" id="previous_doe_1" onclick="openFlatpickr(event)" class="form-control" placeholder="previous last working date"></td>
                                            <td><input type="number" name="previous_salary[]" id="previous_salary_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="previous salary"></td>
                                            <td><input type="text" name="previous_hr_name[]" id="previous_hr_name_1" oninput="stringValidation(event)" class="form-control" placeholder="previous hr name"></td>
                                            <td><input type="text" name="previous_hr_contact[]" id="previous_hr_contact_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="previous hr contact"></td>
                                            <td><input type="text" name="previous_project[]" id="previous_project_1" oninput="stringValidation(event)" class="form-control" placeholder="previous project"></td>
                                            <td><input type="text" name="previous_skill[]" id="previous_skill_1" oninput="stringValidation(event)" class="form-control" placeholder="previous skill use"></td>
                                            <td>
                                                <input type="file" name="previous_documents[]" id="previous_documents_1" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                                                <div class="previewContainer" style="display: none;">
                                                    <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                                                    <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;"><i class="bi bi-x"></i></span>
                                                    <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                                                    <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons outside scroll -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" >{{ __('Previous')}}</button>
                                <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bank -->
            <div class="tab-pane" id="tab_1_3">
                <form id="bankDetailsForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12" id="bankDetailsDiv">
                            <!-- Make sure this div wraps only the table -->
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-bordered" id="bankDetailsTable" style="min-width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th >{{ __('Action')}}</th>
                                            <th >{{ __('Bank Name')}}</th>
                                            <th >{{ __('Branch Name')}}</th>
                                            <th >{{ __('Account Holder Name')}}</th>
                                            <th >{{ __('Account Number')}}</th>
                                            <th >{{ __('IFSC Code')}}</th>
                                            <th >{{ __('Beneficiary Name')}}</th>
                                            <th >{{ __('Bank Document')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bankDetails_1">
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info text-center" onclick="addMoreBankDetails(event)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td><input type="text" name="bank_name[]" id="bank_name_1" oninput="stringValidation(event)" class="form-control" placeholder="bank name"></td>
                                            <td><input type="text" name="branch_name[]" id="branch_name_1" oninput="stringValidation(event)" class="form-control" placeholder="branch name"></td>
                                            <td><input type="text" name="account_holder_name[]" id="account_holder_name_1" oninput="stringValidation(event)"  class="form-control" placeholder="account holder name"></td>
                                            <td><input type="text" name="account_number[]" id="account_number_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="account number"></td>
                                            <td><input type="text" name="ifsc_code[]" id="ifsc_code_1" oninput="stringValidation(event)" class="form-control" placeholder="IFSC code"></td>
                                            <td><input type="text" name="beneficiary_name[]" id="beneficiary_name_1" oninput="stringValidation(event)" class="form-control" placeholder="beneficiary name"></td>
                                            <td>
                                                <input type="file" name="documents[]" id="documents_1" class="form-control fileInput" oninput="stringValidation(event)" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                                                <div class="previewContainer" style="display: none;">
                                                    <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                                                    <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;"><i class="bi bi-x"></i></span>
                                                    <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                                                    <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons outside scroll -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" >{{ __('Previous')}}</button>
                                <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Salary Details -->
            <div class="tab-pane" id="tab_1_4">
                <ul class="nav nav-tabs mt-3 mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#performance_allowance">{{ __('Performance Allowance')}}</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#staff_loan">{{ __('Staff Loan')}}</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#salary_details">{{ __('Salary Details')}}</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#deduction_details">{{ __('Deduction Details')}}</a></li>
                </ul>

                <!-- Inner Tab Content -->
                <div class="tab-content">
                    <!-- performance allowance tab -->
                    <div class="tab-pane fade show active" id="performance_allowance">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="performanceLabelDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Performance Label')}}</label>
                                                        <select name="compensatory_label" class="form-select" id="performanceLabel" data-control="select2" data-placeholder="Select performance label">
                                                            <option></option>
                                                            <option value="50">{{ __('50.0 %')}}</option>
                                                            <option value="60">{{ __('60.0 %')}}</option>
                                                            <option value="70">{{ __('70.0 %')}}</option>
                                                            <option value="80">{{ __('80.0 %')}}</option>
                                                            <option value="90">{{ __('90.0 %')}}</option>
                                                            <option value="100">{{ __('100.0 %')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="compensatoryOffApplicabilityDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Performance Bonus Amount')}}</label>
                                                        <input type="text" name="compensatory_off_amount[]" class="form-control" placeholder="compensatory off amount" oninput="acceptOnlyNumber(event)" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="start_from_month_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Start Month')}}</label>
                                                        <select name="start_from_month" class="form-select" id="start_from_month" data-control="select2" data-placeholder="Select start from month">
                                                            <option></option>
                                                            <option value="January">{{ __('January')}}</option>
                                                            <option value="February">{{ __('February')}}</option>
                                                            <option value="March">{{ __('March')}}</option>
                                                            <option value="April">{{ __('April')}}</option>
                                                            <option value="May">{{ __('May')}}</option>
                                                            <option value="June">{{ __('June')}}</option>
                                                            <option value="July">{{ __('July')}}</option>
                                                            <option value="August">{{ __('August')}}</option>
                                                            <option value="September">{{ __('September')}}</option>
                                                            <option value="October">{{ __('October')}}</option>
                                                            <option value="November">{{ __('November')}}</option>
                                                            <option value="December">{{ __('December')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="financial_year_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Financial Year')}}</label>
                                                        <select name="financial_year" class="form-select" id="financial_year" data-control="select2" data-placeholder="Select financial year">
                                                            <option></option>
                                                            <option value="2021">{{ __('2021')}}</option>
                                                            <option value="2022">{{ __('2022')}}</option>
                                                            <option value="2023">{{ __('2023')}}</option>
                                                            <option value="2024">{{ __('2024')}}</option>
                                                            <option value="2025">{{ __('2025')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="date_for_bonus_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Date Of Bonus')}}</label>
                                                        <input type="text" name="date_for_bonus[]" id="date_for_bonus" onclick="openFlatpickr(event)" class="form-control" placeholder="date for bonus">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                                <thead>
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>{{ __('Performance Label')}}</th>
                                        <th>{{ __('Performance Bonus Amount')}}</th>
                                        <th>{{ __('Start Month')}}</th>
                                        <th>{{ __('Financial Year')}}</th>
                                        <th>{{ __('Date Of Bonus')}}</th>
                                        <th>{{ __('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="performanceAllowanceTableBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- staff loan tab -->
                    <div class="tab-pane fade" id="staff_loan">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="loan_detail_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Loan Details')}}</label>
                                                        <input type="text" name="loan_detail[]" id="loan_detail" oninput="stringValidation(event)" class="form-control" placeholder="loan detail">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="loan_amount_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Loan Amount')}}</label>
                                                        <input type="text" name="loan_amount[]" id="loan_amount" class="form-control" placeholder="loan amount" oninput="acceptOnlyNumber(event)">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="loan_emi_amount_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('EMI Amount')}}</label>
                                                        <input type="text" name="loan_emi_amount[]" id="loan_emi_amount" class="form-control" placeholder="loan emi amount" oninput="acceptOnlyNumber(event)">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="loan_start_from_month_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Start Month')}}</label>
                                                        <select name="start_from_month" class="form-select" id="loan_start_from_month" data-control="select2" data-placeholder="Select start loan from month">
                                                            <option></option>
                                                            <option value="January">{{ __('January')}}</option>
                                                            <option value="February">{{ __('February')}}</option>
                                                            <option value="March">{{ __('March')}}</option>
                                                            <option value="April">{{ __('April')}}</option>
                                                            <option value="May">{{ __('May')}}</option>
                                                            <option value="June">{{ __('June')}}</option>
                                                            <option value="July">{{ __('July')}}</option>
                                                            <option value="August">{{ __('August')}}</option>
                                                            <option value="September">{{ __('September')}}</option>
                                                            <option value="October">{{ __('October')}}</option>
                                                            <option value="November">{{ __('November')}}</option>
                                                            <option value="December">{{ __('December')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-4" id="loan_financial_year_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Financial Year')}}</label>
                                                        <select name="financial_year" class="form-select" id="loan_financial_year" data-control="select2" data-placeholder="Select loan financial year">
                                                            <option></option>
                                                            <option value="2021">{{ __('2021')}}</option>
                                                            <option value="2022">{{ __('2022')}}</option>
                                                            <option value="2023">{{ __('2023')}}</option>
                                                            <option value="2024">{{ __('2024')}}</option>
                                                            <option value="2025">{{ __('2025')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                 <div class="col-md-6 mb-4" id="loan_total_month_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Total Month')}}</label>
                                                        <input type="text" name="loan_total_month[]" id="loan_total_month" class="form-control" placeholder="total month" oninput="acceptOnlyNumber(event)" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="sanction_date_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Sanction Date')}}</label>
                                                        <input type="text" name="sanction_date[]" id="sanction_date" class="form-control" placeholder="date for sanction" onclick="openFlatpickr(event)" oninput="stringValidation(event)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="staffLoanTable">
                                <thead>
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>{{ __('Loan Details')}}</th>
                                        <th>{{ __('Loan Amount')}}</th>
                                        <th>{{ __('EMI Amount')}}</th>
                                        <th>{{ __('Start Month')}}</th>
                                        <th>{{ __('Financial Year')}}</th>
                                        <th>{{ __('Total Month')}}</th>
                                        <th>{{ __('Sanction Date')}}</th>
                                        <th>{{ __('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="staffLoanTableBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- salary details tab -->
                    <div class="tab-pane fade" id="salary_details">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="salary_type_detail_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Salary Type Details')}}</label>
                                                        <select name="salary_type_detail" class="form-select" id="salary_type_detail" data-control="select2" data-placeholder="Select salary type detail">
                                                            <option></option>
                                                            <option value="Basic">{{ __('Basic')}}</option>
                                                            <option value="Medical Allowance">{{ __('Medical Allowance')}}</option>
                                                            <option value="House Rent Allowance(HRA)">{{ __('House Rent Allowance(HRA)')}}</option>
                                                            <option value="Leave Travel Allowance (LTA)">{{ __('Leave Travel Allowance (LTA)')}}</option>
                                                            <option value="Other Allowance">{{ __('Other Allowance')}}</option>
                                                            <option value="conveyance">{{ __('Conveyance')}}</option>
                                                            <option value="Children Education">{{ __('Children Education')}}</option>
                                                            <option value="August">{{ __('August')}}</option>
                                                            <option value="Special Allowance">{{ __('Special Allowance')}}</option>
                                                            <option value="Travelling Allowance">{{ __('Travelling Allowance')}}</option>
                                                            <option value="Variable">{{ __('Variable')}}</option>
                                                            <option value="ESOPS">{{ __('ESOPS')}}</option>
                                                            <option value="Fixed Remenuration">{{ __('Fixed Remenuration')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="employee_salary_amount_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Salary Amount')}}</label>
                                                        <input type="text" name="employee_salary_amount[]" id="employee_salary_amount" oninput="acceptOnlyNumber(evennt)" class="form-control" placeholder="employee salary amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                                <thead>
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>{{ __('Salary Type')}}</th>
                                        <th>{{ __('Salary Amount')}}</th>
                                        <th>{{ __('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="performanceAllowanceTableBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- deduction details tab -->
                    <div class="tab-pane fade" id="deduction_details">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="fund_type_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Salary Type')}}</label>
                                                        <select name="fund_type" class="form-select" id="fund_type" data-control="select2" data-placeholder="Select fund type">
                                                            <option></option>
                                                            <option value="Professional Tax">{{ __('Professional Tax')}}</option>
                                                            <option value="Provident Fund">{{ __('Provident Fund')}}</option>
                                                            <option value="TDS">{{ __('TDS')}}</option>
                                                            <option value="Other Deductions">{{ __('Other Deductions')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="select_type_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Select Percentage Type')}}</label>
                                                        <div>
                                                            <label class=" fs-6 fw-semibold mb-2">
                                                                {{ __('Fixed')}}
                                                                <input type="checkbox" name="select_fixed_type" id="select_fixed_type" class="mx-2" onclick="handleTypeCheckbox('fixed_amount_div')">
                                                            </label>
                                                            <label class="fs-6 fw-semibold mb-2">
                                                                {{ __('Percentage')}}
                                                                <input type="checkbox" name="select_percentage_type" id="select_percentage_type" class="ml-4 mx-2" onclick="handleTypeCheckbox('percentage_amount_div')">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="percentage_amount_div" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="fs-6 fw-semibold mb-2">{{ __('Percentage Amount')}}</label>
                                                        <input type="text" name="percentage_amount" id="percentage_amount" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="percentage amount">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="fixed_amount_div" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="fs-6 fw-semibold mb-2">{{ __('Fixed Amount')}}</label>
                                                        <input type="text" name="fixed_amount[]" id="fixed_amount" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                                <thead>
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>{{ __('Salary Type')}}</th>
                                        <th>{{ __('Salary Amount')}}</th>
                                        <th>{{ __('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="performanceAllowanceTableBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendence Details -->
            <div class="tab-pane" id="tab_1_5">
                <ul class="nav nav-tabs mt-3 mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#punchInTab">{{ __('Punch In Applicable')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#punchOutTab">{{ __('Punch In Not Applicable')}}</a>
                    </li>
                </ul>

                <!-- Inner Tab Content -->
                <div class="tab-content">
                    <!-- Punch In Applicable Tab -->
                    <div class="tab-pane fade show active" id="punchInTab">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-4" id="outside_punch_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Outside Punch Applicable')}}</label>
                                                        <select name="outside_punch" class="form-select" id="outside_punch" data-control="select2" data-placeholder="Select Outside Punch Applicable">
                                                            <option></option>
                                                            <option value="1">{{ __('Yes')}}</option>
                                                            <option value="2">{{ __('No')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mb-4" id="shift_applicable_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Shift Applicable')}}</label>
                                                        <select name="shift_applicable" id="shift_applicable" class="form-select" data-control="select2" data-placeholder="Select Shift Applicable">
                                                            <option></option>
                                                            <option value="1">{{ __('Day Shift')}}</option>
                                                            <option value="2">{{ __('Night Shift')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4" id="work_type_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Work Type')}}</label>
                                                        <select name="work_type" class="form-select" id="work_type" data-control="select2" data-placeholder="Select work type">
                                                            <option></option>
                                                            <option value="1">{{ __('Full Time')}}</option>
                                                            <option value="2">{{ __('Part Time')}}</option>
                                                            <option value="3">{{ __('Contract')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4" id="overtime_applicable_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Overtime Applicable')}}</label>
                                                        <select name="overtime_applicable" id="overtime_applicable" class="form-select" data-control="select2" data-placeholder="Select Overtime Applicable">
                                                            <option></option>
                                                            <option value="yes">{{ __('Yes')}}</option>
                                                            <option value="no">{{ __('No')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4" id="sandwich_leave_applicable_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Sandwich Leave Applicability')}}</label>
                                                        <select name="sandwich_leave_applicable" id="sandwich_leave_applicable" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                            <option></option>
                                                            <option value="yes">{{ __('Yes')}}</option>
                                                            <option value="no">{{ __('No')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4" id="employee_firm_location_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Employee Firm Location')}}</label>
                                                        <select name="employee_firm_location" id="employee_firm_location" class="form-select" data-control="select2" data-placeholder="Select employee firm location">
                                                            <option></option>
                                                            <option value="lko">{{ __('Lucknow')}}</option>
                                                            <option value="dl">{{ __('Delhi')}}</option>
                                                            <option value="bmc">{{ __('Mumbai')}}</option>
                                                            <option value="mas">{{ __('Chennai')}}</option>
                                                            <option value="kl">{{ __('Kolkata')}}</option>
                                                            <option value="jr">{{ __('Jaipur')}}</option>
                                                            <option value="kmc">{{ __('Kalyan Dombivali')}}</option>
                                                            <option value="th">{{ __('Thane')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-4" id="work_schedule_div">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="col-md-3 me-3">
                                                                <label class="required fs-6 fw-semibold mb-2 ">{{ __('Work Schedule')}}</label>
                                                                <input type="text" name="week_day" id="week_day_1" class="form-control " placeholder="week day 1" value="Monday">
                                                                <input type="text" name="week_day" id="week_day_2" class="form-control " placeholder="week day 2" value="Tuesday">
                                                                <input type="text" name="week_day" id="week_day_3" class="form-control " placeholder="week day 3" value="Wednesday">
                                                                <input type="text" name="week_day" id="week_day_4" class="form-control " placeholder="week day 4" value="Thursday">
                                                                <input type="text" name="week_day" id="week_day_5" class="form-control " placeholder="week day 5" value="Friday">
                                                                <input type="text" name="week_day" id="week_day_6" class="form-control " placeholder="week day 6" value="Saturday">
                                                                <input type="text" name="week_day" id="week_day_7" class="form-control " placeholder="week day 7" value="Sunday">
                                                            </div>
                                                            <div class="col-md-3 me-3">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Work Type')}}</label>
                                                                <select name="working_days" id="working_days_1" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_2" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_3" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_4" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_5" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_6" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                                <select name="working_days" id="working_days_7" class="form-select" data-control="select2" data-placeholder="Select Sandwich Leave Applicability">
                                                                    <option></option>
                                                                    <option value="Working">{{ __('Working')}}</option>
                                                                    <option value="Off">{{ __('Off')}}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Fixed Hour')}}</label>
                                                                <input type="text" name="fixed_hour" id="fixed_hour_1" class="form-control" placeholder="week day 1"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_2" class="form-control" placeholder="week day 2"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_3" class="form-control" placeholder="week day 3"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_4" class="form-control" placeholder="week day 4"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_5" class="form-control" placeholder="week day 5"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_6" class="form-control" placeholder="week day 6"  value="08:30:00">
                                                                <input type="text" name="fixed_hour" id="fixed_hour_7" class="form-control" placeholder="week day 7"  value="08:30:00">
                                                            </div>
                                                            <div class="col-md-3 ms-4 ">
                                                                <label class="required fs-6 fw-semibold mb-2 ms-4">{{ __('Fix In time Applicable')}}</label>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_1" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_1')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_1" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_2" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_2')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_2" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_3" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_3')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_3" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_4" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_4')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_4" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_5" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_5')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_5" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_6" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_6')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_6" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_7" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_7')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_7" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                                <div class="pt-3 ps-4">
                                                                    <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="fixed_time_yes" id="fixed_time_yes_8" class="mx-2" onclick="handleTypeCheckbox('fixed_time_div_8')"></label>
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="fixed_time_no" id="fixed_time_no_8" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_fixed_time_div')"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-4">
                                                            <div class="col-md-3 mt-4" id="fixed_time_div_1" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-4" id="fixed_time_div_2" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_2" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-4" id="fixed_time_div_3" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_3" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 3">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-4" id="fixed_time_div_4" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_4" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 4">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-4">
                                                            <div class="col-md-3 mb-4" id="fixed_time_div_5" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_5" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 5">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mb-4" id="fixed_time_div_6" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_6" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 6">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mb-4" id="fixed_time_div_7" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_7" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 7">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mb-4" id="fixed_time_div_8" style="display: none;">
                                                                <div class="form-group me-2">
                                                                    <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                    <input type="text" name="fixed_shift_time" id="fixed_shift_time_8" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 8">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div class="col-md-3 mb-4" id="no_fixed_time_div">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4" id="late_applicable_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Late Applicable')}}</label>
                                                        <div>
                                                            <label class=" fs-6 fw-semibold mb-2"> {{ __('Yes')}} <input type="checkbox" name="yes_late_applicable" id="yes_late_applicable" class="mx-2" onclick="handleTypeCheckbox('yes_late_woking_applicable_div')"></label>
                                                            <label class="fs-6 fw-semibold mb-2"> {{ __('No')}} <input type="checkbox" name="no_late_applicable" id="no_late_applicable" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_late_woking_applicable_div')"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                </div>

                                                <div class="col-md-12 mb-4 " id="yes_late_woking_applicable_div" style="display: none;">
                                                    <div class="d-flex justify-content-between"> 
                                                        <div class="col-md-4 me-3" id="every_late_div">
                                                            <div class="form-group">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Every Late')}}</label>
                                                                <select name="every_late" id="every_late" class="form-select" data-control="select2" data-placeholder="Select days late">
                                                                    <option></option>
                                                                    <option value="1">{{ __('1 hour')}}</option>
                                                                    <option value="2">{{ __('2 hour')}}</option>
                                                                    <option value="3">{{ __('3 hour')}}</option>
                                                                    <option value="4">{{ __('4 hour')}}</option>
                                                                    <option value="5">{{ __('5 hour')}}</option>
                                                                    <option value="6">{{ __('6 hour')}}</option>
                                                                    <option value="7">{{ __('7 hour')}}</option>
                                                                    <option value="8">{{ __('8 hour')}}</option>
                                                                    <option value="9">{{ __('9 hour')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-md-4 me-3" id="days_late_div">
                                                            <div class="form-group">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Days Late')}}</label>
                                                                <select name="days_late" id="days_late" class="form-select" data-control="select2" data-placeholder="Select days late">
                                                                    <option></option>
                                                                    <option value="half_day">{{ __('Half Day')}}</option>
                                                                    <option value="full_day">{{ __('Full Day')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-md-4" id="minutes_for_daily_late_div">
                                                            <div class="form-group">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Note:Set the minutes for daily late')}}</label>
                                                                <input type="text" name="minutes_for_daily_late" id="minutes_for_daily_late" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="minutes for daily late">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 mb-4" id="no_late_woking_applicable_div" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Punch In Not Applicable Tab -->
                    <div class="tab-pane fade" id="punchOutTab">
                        <form action="" method="post">
                            <div class="col-md-4 mb-4" id="punch_not_req_employee_firm_location_div">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Employee Firm Location')}}</label>
                                    <select name="employee_firm_location" id="punch_not_req_employee_firm_location_div" class="form-select" data-control="select2" data-placeholder="Select employee firm location">
                                        <option></option>
                                        <option value="lko">{{ __('Lucknow')}}</option>
                                        <option value="dl">{{ __('Delhi')}}</option>
                                        <option value="bmc">{{ __('Mumbai')}}</option>
                                        <option value="mas">{{ __('Chennai')}}</option>
                                        <option value="kl">{{ __('Kolkata')}}</option>
                                        <option value="jr">{{ __('Jaipur')}}</option>
                                        <option value="kmc">{{ __('Kalyan Dombivali')}}</option>
                                        <option value="th">{{ __('Thane')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Leave Details -->
            <div class="tab-pane" id="tab_1_6">
                <div class="tab-pane fade show active" id="leaveFormTab">
                    <form id="leaveForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-4" id="employee_total_leave_div">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Total Leave')}}</label>
                                                    <input type="text" name="employee_total_leave" id="employee_total_leave" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="employee total leave" >
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-4 " id="employee_balance_leave_div">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Balance Leave')}}</label>
                                                    <input type="text" name="employee_balance_leave" id="employee_balance_leave" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="employee balance leave" >
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-4 ps-2 pt-2" id="accrued_periodically_div">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Accrued Periodically')}}</label>
                                                    <div>
                                                        <label class=" fs-6 fw-semibold mb-2"> {{ __('Yes')}} <input type="checkbox" name="yes_accrued_period" id="yes_accrued_period" class="mx-2" onclick="handleTypeCheckbox('yes_accrued_period_div')"></label>
                                                        <label class="fs-6 fw-semibold mb-2"> {{ __('No')}} <input type="checkbox" name="no_accrued_period" id="no_accrued_period" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_accrued_period_div')"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                            </div>

                                            <div class="col-md-12 mb-4 " id="yes_accrued_period_div" style="display: none;">
                                                <div class="d-flex justify-content-between">
                                                    <div class="col-md-4 mb-4 me-3" id="employee_monthly_leave_div">
                                                        <div class="form-group">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('How many leave should monthly?')}}</label>
                                                            <input type="text" name="employee_monthly_leave" id="employee_monthly_leave" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="employee monthly leaves" >
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-4 me-3" id="accured_check_leave_type_div">
                                                        <div class="form-group">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Select Period')}}</label>
                                                            <select name="accured_check_leave_type" class="form-select" id="accured_check_leave_type" data-control="select2" data-placeholder="Select leave period">
                                                                <option></option>
                                                                <option value="weekly">{{ __('Weekly')}}</option>
                                                                <option value="monthly">{{ __('Monthly')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-4 " id="employee_accured_leave_type_div">
                                                        <div class="form-group">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Leave should be accured From?')}}</label>
                                                            <select name="employee_accured_leave_type" class="form-select" id="employee_accured_leave_type" data-control="select2" data-placeholder="Select accured leave type">
                                                                <option></option>
                                                                <option value="1">{{ __('Professional Leave')}}</option>
                                                                <option value="2">{{ __('Emergency Leave')}}</option>
                                                                <option value="3">{{ __('Sick Leave')}}</option>
                                                                <option value="4">{{ __('Earned Leave')}}</option>
                                                                <option value="5">{{ __('Maternity Leave')}}</option>
                                                                <option value="6">{{ __('Paternity Leave')}}</option>
                                                                <option value="7">{{ __('Casual Leave')}}</option>
                                                                <option value="8">{{ __('Compensatory Leave')}}</option>
                                                                <option value="9">{{ __('Unpaid Leave')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 mb-4" id="no_accrued_period_div" style="display: none;">
                                            </div>

                                            <div class="col-md-12 mb-4" id="work_schedule_div">
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-1 me-3 mt-5">
                                                            <label class="fs-6 fw-semibold"></label>
                                                            <div class="mt-3 mb-5">Type 1</div>
                                                            <div class="type">Type 2</div>
                                                            <div class="type">Type 3</div>
                                                            <div class="type">Type 4</div>
                                                            <div class="type">Type 5</div>
                                                            <div class="type">Type 6</div>
                                                            <div class="type">Type 7</div>
                                                        </div>
                                                        <div class="col-md-3 me-3">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Work Type')}}</label>
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_1" class="form-control" placeholder="Professional Leave" readonly >
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_2" class="form-control" placeholder="Emergency Leave" readonly >
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_3" class="form-control" placeholder="Sick Leave" readonly >
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_4" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_5" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_6" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="employee_accured_leave_type" id="employee_accured_leave_type_7" class="form-control" placeholder="No. of days">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('No. Of Days')}}</label>
                                                            <input type="text" name="no_of_days" id="no_of_days_1" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_2" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_3" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_4" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_5" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_6" class="form-control" placeholder="No. of days">
                                                            <input type="text" name="no_of_days" id="no_of_days_7" class="form-control" placeholder="No. of days">
                                                        </div>
                                                        <div class="col-md-3 ms-4 ">
                                                            <label class="required fs-6 fw-semibold mb-2 ms-4">{{ __('Leaves Carry Forward')}}</label>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_1" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_1')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_1" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_1')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_2" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_2')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_2" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_2')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_3" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_3')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_3" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_3')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_4" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_4')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_4" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_4')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_5" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_5')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_5" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_5')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_6" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_6')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_6" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_6')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_7" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_7')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_7" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_7')"></label>
                                                            </div>
                                                            <div class="pt-3 ps-4">
                                                                <label class=" fs-6 fw-semibold mb-2">{{ __('Yes')}}<input type="checkbox" name="yes_carry_forward" id="yes_carry_forward_8" class="mx-2" onclick="handleTypeCheckbox('yes_carry_forward_8')"></label>
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('No')}}<input type="checkbox" name="no_carry_forward" id="no_carry_forward_8" class="ml-4 mx-2" onclick="handleTypeCheckbox('no_carry_forward_8')"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-4">
                                                        <div class="col-md-3 mt-4" id="fixed_time_div_1" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_1" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-4" id="fixed_time_div_2" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_2" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-4" id="fixed_time_div_3" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_3" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 3">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-4" id="fixed_time_div_4" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_4" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-4">
                                                        <div class="col-md-3 mb-4" id="fixed_time_div_5" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_5" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 5">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-4" id="fixed_time_div_6" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_6" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 6">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-4" id="fixed_time_div_7" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_7" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 7">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-4" id="fixed_time_div_8" style="display: none;">
                                                            <div class="form-group me-2">
                                                                <label class="fs-6 fw-semibold mb-2">{{ __('Manuallly Fixed Shift Time')}}</label>
                                                                <input type="text" name="fixed_shift_time" id="fixed_shift_time_8" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="fixed shift time 8">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-3 mb-4" id="no_fixed_time_div">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                        <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Asset Details -->
            <div class="tab-pane" id="tab_1_7">
                <ul class="nav nav-tabs mt-3 mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#assetTab">{{('Asset')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#subAssetTab">{{ __('Sub Asset')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#assignedAssetTab">{{ __('Assigned Asset')}}</a>
                    </li>
                </ul>

                <!-- Inner Tab Content -->
                <div class="tab-content">
                    <!-- Asset Tab -->
                    <div class="tab-pane fade show active" id="assetTab">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="asset_name_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Asset Name')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="asset_name" id="asset_name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="asset name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Sub Asset Tab -->
                    <div class="tab-pane fade" id="subAssetTab">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="asset_id_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Asset Name')}}</label>
                                                        <select name="asset_id" class="form-select" id="asset_id" data-control="select2" data-placeholder="Select asset">
                                                            <option></option>
                                                            <option value="Software">{{ __('Software')}}</option>
                                                            <option value="Hardware">{{ __('Hardware')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="sub_asset_name_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Sub Asset Name')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="sub_asset_name" id="sub_asset_name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="sub asset name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Sub Asset Tab -->
                    <div class="tab-pane fade" id="assignedAssetTab">
                        <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4" id="select_asset_id_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Asset Name')}}</label>
                                                        <select name="asset_id" class="form-select" id="select_asset_id" data-control="select2" data-placeholder="Select asset">
                                                            <option></option>
                                                            <option value="Software">{{ __('Software')}}</option>
                                                            <option value="Hardware">{{ __('Hardware')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="select_sub_asset_id_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Sub Asset Name')}}</label>
                                                        <select name="sub_asset_id" class="form-select" id="select_sub_asset_id" data-control="select2" data-placeholder="Select sub asset">
                                                            <option></option>
                                                            <option value="1">{{ __('Operation Syatem')}}</option>
                                                            <option value="2">{{ __('Productivity Tool')}}</option>
                                                            <option value="3">{{ __('Antivirus Tool')}}</option>
                                                            <option value="4">{{ __('Database System')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="brand_name_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Brand Name')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="brand_name" id="brand_name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="sub brand name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="modal_name_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Model Name')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="modal_name" id="modal_name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="sub modal name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="specification_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Specification')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="specification" id="specification" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="specification">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="asset_descrption_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Specification')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="descrption" id="asset_descrption" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="asset descrption">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="system_vendor_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Specification')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="system_vendor" id="system_vendor" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="system vendor">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4" id="perchase_date_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Perchase Date')}}</label>
                                                        <div class="form-group">
                                                            <input type="text" name="perchase_date" id="perchase_date" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="perchase date">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Operation Syatem related divs -->
                                                <div class="col-md-12 mb-4" id="operation_system_div" style="display: none;">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-4 mb-4" id="system_name_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('System Name')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="system_name" id="system_name" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="system name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="system_version_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Version')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="system_version" id="system_version" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="system version">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="system_license_key_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('License Key')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="system_license_key" id="system_license_key" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="system license key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Productivity Tool related divs -->
                                                <div class="col-md-12 mb-4" id="productivity_tool_div" style="display: none;">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-4 mb-4" id="ms_office_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('MS Office')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="ms_office" id="ms_office" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="ms office">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="adobe_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Adobe')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="adobe" id="adobe" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="adobe">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="license_type_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('License Type')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="license_type" id="license_type" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="license type">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="subscription_info_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('License Type')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="subscription_info" id="subscription_info" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="subscription info">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Antivirus Tool related divs -->
                                                <div class="col-md-12 mb-4" id="antivirus_tool_div" style="display: none;">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-4 mb-4" id="expiry_date_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Expiry Date')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="expiry_date" id="expiry_date" class="form-control" maxlength="100" placeholder="expiry date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="active_devices_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Active Devices')}}</label>
                                                                <select name="active_devices" class="form-select" id="active_devices" data-control="select2" data-placeholder="Select active devices">
                                                                    <option></option>
                                                                    <option value="Software">{{ __('Active')}}</option>
                                                                    <option value="Hardware">{{ __('Not Active')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Database system related divs -->
                                                <div class="col-md-12 mb-4" id="database_system_div" style="display: none;">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="col-md-4 mb-4" id="database_type_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Database System')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="database_type" id="database_type" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="database type">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="instance_count_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Instance Count')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="instance_count" id="instance_count" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="instance count">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4" id="license_info_div">
                                                            <div class="form-group">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('License Type')}}</label>
                                                                <div class="form-group">
                                                                    <input type="text" name="license_info" id="license_info" oninput="stringValidation(event)" class="form-control" maxlength="100" placeholder="license info">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                            <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="assigned_asset_list_table">
                                <thead>
                                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>{{ __('Asset Name')}}</th>
                                        <th>{{ __('Sub Asset Name')}}</th>
                                        <th>{{ __('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600" id="assigned_asset_list_body">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Upload -->
            <div class="tab-pane" id="tab_1_8">
                <form id="documentDetailsForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12" id="documentDetailsDiv">
                            <!-- Make sure this div wraps only the table -->
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-bordered" id="documentDetailsTable" >
                                    <thead>
                                        <tr>
                                            <th >{{ __('Action')}}</th>
                                            <th >{{ __('Document Type')}}</th>
                                            <th >{{ __('Document')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="documentDetails_1">
                                            <td class="col-lg-1" >
                                                <button type="button" class="btn btn-sm btn-info text-center" onclick="addMoreDocumentDetails(event)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td class="col-lg-3">
                                                <select name="document_type" class="form-select" id="document_type" data-control="select2" data-placeholder="Select document type" >
                                                    <option></option>
                                                    <option value="marksheet">{{ __('Marksheet')}}</option>
                                                    <option value="certification">{{ __('Certification')}}</option>
                                                    <option value="pan_card">{{ __('Pan Card')}}</option>
                                                    <option value="aadhar_card">{{ __('Aadhar Card')}}</option>
                                                    <option value="room_rent_agreement">{{ __('Room Rent Agreement')}}</option>
                                                </select>
                                            </td>
                                            <td class="col-lg-6">
                                                <input type="file" name="employee_personal_documents[]" id="employee_personal_documents" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document" oninput="validateFileType(event)" />
                                                <div class="previewContainer" style="display: none;">
                                                    <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                                                    <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;"><i class="bi bi-x"></i></span>
                                                    <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                                                    <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons outside scroll -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" >{{ __('Previous')}}</button>
                                <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="document_list_table">
                        <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>{{ __('Document Type')}}</th>
                                <th>{{ __('Document')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="document_list_body">
                            <!-- Dynamic rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Document Upload -->
            <div class="tab-pane" id="tab_1_9">
                <form id="punchInForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4" id="employee_last_working_date_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Employee Last Working Day at office ')}}</label>
                                                <div class="form-group">
                                                    <input type="text" name="employee_last_working_date" id="employee_last_working_date" oninput="openFlatpickr(event)" class="form-control" placeholder="employee last working date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="employee_note_for_last_day_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Note')}}</label>
                                                <div class="form-group">
                                                    <input type="text" name="employee_note_for_last_day" id="employee_note_for_last_day" oninput="stringValidation(event)" class="form-control" placeholder="employee note for last day">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="employee_attachment_for_last_day_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Attachment')}}</label>
                                                <div class="form-group">
                                                    <input type="file" name="employee_attachment_for_last_day" id="employee_attachment_for_last_day" oninput="validateFileType(event)" class="form-control" placeholder="employee employee_attachment for last day">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-warning">{{ __('Previous')}}</button>
                                    <button type="button" class="btn btn-success">{{ __('Next')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="last_working_day_list_table">
                        <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>{{ __('Last Working Day')}}</th>
                                <th>{{ __('Note')}}</th>
                                <th>{{ __('Attachment')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="last_working_day_list_body">
                            <!-- Dynamic rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom/users/user.js') }}"></script>
<script src="{{ asset('assets/js/custom/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script src="{{ asset('assets/js/jquery-date.js') }}"></script>
@endsection