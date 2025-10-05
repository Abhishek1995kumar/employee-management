@extends('layouts.admin')

@section('title','Dashboard')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link href="{{ asset('assets/css/comman.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event {
            font-size: 0.7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                <span class="alert-heading">{{ __('Total Present Days : ')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Absent Days : ')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Working Hours : ')}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">{{ __('Total Working Hours : ')}}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-10 calender_card">
    <!-- Calender Start -->
        <div class="col-md-7">
            <div class="card mb-5">
                <!-- Card Header with Toolbar -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">📅 Calendar</h3>
                    <div class="card-toolbar d-flex gap-2">
                        <button class="btn btn-primary btn-sm">Export</button>
                        <button class="btn btn-success btn-sm">Leave Apply</button>
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm">Month</button>
                            <button class="btn btn-outline-secondary btn-sm">Week</button>
                            <button class="btn btn-outline-secondary btn-sm">Day</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    <!-- Calender End -->


    <!-- Holiday Section -->
        <div class="col-md-5">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 d-flex flex-row align-items-center justify-content-between">
                    <span class="card-label fw-semibold fs-4 mb-1">{{ __('Holidays')}}</span>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <select name="holiday_year" id="year_of_holiday_id" class="form-select" data-control="select2" data-placeholder="Select year" onchange="getYearWiseHoliday(event)">
                                <option selected disabled>{{ __('Year')}}</option>
                                @foreach($yearWiseHolidays as $holiday)
                                    <option value="{{ $holiday->holiday_year }}">{{ $holiday->holiday_year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-body holiday-table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped custom-holiday-table" id="holidayTable">
                            <thead style="background-color: #0a6533ff !important; padding: 3px;">
                                <tr>
                                    <th >Holiday Date</th>
                                    <th>Holiday Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- Holiday Section -->

     

    <!-- Current Date Detail Section -->
        <div class="col-md-4">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column"> {{ __('Current Date Detail') }} </h3>
                </div>
                <div class="card-body py-3">
                    <div class="align-items-start gap-4" >
                        <div class="d-flex flex-column">
                            <span class="fw-semibold fs-4 mb-1">{{ __('Current date : ') }}</span>
                            <span class="fw-semibold fs-4 mb-1">{{ __('Current time : ') }}</span>
                            <div><span class="fw-semibold fs-4 mb-1">{{ __('Total today working hour is : ') }} {{ __('9:47 hours total work')}}</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Current Date Detail Section -->


    <!-- Attendance & Leave Section -->
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">{{ __('Attendance & Leave') }}</h3>
                    <br><br><br>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#applyLeaveModal"
                            class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-leaf"></i> {{ __('Apply Leave') }}
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#regularizeAttendanceModal"
                            class="btn btn-sm btn-secondary">
                            <i class="fa-solid fa-square-poll-horizontal"></i> {{ __('Regularize') }}
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#outdoorApplyModal"
                            class="btn btn-sm btn-info">
                            <i class="fa-solid fa-person-hiking"></i> {{ __('Apply Outdoor') }}
                        </button>
                        <button class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-house-laptop"></i> {{ __('Apply WFH') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3"><i class="fa-solid fa-hourglass-start"></i> {{ __('Time Spent Today') }}</div>
                    <div class="mb-3">{{ __('Absences in this month') }}</div>
                    <div>{{ __('General Leave available') }}</div>
                </div>
            </div>
        </div>
    <!-- End Attendance & Leave Section -->


    <!-- Leave Balance Section -->
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-4">
                    <h3 class="card-title mb-0">{{ __('Leave Balance') }}</h3>
                    <small class="text-muted">{{ __('Tap on Leave Type Balance to apply for leave') }}</small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="#" class="text-decoration-none">
                                <span>{{ __('General Leave') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('admin/dashboard') }}" class="text-decoration-none">
                                <span>{{ __('Comp Off Leaves') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="text-decoration-none">
                                <span>{{ __('Election Holiday') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="text-decoration-none">
                                <span>{{ __('Paternity Leaves') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="text-decoration-none">
                                <span>{{ __('Sick Leave') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="text-decoration-none">
                                <span>{{ __('Special Leave') }}</span>
                                <div class="alert alert-primary text-center mt-2">
                                    <span class="fw-bold">1.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Leave Balance Section -->


    <!-- Help Section -->
        <div class="col-lg-4 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-4">
                    <h3 class="card-title mb-0">{{ __('Help Section') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-primary w-100">{{ __('Help desk') }}</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-primary w-100">{{ __('News & Articles') }}</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-primary w-100">{{ __('HR Handbook') }}</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-outline-primary w-100">{{ __('FAQ"s') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Help Section -->

</div>


<!-- All Modal Start -->
    <!-- Jam ham calender date par click karte hai ab ye modal bhi run hota hai -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form id="eventForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="eventDate">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Event Title</label>
                                <input type="text" id="eventTitle" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventTime" class="form-label">Event Time</label>
                                <input type="time" id="eventTime" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="eventColor" class="form-label">Choose Color</label>
                                <input type="color" id="eventColor" value="#0d6efd" class="form-control form-control-color">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save Event</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    <!-- Jam ham calender date par click karte hai ab ye modal bhi run hota hai -->

    <!-- Modal Open Current Date keliye (Current Date) -->
        <div class="modal fade" id="todayAttendanceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Attendance Schedule Details')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="todayAttendanceModalForm">
                            <input type="hidden" id="eventDate">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <span>{{ __('Attendance has been marked for today.')}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-2" id="inside_punchin_div" >
                                        <button type="submit" class="btn btn-sm btn-success " id="inside_punchin">{{ __('Inside PunchIn')}}</button>
                                    </div>

                                    <div class="col-md-2" id="outside_punchin_div">
                                        <button type="submit" class="btn btn-sm btn-success " id="outside_punchin">{{ __('Outside PunchIn')}}</button>
                                    </div>

                                    <div class="col-md-2" id="inside_late_punchin_div">
                                        <button type="submit" class="btn btn-sm btn-warning " id="inside_punchout">{{ __('Inside Late Punch In')}}</button>
                                    </div>

                                    <div class="col-md-2" id="outside_late_punchin_div">
                                        <button type="submit" class="btn btn-sm btn-warning " id="outside_punchout">{{ __('Outside Late Punch In')}}</button>
                                    </div>

                                    <div class="col-md-2" id="inside_punchout_div">
                                        <button type="submit" class="btn btn-sm btn-success " id="inside_punchout">{{ __('Inside PunchOut')}}</button>
                                    </div>

                                    <div class="col-md-2" id="outside_punchout_div">
                                        <button type="submit" class="btn btn-sm btn-success " id="outside_punchout">{{ __('Outside PunchOut')}}</button>
                                    </div>

                                    <div class="col-md-2" id="inside_before_punchout_div">
                                        <button type="submit" class="btn btn-sm btn-danger " id="inside_before_punchout">{{ __('Inside Before Punch Out')}}</button>
                                    </div>

                                    <div class="col-md-2" id="outside_before_punchout_div">
                                        <button type="submit" class="btn btn-sm btn-danger " id="outside_before_punchout">{{ __('Outside Before Punch In')}}</button>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div><br>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <span id="ifOutSideLocation">{{ __('You are outside of your office loaction,Please Go 200 meters near to your office location else your Punchin/PunchOut will be treated as outside.')}}</span>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="eventColor" class="form-label">{{ __('Your Current Location:-')}}</label>
                                    <input id="yourCurrentLocation" name="user_current_location" type="text" value="" class="form-control" style="border: none;" readonly>
                                    <input id="yourLatLocation" name="user_latitude" type="hidden">
                                    <input id="yourLogLocation" name="user_longitude" type="hidden">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save Event</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Open Current Date keliye (Current Date) -->

    <!-- Missing Punchin Ke liye Modal (Past Date)-->
        <div class="modal fade" id="regularizeAttendanceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add Request For Regularize Attendance')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#applyLeaveModal">{{ __('Apply Leave')}}</button>
                        </div> <hr> <br> -->
                        <form id="regularizeAttendanceModalForm">
                            <input type="hidden" id="eventDate">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="punchInTimeId" class="form-label">{{ __('Punch In Time')}}</label>
                                            <input type="text" id="punchInTimeId" class="form-control" onfocus="openFlatpickr(event)" require>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="punchOutTimeId" class="form-label">{{ __('Punch Out Time')}}</label>
                                            <input type="text" id="punchOutTimeId" class="form-control" onfocus="openFlatpickr(event)" require>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="eventColor" class="form-label">{{ __('Reason')}}</label>
                                            <input type="text" id="reasonId" oninput="stringValidation(event)" class="form-control" require>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="eventColor" class="form-label">{{ __('Your Current Location:-')}}</label>
                                    <span></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save Event</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Missing Punchin Ke liye Modal (Past Date)-->


    <!-- Tommorow Date ke liye Leave (Upcoming Date) -->
        <div class="modal fade" id="applyLeaveModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add Request For Leave')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <form id="requestLeaveForm">
                            <input type="hidden" id="requestLeaveDate">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-6 ">
                                        <label for="punchInTimeId_2" class="form-label">{{ __('Select Leave Type')}}</label>
                                        <select name="leave_type" class="form-select" id="punchInTimeId_2" data-control="select2" data-placeholder="Select leave type">
                                            <option></option>
                                            <option value="1">{{ __('Professional Leave')}}</option>
                                            <option value="2">{{ __('Sick Leave')}}</option>
                                            <option value="3">{{ __('Emeragency Leave')}}</option>
                                            <option value="4">{{ __('Outdoor/WFH')}}</option>
                                            <option value="5">{{ __('First Half Leave Applied')}}</option>
                                            <option value="6">{{ __('Second Half Leave Applied')}}</option>
                                            <option value="7">{{ __('Half Day')}}</option>
                                            <option value="8">{{ __('First Half Leave Approved')}}</option>
                                            <option value="9">{{ __('Second Half Leave Approved')}}</option>
                                            <option value="10">{{ __('Multiple Leave Applications')}}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Single Or Multiple Days Leave')}}</label>
                                        <div>
                                            <label class=" fs-6 fw-semibold mb-2">
                                                {{ __('Single')}}
                                                <input type="checkbox" name="single_leave_type" id="single_leave_type" class="mx-2" onclick="handleTypeCheckbox('single_leave_type_div')">
                                            </label>
                                            <label class="fs-6 fw-semibold mb-2">
                                                {{ __('Multiple')}}
                                                <input type="checkbox" name="multiple_leave_type" id="multiple_leave_type" class="ml-4 mx-2" onclick="handleTypeCheckbox('multiple_leave_type_div')">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6 mb-4" id="single_leave_type_div" style="display: none;">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">{{ __('Select Date')}}</label>
                                    <input type="text" name="leave_date" id="leave_date" onfocus="openFlatpickr(event)" class="form-control" placeholder="signle leave date">
                                </div>
                            </div>

                            <div class="col-md-12 mb-4" id="multiple_leave_type_div" style="display: none;">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">{{ __('From Date')}}</label>
                                        <input type="text" name="leave_start_date" id="leave_start_date" onfocus="openFlatpickr(event)" class="form-control" placeholder="leave start date">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-semibold mb-2">{{ __('To Date')}}</label>
                                        <input type="text" name="leave_end_date" id="leave_end_date" onfocus="openFlatpickr(event)" class="form-control" placeholder="leave end date">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div >
                                                <label class="required fs-6 fw-semibold mb-2">Leave Description</label>
                                                <textarea type="text" name="apply_leave_description" id="apply_leave_description" oninput="stringValidation(event)" class="form-control" placeholder="apply leave" ></textarea>
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
                                <button type="button" class="btn btn-sm btn-outline-primary ms-auto openChildModal" id="celanderOpenChildModal">...</button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save Event</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Tommorow Date ke liye Leave (Upcoming Date) -->

    <!-- outdoor apply modal -->
        <div class="modal fade" id="outdoorApplyModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="regularizationTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">Outside/WFH Regularize</h2>
                        <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <span class="svg-icon svg-icon-1">
                                ✖
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#applyLeaveModal">{{ __('Apply Leave')}}</button>
                        </div> <hr> <br>
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
    <!-- outdoor apply modal -->

    <!-- Type of Leave  Child Modal (ye modal ka koi kaam nahi hai sirf leave ke type show karne ke liye hai)-->
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
    <!-- Type of Leave Child Modal -->
<!-- All Modal End -->




@endsection

@section('scripts')
    <script src="{{ asset('assets/js/custom/comman.js') }}"></script>
    <script src="{{ asset('assets/js/custom/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-date.js') }}"></script>
    <!-- FullCalendar JS -->
    <script src="{{ asset('assets/js/calender/index.global.min.js') }}"></script>
    <script>
        const getHolidayDetailsURL = "{{ url('admin/dashboard/get-holiday-details') }}";
    </script>
@endsection