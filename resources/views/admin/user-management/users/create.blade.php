@extends('layouts.admin')
@section('title') {{ __('User')}} @endsection

@section('header')
<link href="{{ asset('assets/css/comman.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Add User')}}</h1>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{url('/admin/permission')}}" class="text-muted text-hover-primary">{{ __('User')}}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">{{ __('Add User')}}</li>
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
        <li class="nav-item"><a class="nav-link active" href="#tab_1_1" data-bs-toggle="tab">User Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_2" data-bs-toggle="tab">Bank Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_3" data-bs-toggle="tab">Attendence Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_4" data-bs-toggle="tab">Leave Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_5" data-bs-toggle="tab">Experience Details</a></li>
    </ul>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1_1">
                <form id="quickForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('First Name')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Last Name')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Contact')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Email')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Date of Birth')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Address')}}</label>
                                                <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Gender')}}</label>
                                                <select name="department_name" class="form-select" id="departmentId" data-control="select2" data-placeholder="Select department name">
                                                    <option></option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" form="quickForm" class="btn btn-success" id="salaryForm">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="tab_1_2">
                <form id="bankDetailsForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12" id="bankDetailsDiv">
                            <!-- Make sure this div wraps only the table -->
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-bordered" id="bankDetailsTable" style="min-width: 1200px;">
                                    <thead>
                                        <tr>
                                            <th >Action</th>
                                            <th >{{ __('Bank Name')}}</th>
                                            <th >{{ __('Branch Name')}}</th>
                                            <th >{{ __('Account Holder Name')}}</th>
                                            <th >{{ __('Account Number')}}</th>
                                            <th >{{ __('IFSC Code')}}</th>
                                            <th >{{ __('Beneficiary Statement')}}</th>
                                            <th >{{ __('Bank Statement')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bankDetails_1">
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info text-center" onclick="addMoreBankDetails(event)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td><input type="text" name="bank_name[]" class="form-control" placeholder="Enter bank name"></td>
                                            <td><input type="text" name="branch_name[]" class="form-control" placeholder="Enter branch name"></td>
                                            <td><input type="text" name="account_holder_name[]" class="form-control" placeholder="Enter account holder name"></td>
                                            <td><input type="text" name="account_number[]" class="form-control" placeholder="Enter account number"></td>
                                            <td><input type="text" name="ifsc_code[]" class="form-control" placeholder="Enter IFSC code"></td>
                                            <td><input type="text" name="beneficiary_name[]" class="form-control" placeholder="Enter beneficiary name"></td>
                                            <td>
                                                <input type="file" name="documents[]" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                                                <div class="previewContainer" style="display: none;">
                                                    <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                                                    <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;">X</span>
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
                                <button type="button" class="btn btn-warning" >Previous</button>
                                <button type="button" class="btn btn-success">Next</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="tab_1_3">
                <div class="d-flex flex-row">
                    <p class="">{{ __('Punching Applicability :')}}</p>
                    <div class="mx-3">
                        <input type="radio" id="punchIn" name="choice" value="punchValue1">
                        <label for="punchIn">{{ __('Punch In Applicable')}}</label><br>

                    </div>
                    <div class="mx-3">
                        <input type="radio" id="punchOut" name="choice" value="punchValue2">
                        <label for="punchOut">{{ __('Punch In Not Applicable')}}</label><br>
                    </div>
                </div>

                <div id="content1" style="display: none;">
                    <form id="quickForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Outside Punch Applicable')}}</label>
                                                    <select name="outside_punch" class="form-select" id="outsidePunch" data-control="select2" data-placeholder="Select Outside Punch Applicable">
                                                        <option></option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Shift Applicable')}}</label>
                                                    <select name="shift_applicable" class="form-select" id="shiftApplicable" data-control="select2" data-placeholder="Select Shift Applicable">
                                                        <option></option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Contact')}}</label>
                                                    <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Email')}}</label>
                                                    <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Date of Birth')}}</label>
                                                    <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Address')}}</label>
                                                    <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                                <div class="form-group">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <button type="button" form="quickForm" class="btn btn-success" id="salaryForm">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="content2" style="display: none;">
                    This is content for Option 2.
                </div>
            </div>
            <div class="tab-pane" id="tab_1_4">
                <p>Leave Details Content</p>
            </div>
            <div class="tab-pane" id="tab_1_5">
                <p>Experience Details Content</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom/users/user.js') }}"></script>
@endsection