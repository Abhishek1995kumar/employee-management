@extends('layouts.admin')
@section('title') {{ __('User')}} @endsection

@section('header')

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
        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-bs-toggle="tab">User Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_2" data-bs-toggle="tab">Bank Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_3" data-bs-toggle="tab">Attendence Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_4" data-bs-toggle="tab">Leave Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_5" data-bs-toggle="tab">Experience Details</a></li>
    </ul>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
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
                                    <button type="submit" form="quickForm" class="btn btn-primary" id="salaryForm">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="tab_2">
                <form id="quickForm" action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="">
                                        <button type="submit" form="quickForm" class="btn btn-primary" onclick="nextTabOpen(event)">Next</button>
                                    </div>
                                    <div class="">
                                        <button type="submit" form="quickForm" class="btn btn-primary" onclick="addMoreBankDetails(event)">add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="bankDetails_0">
                                <div class="row">
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Bank Name')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Branch Name')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Beneficiary Name')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Account Number')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('IFSC Code')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                        <div class="form-group">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('Bank Statement')}}</label>
                                            <input type="text" name="name" id="roleName" class="form-control" maxlength="100" placeholder="Enter role name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script>
    function addMoreBankDetails(e) {
        e.preventDefault();
        let bankDetailsCount = document.querySelectorAll('.bankDetails').length;
        let newBankDetails = `
            <div class="card-body" id="bankDetails_${bankDetailsCount}">
                <div class="">
                    <a type="button" id="nextButton" class="fa fa-trash ${bankDetailsCount} btn btn-danger removeTr"></a>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('Bank Name')}}</label>
                            <input type="text" name="bank_name[]" class="form-control" maxlength="100" placeholder="Enter bank name" >
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('Branch Name')}}</label>
                            <input type="text" name="branch_name[]" class="form-control" maxlength="100" placeholder="Enter branch name" >
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group>
                            <label class="required fs-6 fw-semibold mb-2">{{ __('Beneficiary Name')}}</label>
                            <input type="text" name="beneficiary_name[]" class="form-control" maxlength="100" placeholder="Enter beneficiary name" >
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group>
                            <label class="required fs-6 fw-semibold mb-2">{{ __('Account Number')}}</label>
                            <input type="text" name="account_number[]" class="form-control" maxlength="100" placeholder="Enter account number" >
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group>
                            <label class="required fs-6 fw-semibold mb-2">{{ __('IFSC Code')}}</label>
                            <input type="text" name="ifsc_code[]" class="form-control" maxlength="100" placeholder="Enter IFSC code" >
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="ngoCenterDiv">
                        <div class="form-group>
                            <label class="required fs-6 fw-semibold mb-2">{{ __('Bank Statement')}}</label>
                            <input type="file" name="bank_statement[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" >
                        </div>
                    </div>
                </div>
            </div>
        `;
        let newDiv = document.createElement('div');
        newDiv.classList.add('bankDetails');
        newDiv.innerHTML = newBankDetails;
        document.querySelector('.card').appendChild(newDiv);
        flatpickr(document.querySelectorAll('.flatpickr'), {
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "F j, Y",
        });

        document.querySelectorAll('.removeTr').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.bankDetails').remove();
            });
        });
    }
</script>
@endsection