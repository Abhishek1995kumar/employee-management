@extends('layouts.admin')
@section('title') {{ __('Employee Management')}} @endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/comman.css') }}">
@endsection

@section('breadcrumb')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Employee Details')}}</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">{{ __('Employee Details')}}</li>
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
                <h5 class="alert-heading">{{ __('Total Employee')}}</h5>
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
                @if(Auth::user()->hasPermissionToRoute('admin/user/create'))
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary mx-3">
                        {{ __('Add Employee')}}
                    </a>
                @else
                @endif
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                <thead>
                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center min-w-125px">{{ __('Id')}}</th>
                        <th class="text-center min-w-125px">{{ __('Name')}}</th>
                        <th class="text-center min-w-125px">{{ __('Role')}}</th>
                        <th class="text-center min-w-125px">{{ __('Action')}}</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td class="text-center">{{ $user->username }}</td>
                            <td class="text-center">
                                @if($user->role_name)
                                        <span class="badge badge-light-primary">{{ $user->role_name }}</span>
                                @else
                                    <span class="badge badge-light-danger">{{ __('No role name')}}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(Auth::user()->hasPermissionToRoute('admin/user/update'))
                                <a href="{{ route('admin.users.update', $user->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.8284 2.34315C15.2196 2.73438 15.2196 3.36739 14.8284 3.75862L12.5858 6L10.4142 3.82843L12.6569 1.58579C13.0481 1.19557 13.6811 1.19557 14.0724 1.58579L14.8284 2.34315Z" fill="currentColor"/>
                                            <path d="M16.2426 3.75736C16.6338 4.14859 16.6338 4.78161 16.2426 5.17284L14 7L11.8284 4.82843L14.0701 2.58579C14.4613 2.19557 15.0944 2.19557 15.4856 2.58579L16.2426 3.75736Z" fill="currentColor"/>
                                            <path d="M19 7H5C4.44772 7 4 7.44772 4 8V20C4 20.5523 4.44772 21 5 21H19C19.5523 21 20 20.5523 20 20V8C20 7.44772 19.5523 7 19 7ZM18 18H6V9
                                            C6 8.44772 6.44772 8 7 8H18C18.5523 8 19 8.44772 19 9V18C19 18.5523 18.5523 19 18 19Z" fill="currentColor"/>
                                            <path d="M7 10H17C17.5523 10 18 10.4477 18 11V12C18 12.5523 17.5523 13 17 13H7C6.44772 13 6 12.5523 6 12V11C6 10.4477 6.44772 10 7 10Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </a>
                                @else
                                @endif
                                @if(Auth::user()->hasPermissionToRoute('admin/user/delete'))
                                <a href="{{ route('admin.users.delete', $user->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7H6V19ZM8 9H16V19H8V9Z" fill="currentColor"/>
                                            <path d="M19.7071 4.29289C20.0976 3.90237 20.0976 3.2692 19.7071 2.87868L17.1213 0.292893C16.7308 -0.0976311 16.0976 -0.0976311 15.7071 0.292893L14.4142 1.58579L18.4142 5.58579L19.7071 4.29289Z" fill="currentColor"/>
                                            <path d="M15.7071 4.29289C16.0976 3.90237 16.0976 3.2692 15.7071 2.87868L13.1213 0.292893C12.7308 -0.0976311 12.0976 -0.0976311 11.7071 0.292893L10.4142 1.58579L14.4142 5.58579L15.7071 4.29289Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </a>
                                @else
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('assets/js/custom/roles/role.js')}}"></script>
@endsection