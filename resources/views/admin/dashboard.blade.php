@extends('layouts.admin')

@section('title','Dashboard')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link href="{{ asset('assets/css/comman.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .day{
            border-radius: 4rem;
        }
        .help-desk-card {
            padding-top: 0rem !important;
            padding-bottom: 2rem !important;
            padding-left: 0rem !important;
            padding-right: 1rem !important;
        }

    </style>
@endsection

@section('breadcrumb')
<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Dashboard</h1>

@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Departments')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Employees')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Managers')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Exit Employees')}}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-10">
    <!-- ABC CENTER SUMMARY -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-semibold fs-4 mb-1">{{ __('Calender')}}</span>
                    </h3>
                    <div class="card-toolbar">
                        <div id="calendar">
                            <div class="calendar-header">
                                <button id="prevMonth">◀</button>
                                <h2 id="monthYear"></h2>
                                <button id="nextMonth">▶</button>
                            </div>
                            <div class="calendar-grid" id="calendarGrid"></div>
                        </div>

                        <!-- Hover tooltip -->
                        <div id="tooltip" class="tooltip"></div>
                    </div>
                </div>
                <div class="card-body py-3">
                    
                </div>
            </div>
        </div>
    <!-- ABC CENTER SUMMARY -->
     
    <!-- Attendance & Leave Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-semibold fs-4 mb-1"> {{ __('Attendance & Leave')}} </span>
                    </h3>
                    <div class="card-toolbar">
                        <div class="col-md-12" style="display: flex; justify-content: space-between;">
                            <div class="col-md-6" style="">
                                <div class="mt-5"></div>
                                <div class="mt-5">
                                    <i class="fa-solid fa-hourglass-start"></i>
                                </div>
                                <div>{{ __('Time Spent Today')}}</div>
                                <div>{{ __('Absences in this month')}}</div>
                                <div>{{ __('General Leave available')}}</div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#applyLeave" id="createApplyLeave" class="btn btn-sm margin-bottom attendance-leave" >
                                    <i class="fa-solid fa-leaf"></i> {{ __('Apply Leave') }}
                                </buttona>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#regularization" id="createRegularizationLeave" class="btn btn-sm margin-bottom attendance-leave regularization-leave" >
                                    <i class="fa-solid fa-square-poll-horizontal"></i> {{ __('Regularize') }}
                                </button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#outdoorApplyModal" id="createoutdoorApplyModal" class="btn btn-sm margin-bottom attendance-leave outdoor-apply-modal" >
                                    <i class="fa-solid fa-person-hiking"></i> {{ __('Apply Outdoor') }}
                                </button>
                                <button class="btn btn-sm mt-2 margin-bottom attendance-leave">
                                    <i class="fa-solid fa-house-laptop"></i> {{ __('Apply WFH') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <!-- footer -->
                            <tfoot>
                                
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- Attendance & Leave Section -->
     
    <!-- Holiday Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 d-flex flex-row align-items-center justify-content-between">
                    <span class="card-label fw-semibold fs-4 mb-1">{{ __('Holidays')}}</span>
                    <select class="form-select" style="width:30%; border:none; box-shadow:none;">
                        <option value="2022">{{ __('2022')}}</option>
                        <option value="2023">{{ __('2023')}}</option>
                        <option value="2024">{{ __('2024')}}</option>
                        <option selected value="2025">{{ __('2025')}}</option>
                        <option value="2026">{{ __('2026')}}</option>
                        <option value="2027">{{ __('2027')}}</option>
                    </select>
                </div>
            </div>
        </div>
    <!-- Holiday Section -->

    <!-- Current Date Detail Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-semibold fs-4 mb-1">{{ __('Current Date Detail') }}</span>
                    </h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <div class="align-items-start gap-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Current Date Detail Section -->

    <!-- Leave Balance Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-semibold fs-4 mb-1">{{ __('Leave Balance') }}</span>
                    </h3>
                    <div class="card-toolbar">
                        <span class=" mb-1">{{ __('Tap on Leave Type Balance to apply for leave') }}</span>

                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="#" class="">
                                    <span>{{ __('General Leave') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="{{ url('admin/dashboard') }}" class="">
                                    <span>{{ __('Comp Off Leaves') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="#" class="">
                                    <span>{{ __('Election Holiday') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="#" class="">
                                    <span>{{ __('Paternity Leaves') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="#" class="">
                                    <span>{{ __('Sick Leave') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 table-responsive">
                            <div class="align-items-start gap-4">
                                <a href="#" class="">
                                    <span>{{ __('Special Leave') }}</span>
                                    <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
                                        <div class="d-flex flex-column mx-5">
                                            <span class="alert-heading">1.00</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Leave Balance Section -->

    
    <!-- Help Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 ">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-semibold fs-4 mb-1"> {{ __('Help Section')}} </span>
                    </h3>
                </div>
                <div class="card-body help-desk-card">
                    <div style="display: flex; justify-content: space-between;">
                        <div class="card">
                            <div class="card-body ">
                                <button class="btn btn-sm attendance-leave">{{ __('Help desk') }}</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm attendance-leave">{{ __('News & Articles') }}</button>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm attendance-leave">{{ __('HR Handbook') }}</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm attendance-leave">{{ __('FAQ"s') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Help Section -->
</div>

<!-- Attendence Leave Modal Start -->
<!-- Modal HTML's -->
<div class="modal fade" id="applyLeave" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="applyLeaveTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <input type="hidden" name="id" value="">
            <div class="modal-header">
                <h2 class="fw-bold">Apply Leave</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                    <span class="svg-icon svg-icon-1">
                        ✖
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <form id="roleForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div  style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-4">
                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Leave Type')}}</label>
                                    <select name="leave_type_details" class="form-select" id="leave_type_details" data-control="select2" data-placeholder="Select leave type details" >
                                        <option></option>
                                        <option value="1">{{ __('Absent')}}</option>
                                        <option value="2">{{ __('Present')}}</option>
                                        <option value="3">{{ __('Leave Applied')}}</option>
                                        <option value="4">{{ __('Leave Approved')}}</option>
                                        <option value="5">{{ __('Weekly Off')}}</option>
                                        <option value="6">{{ __('Holiday')}}</option>
                                        <option value="7">{{ __('Outdoor/WFH')}}</option>
                                        <option value="8">{{ __('Work From Home')}}</option>
                                        <option value="9">{{ __('Deputation')}}</option>
                                        <option value="10">{{ __('First Half Leave Applied')}}</option>
                                        <option value="11">{{ __('Second Half Leave Applied')}}</option>
                                        <option value="12">{{ __('Half Day')}}</option>
                                        <option value="13">{{ __('First Half Leave Approved')}}</option>
                                        <option value="14">{{ __('Second Half Leave Approved')}}</option>
                                        <option value="15">{{ __('Multiple Leave Applications')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Select Date</label>
                                            <input type="text" name="apply_leave" id="apply_leave" onclick="multiSelectFlatpickrCalendar(event)" class="form-control" placeholder="apply leave" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <div >
                                    <label class="required fs-6 fw-semibold mb-2">Leave Description</label>
                                    <textarea type="text" name="apply_leave_description" id="apply_leave_description" onclick="stringValidation(event)" class="form-control" placeholder="apply leave" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
                            <span class="legend"><span class="swatch cr-red"></span> {{ __('Absent')}} </span>
                            <span class="legend"><span class="swatch cr-green"></span> {{ __('Present')}} </span>
                            <span class="legend"><span class="swatch cr-orange"></span> {{ __('Leave Applied')}} </span>
                            <span class="legend"><span class="swatch cr-blue"></span> {{ __('Leave Approved')}} </span>
                            <!-- Child trigger -->
                            <button type="button" id="openChildModal" class="btn btn-sm btn-outline-primary ms-auto">...</button>
                        </div>
                    </div>
                    <div class="card-footer modal-footer">
                        <button type="submit" class="btn btn-primary roleBtn" id="applyLeaveBtnId" onclick="saveApplyLeave(event)">Apply Leave</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Child Modal -->
<div class="modal fade" id="leaveType" tabindex="-1" aria-labelledby="leaveTypeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveTypeLabel">Leave Type</h5>
                <button type="button" class="btn-close" id="closeChildModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="leaveTypeOptions" class="d-grid gap-2">
                    <label class="color-radio cr-red"> <input type="radio" name="leave_type_radio" value="absent" class="disable" > <span class="dot"></span> <span>Absent</span> </label>
                    <label class="color-radio cr-green"> <input type="radio" name="leave_type_radio" value="present" class="disable" > <span class="dot"></span> <span>Present</span> </label>
                    <label class="color-radio cr-orange"> <input type="radio" name="leave_type_radio" value="leave_applied" class="disable" > <span class="dot"></span> <span>Leave Applied</span> </label>
                    <label class="color-radio cr-blue"> <input type="radio" name="leave_type_radio" value="leave_approved" class="disable" > <span class="dot"></span> <span>Leave Approved</span> </label>
                    <label class="color-radio cr-purple"> <input type="radio" name="leave_type_radio" value="weekly_off" class="disable" > <span class="dot"></span> <span>Weekly Off</span> </label>
                    <label class="color-radio cr-teal"> <input type="radio" name="leave_type_radio" value="holiday" class="disable" > <span class="dot"></span> <span>Holiday</span> </label>
                    <label class="color-radio cr-brown"> <input type="radio" name="leave_type_radio" value="outdoor_wfh" class="disable" > <span class="dot"></span> <span>Outdoor/WFH</span> </label>
                    <label class="color-radio cr-cyan"> <input type="radio" name="leave_type_radio" value="wfh" class="disable" > <span class="dot"></span> <span>Work From Home</span> </label>
                    <label class="color-radio cr-indigo"> <input type="radio" name="leave_type_radio" value="deputation" class="disable" > <span class="dot"></span> <span>Deputation</span> </label>
                    <label class="color-radio cr-darkorange"> <input type="radio" name="leave_type_radio" value="first_half_applied" class="disable" > <span class="dot"></span> <span>First Half Leave Applied</span> </label>
                    <label class="color-radio cr-goldenrod"> <input type="radio" name="leave_type_radio" value="second_half_applied" class="disable" > <span class="dot"></span> <span>Second Half Leave Applied</span> </label>
                    <label class="color-radio cr-slate"> <input type="radio" name="leave_type_radio" value="half_day" class="disable" > <span class="dot"></span> <span>Half Day</span> </label>
                    <label class="color-radio cr-dodger"> <input type="radio" name="leave_type_radio" value="first_half_approved" class="disable" > <span class="dot"></span> <span>First Half Leave Approved</span> </label>
                    <label class="color-radio cr-sea"> <input type="radio" name="leave_type_radio" value="second_half_approved" class="disable" > <span class="dot"></span> <span>Second Half Leave Approved</span> </label>
                    <label class="color-radio cr-crimson"> <input type="radio" name="leave_type_radio" value="multiple" class="disable" > <span class="dot"></span> <span>Multiple Leave Applications</span> </label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Attendence Leave Modal End -->




<!-- Regularization Leave Modal Start -->
<!-- Modal HTML's -->
<div class="modal fade" id="regularization" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="regularizationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <input type="hidden" name="id" value="">
            <div class="modal-header">
                <h2 class="fw-bold">Regularize</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                    <span class="svg-icon svg-icon-1">
                        ✖
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <form id="roleForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div  style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Regularize</label>
                                            <input type="text" name="regularization_leave" id="regularization_leave" onclick="multiSelectFlatpickrCalendar(event)" class="form-control" placeholder="regularization leave" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Regularization Description</label>
                                            <textarea type="text" name="regularization_description" id="regularization_description" onclick="stringValidation(event)" class="form-control" placeholder="regularization leave description" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-wrap align-items-center gap-3">
                            <span class="legend"><span class="swatch cr-red"></span> {{ __('Absent')}} </span>
                            <span class="legend"><span class="swatch cr-green"></span> {{ __('Present')}} </span>
                            <span class="legend"><span class="swatch cr-orange"></span> {{ __('Leave Applied')}} </span>
                            <span class="legend"><span class="swatch cr-blue"></span> {{ __('Leave Approved')}} </span>
                            <!-- Child trigger -->
                            <button type="button" id="regularizationChildModal" class="btn btn-sm btn-outline-primary ms-auto">...</button>
                        </div>
                    </div>
                    <div class="card-footer modal-footer">
                        <button type="submit" class="btn btn-primary regularizationBtn" id="regularizationBtnId" onclick="saveRegularization(event)">Regularization</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Child Modal -->
<div class="modal fade" id="regularizationChildModal" tabindex="-1" aria-labelledby="regularizationChildModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="regularizationTypeLabel">Regularization Type</h5>
                <button type="button" class="btn-close" id="regularizationCloseChildModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="regularizationTypeOptions" class="d-grid gap-2">
                    <label class="color-radio cr-red"> <input type="radio" name="leave_type_radio" value="absent" class="disable" > <span class="dot"></span> <span>Absent</span> </label>
                    <label class="color-radio cr-green"> <input type="radio" name="leave_type_radio" value="present" class="disable" > <span class="dot"></span> <span>Present</span> </label>
                    <label class="color-radio cr-orange"> <input type="radio" name="leave_type_radio" value="leave_applied" class="disable" > <span class="dot"></span> <span>Leave Applied</span> </label>
                    <label class="color-radio cr-blue"> <input type="radio" name="leave_type_radio" value="leave_approved" class="disable" > <span class="dot"></span> <span>Leave Approved</span> </label>
                    <label class="color-radio cr-purple"> <input type="radio" name="leave_type_radio" value="weekly_off" class="disable" > <span class="dot"></span> <span>Weekly Off</span> </label>
                    <label class="color-radio cr-teal"> <input type="radio" name="leave_type_radio" value="holiday" class="disable" > <span class="dot"></span> <span>Holiday</span> </label>
                    <label class="color-radio cr-brown"> <input type="radio" name="leave_type_radio" value="outdoor_wfh" class="disable" > <span class="dot"></span> <span>Outdoor/WFH</span> </label>
                    <label class="color-radio cr-cyan"> <input type="radio" name="leave_type_radio" value="wfh" class="disable" > <span class="dot"></span> <span>Work From Home</span> </label>
                    <label class="color-radio cr-indigo"> <input type="radio" name="leave_type_radio" value="deputation" class="disable" > <span class="dot"></span> <span>Deputation</span> </label>
                    <label class="color-radio cr-darkorange"> <input type="radio" name="leave_type_radio" value="first_half_applied" class="disable" > <span class="dot"></span> <span>First Half Leave Applied</span> </label>
                    <label class="color-radio cr-goldenrod"> <input type="radio" name="leave_type_radio" value="second_half_applied" class="disable" > <span class="dot"></span> <span>Second Half Leave Applied</span> </label>
                    <label class="color-radio cr-slate"> <input type="radio" name="leave_type_radio" value="half_day" class="disable" > <span class="dot"></span> <span>Half Day</span> </label>
                    <label class="color-radio cr-dodger"> <input type="radio" name="leave_type_radio" value="first_half_approved" class="disable" > <span class="dot"></span> <span>First Half Leave Approved</span> </label>
                    <label class="color-radio cr-sea"> <input type="radio" name="leave_type_radio" value="second_half_approved" class="disable" > <span class="dot"></span> <span>Second Half Leave Approved</span> </label>
                    <label class="color-radio cr-crimson"> <input type="radio" name="leave_type_radio" value="multiple" class="disable" > <span class="dot"></span> <span>Multiple Leave Applications</span> </label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Regularization Leave Modal End -->




<!-- Regularization Leave Modal Start -->
<!-- Modal HTML's -->
<div class="modal fade" id="outdoorApplyModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="regularizationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <input type="hidden" name="id" value="">
            <div class="modal-header">
                <h2 class="fw-bold">Regularize</h2>
                <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                    <span class="svg-icon svg-icon-1">
                        ✖
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <form id="roleForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div  style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Outdoor Type')}}</label>
                                        <select name="outdoor_type_details" class="form-select" id="outdoor_type_details" data-control="select2" data-placeholder="Select outdoor type details" >
                                            <option></option>
                                            <option value="1">{{ __('Absent')}}</option>
                                            <option value="2">{{ __('Present')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Description</label>
                                            <textarea type="text" name="outdoor_description" id="outdoor_description" onclick="stringValidation(event)" class="form-control" placeholder="outdoor leave description" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div  style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">From Date</label>
                                            <input type="text" name="from_date_outdoor" id="from_date_outdoor" onclick="showThreeMonthBefroreFromCrruentMonthAndOneMonthAfter(event)" class="form-control" placeholder="from date outdoor" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">To Date</label>
                                            <input type="text" name="to_date_outdoor" id="to_date_outdoor" onclick="showThreeMonthBefroreFromCrruentMonthAndOneMonthAfter(event)" class="form-control" placeholder="to date outdoor" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Day</label>
                                            <input type="text" name="total_days_outdoor" id="total_days_outdoor" class="form-control" readonly >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div  style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">In Time</label>
                                            <input type="text" name="in_time_outdoor" id="in_time_outdoor" onclick="timePicker(event)" class="form-control" placeholder="in time outdoor" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Out Time</label>
                                            <input type="text" name="out_time_outdoor" id="out_time_outdoor" onclick="timePicker(event)" class="form-control" placeholder="out time outdoor" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div >
                                            <label class="required fs-6 fw-semibold mb-2">Hour</label>
                                            <input type="text" name="total_hour_outdoor" id="total_hour_outdoor" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer modal-footer">
                        <button type="submit" class="btn btn-primary regularizationBtn" id="regularizationBtnId" onclick="saveRegularization(event)">Regularization</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Apply Outdoor Leave Modal End -->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/custom/users/user.js') }}"></script>
<script src="{{ asset('assets/js/custom/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script src="{{ asset('assets/js/jquery-date.js') }}"></script>
@endsection