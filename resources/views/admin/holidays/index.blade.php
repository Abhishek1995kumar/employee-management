@extends('layouts.admin')
@section('title')
    {{ __('Holiday')}}
@endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/comman.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Holiday List')}}</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">{{ __('Holiday')}}</li>
    </ul>
@endsection

@section('content')
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

    <div class="row">
        <div class="col-3">
            <div class="alert alert-success text-center border border-success">
                <h5 class="alert-heading">{{ __('Total Holiday')}}</h5>
                <p class="mb-0" id="completeValue"></p>
            </div>
        </div>
        
    </div>

    <div class="card mt-4">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" data-kt-table-filter="search" class="form-control w-250px ps-15" placeholder="Search department" />
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#addHoliday" class="btn btn-primary" >
                    {{ __('Add Holiday')}}
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                <thead>
                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center min-w-125px">{{ __('Id')}}</th>
                        <th class="text-center min-w-125px">{{ __('Name')}}</th>
                        <th class="text-center min-w-125px">{{ __('Description')}}</th>
                        <th class="text-center min-w-125px">{{ __('Action')}}</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Designation start -->
        <div class="modal fade modal-lg" id="addHoliday" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addHoliday" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Create Holiday')}}</h2>
                        <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="holidayForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 " id="firm_id_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Company Firm')}}</label>
                                                        <select name="firm_id" id="firm_id" class="form-select" data-control="select2" data-placeholder="Select firm " >
                                                            <option ></option>
                                                            <option value="luck_101">Lucknow</option>
                                                            <option value="del_101">Delhi</option>
                                                            <option value="mum_101">Mumbai</option>
                                                            <option value="chen_101">Chennai</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="name_of_holiday_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Name Of Holiday')}}</label>
                                                        <input type="text" name="holiday_name" id="name_of_holiday" oninput="stringValidation(event)" class="form-control" placeholder="name of holiday" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="day_for_holiday_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Day For Holiday')}}</label>
                                                        <select name="day_of_holiday" id="day_for_holiday" class="form-select" data-control="select2" data-placeholder="Select day for holiday" >
                                                            <option ></option>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thusday">Thusday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                            <option value="Sunday">Sunday</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_month_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Month')}}</label>
                                                        <select name="month_of_holiday" id="holiday_month" class="form-select" data-control="select2" data-placeholder="Select holiday month" >
                                                            <option ></option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_year_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Year')}}</label>
                                                        <select name="year_of_holiday" id="holiday_year" class="form-select" data-control="select2" data-placeholder="Select holiday year" >
                                                            <option ></option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="category_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Category')}}</label>
                                                        <select name="category" id="category_name" class="form-select" data-control="select2" data-placeholder="Select holiday category" >
                                                            <option value="">Select Category</option>
                                                            <option value="1">National Holiday</option>
                                                            <option value="2">State Holiday</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="color_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Color')}}</label>
                                                        <input type="color" name="color" id="color" class="form-control" value="#ff0000">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="description_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Description')}}</label>
                                                        <input type="text" name="description" id="description" onclick="stringValidation(event)" class="form-control" placeholder="Enter holiday description" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_date_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Start Date')}}</label>
                                                        <input type="text" name="holiday_start_date" id="holiday_start_date" onclick="openFlatpickr(event)" class="form-control" placeholder="Enter holiday start date" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_date_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday End Date')}}</label>
                                                        <input type="text" name="holiday_end_date" id="holiday_end_date" onclick="openFlatpickr(event)" class="form-control" placeholder="Enter holiday end date" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_image_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Image')}}</label>
                                                        <input type="file" name="holiday_image" id="holiday_image" class="form-control" placeholder="Enter holiday image" >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary saveHolidayBtn" id="" onclick="saveHoliday(event)">Create Designation</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Create Designation end -->

@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom/roles/role.js') }}"></script>
<script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script src="{{ asset('assets/js/jquery-date.js') }}"></script>

@endsection