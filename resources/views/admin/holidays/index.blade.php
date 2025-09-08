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
                        <form id="holidayForm" action="{{ route('admin.designation.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 " id="name_of_holiday_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Name Of Holiday')}}</label>
                                                        <input type="text" name="name_of_holiday" id="name_of_holiday" oninput="stringValidation(event)" class="form-control" placeholder="name of holiday" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="day_for_holiday_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Day For Holiday')}}</label>
                                                        <select name="day_for_holiday" id="day_for_holiday" class="form-select" data-control="select2" data-placeholder="Select day for holiday" >
                                                            <option ></option>
                                                                <option >Monday</option>
                                                                <option >Tuesday</option>
                                                                <option >Wednesday</option>
                                                                <option >Thusday</option>
                                                                <option >Friday</option>
                                                                <option >Saturday</option>
                                                                <option >Sunday</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_year_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Year')}}</label>
                                                        <select name="holiday_year" class="form-select" id="holiday_year" data-control="select2" data-placeholder="Select holiday year" >
                                                            <option ></option>
                                                                <option >2021</option>
                                                                <option >2022</option>
                                                                <option >2023</option>
                                                                <option >2024</option>
                                                                <option >2025</option>
                                                                <option >2026</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="holiday_month_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Month')}}</label>
                                                        <select name="holiday_month" class="form-select" id="holiday_month" data-control="select2" data-placeholder="Select holiday month" >
                                                            <option ></option>
                                                            <option >January</option>
                                                            <option >Feb</option>
                                                            <option >March</option>
                                                            <option >April</option>
                                                            <option >May</option>
                                                            <option >June</option>
                                                            <option >July</option>
                                                            <option >August</option>
                                                            <option >September</option>
                                                            <option >Octuber</option>
                                                            <option >November</option>
                                                            <option >December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-4 " id="holiday_date_div">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Holiday Date')}}</label>
                                                        <input type="text" name="holiday_date" id="holiday_date" onclick="openFlatpickrForMonth(event)" class="form-control" placeholder="Enter description" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary" id="" onclick="saveDesignation(event)">Create Designation</button>
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
<script src="{{ asset('assets/js/custom/users/user.js') }}"></script>
<script src="{{ asset('assets/js/jquery-date.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('holiday_year');
    const monthSelect = document.getElementById('holiday_month');
    const dateInput = document.getElementById('holiday_date');

    // 1 — Auto open month when year is selected
    yearSelect.addEventListener('change', function () {
        if (this.value) {
            monthSelect.focus();
            monthSelect.click();
        }
    });

    monthSelect.addEventListener('change', function () {
        if (this.value && yearSelect.value) {
            openFlatpickrForMonth(dateInput, yearSelect.value, this.value);
        }
    });
});

function getMonthNumber(monthName) {
    const months = {
        January: 1, Feb: 2, March: 3, April: 4, May: 5, June: 6,
        July: 7, August: 8, September: 9, Octuber: 10, November: 11, December: 12
    };
    return months[monthName] || null;
}

function openFlatpickrForMonth(input, year, monthName) {
    const monthNum = getMonthNumber(monthName);
    if (!monthNum) return;

    const firstDay = new Date(year, monthNum - 1, 1);
    const lastDay = new Date(year, monthNum, 0);

    if (input._flatpickr) {
        input._flatpickr.destroy(); // Re-init if already exists
    }

    input._flatpickr = flatpickr(input, {
        dateFormat: 'Y-m-d',
        minDate: firstDay,
        maxDate: lastDay,
        defaultDate: firstDay,
        onChange: function (selectedDates, dateStr) {
            input.value = dateStr;
        }
    });

    input._flatpickr.open();
}
</script>
@endsection