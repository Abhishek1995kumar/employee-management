
user create blade page --
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
        <li class="nav-item"><a class="nav-link active" href="#tab_1_1" data-bs-toggle="tab">{{ __('Subjects')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_2" data-bs-toggle="tab">{{ __('Interviews')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_3" data-bs-toggle="tab">{{ __('Questions')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_1_8" data-bs-toggle="tab">{{ __('Answers')}}</a></li>
    </ul>
    <div class="card-body">
        <div class="tab-content">
            <!-- User Details -->
            <div class="tab-pane active" id="tab_1_1">
                <form id="subjectForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4 " id="name_of_subject_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Subject')}}</label>
                                                <input type="text" name="subject_name" id="name_of_subject" class="form-control" placeholder="name of subject" >
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 " id="description_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Description')}}</label>
                                                <input type="text" name="description" id="description" class="form-control" placeholder="Enter subject description" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary saveSubjectBtn" id="" onclick="saveSubject(event)">Create Subject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                        <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="text-center min-w-125px">{{ __('Id')}}</th>
                                <th class="text-center min-w-125px">{{ __('Technology')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview Time')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview Date')}}</th>
                                <th class="text-center min-w-125px">{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($subjects as $subject)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="text-center"> {{ $subject->{'subject_name'} }} </td>
                                    <td class="text-center"> {{ $subject->{'interview_time'} }} </td>
                                    <td class="text-center"> {{ $subject->{'interview_time'} }} </td>
                                    <td class="text-center"> {{ \Carbon\Carbon::parse($subject->{'interview_date'})->format('d F Y') }} </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasPermission('admin.interview.subject.update'))
                                            <button type="button" 
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select subject_permission" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editSubject" 
                                                data-id="{{ $subject->id }}" 
                                                data-id="{{ $subject->it_id }}"
                                                data-subject_name="{{ $subject->subject_name }}"
                                                data-interview_name="{{ $subject->interview_name }}"
                                                data-interview_time="{{ $subject->interview_time }}"
                                                data-interview_date="{{ $subject->interview_date }}"
                                                onclick="editPermission(this)">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14.8284 2.34315C15.2196 2.73438 15.2196 3.36739 14.8284 3.75862L12.5858 6L10.4142 3.82843L12.6569 1.58579C13.0481 1.19557 13.6811 1.19557 14.0724 1.58579L14.8284 2.34315Z" fill="currentColor"/>
                                                        <path d="M16.2426 3.75736C16.6338 4.14859 16.6338 4.78161 16.2426 5.17284L14 7L11.8284 4.82843L14.0701 2.58579C14.4613 2.19557 15.0944 2.19557 15.4856 2.58579L16.2426 3.75736Z" fill="currentColor"/>
                                                        <path d="M19 7H5C4.44772 7 4 7.44772 4 8V20C4 20.5523 4.44772 21 5 21H19C19.5523 21 20 20.5523 20 20V8C20 7.44772 19.5523 7 19 7ZM18 18H6V9
                                                        C6 8.44772 6.44772 8 7 8H18C18.5523 8 19 8.44772 19 9V18C19 18.5523 18.5523 19 18 19Z" fill="currentColor"/>
                                                        <path d="M7 10H17C17.5523 10 18 10.4477 18 11V12C18 12.5523 17.5523 13 17 13H7C6.44772 13 6 12.5523 6 12V11C6 10.4477 6.44772 10 7 10Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                            
                                        @if(Auth::user()->hasPermission('admin.interview.subject.delete'))
                                            <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select subject_permission" data-id="{{ $subject->it_id }}" data-parent_id="{{ $subject->id }}"  data-subject_name="{{ $subject->subject_name }}" data-interview_date="{{ $subject->interview_date }}" data-interview_time="{{ $subject->interview_time }}" data-interview_name="{{ $subject->interview_name }}" data-created_by="{{ $subject->created_by }}" onclick="deleteDetails(event, 'admin/interview/exam/delete')">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7H6V19ZM8 9H16V19H8V9Z" fill="currentColor"/>
                                                        <path d="M19.7071 4.29289C20.0976 3.90237 20.0976 3.2692 19.7071 2.87868L17.1213 0.292893C16.7308 -0.0976311 16.0976 -0.0976311 15.7071 0.292893L14.4142 1.58579L18.4142 5.58579L19.7071 4.29289Z" fill="currentColor"/>
                                                        <path d="M15.7071 4.29289C16.0976 3.90237 16.0976 3.2692 15.7071 2.87868L13.1213 0.292893C12.7308 -0.0976311 12.0976 -0.0976311 11.7071 0.292893L10.4142 1.58579L14.4142 5.58579L15.7071 4.29289Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                        
                                        @if(Auth::user()->hasPermission('admin.interview.subject.show'))
                                            <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select" onclick="showPermission(event)" data-id="{{ $subject->id }}" data-it_id="{{ $subject->it_id }}"  data-subject_name="{{ $subject->subject_name }}" data-interview_date="{{ $subject->interview_date }}" data-interview_time="{{ $subject->interview_time }}" data-interview_name="{{ $subject->interview_name }}" data-created_by="{{ $subject->created_by }}" >
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Experience Details -->
            <div class="tab-pane" id="tab_1_2">
                <form id="interviewForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4 " id="category_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Select Subject')}}</label>
                                                <select name="subject_id" class="form-select" id="roleId" data-control="select2" data-placeholder="Select role name">
                                                    <option></option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 " id="category_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Select Subject')}}</label>
                                                <select name="subject_id" id="subject_id" class="form-select" data-control="select2" data-placeholder="Select subject name" >
                                                    <option selected disabled value="">Select subject</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 " id="interview_name_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Interview Name')}}</label>
                                                <input type="text" name="interview_name" id="interview_name" class="form-control" placeholder="Enter interview name" >
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 " id="interview_time_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Interview Time')}}</label>
                                                <input type="text" name="interview_time" id="interview_time" onclick="timePicker(event)" class="form-control" placeholder="Enter interview time" >
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 " id="interview_date_div">
                                            <div class="form-group">
                                                <label class="required fs-6 fw-semibold mb-2">{{ __('Interview Date')}}</label>
                                                <input type="text" name="interview_date" id="interview_date" onclick="openFlatpickr(event)" class="form-control" placeholder="Enter interview date" >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary saveInterviewBtn" id="" onclick="saveInterview(event)">Create Interview</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                        <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="text-center min-w-125px">{{ __('Id')}}</th>
                                <th class="text-center min-w-125px">{{ __('Technology')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview Time')}}</th>
                                <th class="text-center min-w-125px">{{ __('Interview Date')}}</th>
                                <th class="text-center min-w-125px">{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($subjects as $subject)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="text-center"> {{ $subject->{'subject_name'} }} </td>
                                    <td class="text-center"> {{ $subject->{'interview_time'} }} </td>
                                    <td class="text-center"> {{ $subject->{'interview_time'} }} </td>
                                    <td class="text-center"> {{ \Carbon\Carbon::parse($subject->{'interview_date'})->format('d F Y') }} </td>
                                    <td class="text-center">
                                        @if(Auth::user()->hasPermission('admin.interview.subject.update'))
                                            <button type="button" 
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select subject_permission" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editSubject" 
                                                data-id="{{ $subject->id }}" 
                                                data-id="{{ $subject->it_id }}"
                                                data-subject_name="{{ $subject->subject_name }}"
                                                data-interview_name="{{ $subject->interview_name }}"
                                                data-interview_time="{{ $subject->interview_time }}"
                                                data-interview_date="{{ $subject->interview_date }}"
                                                onclick="editPermission(this)">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14.8284 2.34315C15.2196 2.73438 15.2196 3.36739 14.8284 3.75862L12.5858 6L10.4142 3.82843L12.6569 1.58579C13.0481 1.19557 13.6811 1.19557 14.0724 1.58579L14.8284 2.34315Z" fill="currentColor"/>
                                                        <path d="M16.2426 3.75736C16.6338 4.14859 16.6338 4.78161 16.2426 5.17284L14 7L11.8284 4.82843L14.0701 2.58579C14.4613 2.19557 15.0944 2.19557 15.4856 2.58579L16.2426 3.75736Z" fill="currentColor"/>
                                                        <path d="M19 7H5C4.44772 7 4 7.44772 4 8V20C4 20.5523 4.44772 21 5 21H19C19.5523 21 20 20.5523 20 20V8C20 7.44772 19.5523 7 19 7ZM18 18H6V9
                                                        C6 8.44772 6.44772 8 7 8H18C18.5523 8 19 8.44772 19 9V18C19 18.5523 18.5523 19 18 19Z" fill="currentColor"/>
                                                        <path d="M7 10H17C17.5523 10 18 10.4477 18 11V12C18 12.5523 17.5523 13 17 13H7C6.44772 13 6 12.5523 6 12V11C6 10.4477 6.44772 10 7 10Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                            
                                        @if(Auth::user()->hasPermission('admin.interview.subject.delete'))
                                            <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select subject_permission" data-id="{{ $subject->it_id }}" data-parent_id="{{ $subject->id }}"  data-subject_name="{{ $subject->subject_name }}" data-interview_date="{{ $subject->interview_date }}" data-interview_time="{{ $subject->interview_time }}" data-interview_name="{{ $subject->interview_name }}" data-created_by="{{ $subject->created_by }}" onclick="deleteDetails(event, 'admin/interview/exam/delete')">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7H6V19ZM8 9H16V19H8V9Z" fill="currentColor"/>
                                                        <path d="M19.7071 4.29289C20.0976 3.90237 20.0976 3.2692 19.7071 2.87868L17.1213 0.292893C16.7308 -0.0976311 16.0976 -0.0976311 15.7071 0.292893L14.4142 1.58579L18.4142 5.58579L19.7071 4.29289Z" fill="currentColor"/>
                                                        <path d="M15.7071 4.29289C16.0976 3.90237 16.0976 3.2692 15.7071 2.87868L13.1213 0.292893C12.7308 -0.0976311 12.0976 -0.0976311 11.7071 0.292893L10.4142 1.58579L14.4142 5.58579L15.7071 4.29289Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                        
                                        @if(Auth::user()->hasPermission('admin.interview.subject.show'))
                                            <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select" onclick="showPermission(event)" data-id="{{ $subject->id }}" data-it_id="{{ $subject->it_id }}"  data-subject_name="{{ $subject->subject_name }}" data-interview_date="{{ $subject->interview_date }}" data-interview_time="{{ $subject->interview_time }}" data-interview_name="{{ $subject->interview_name }}" data-created_by="{{ $subject->created_by }}" >
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Document Upload -->
            <div class="tab-pane" id="tab_1_3">
                
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery-date.js') }}"></script>
<script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script src="{{ asset('assets/js/custom/users/user.js') }}"></script>
@endsection



