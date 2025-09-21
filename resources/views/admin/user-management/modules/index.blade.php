@extends('layouts.admin')
@section('title') 
    {{ __('Module')}} 
@endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/comman.css') }}">
@endsection

@section('breadcrumb')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Add Module')}}</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/module')}}" class="text-muted text-hover-primary">{{ __('Module')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">{{ __('Add Module')}}</li>
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
                <h5 class="alert-heading">{{ __('Total Module')}}</h5>
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
                    <input type="text" id="searchInput" class="form-control w-250px ps-15" placeholder="Search department" />
                </div>
            </div>
            <div class="card-toolbar">
                @if(Auth::user()->hasPermissionToRoute('admin/module'))
                    <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#addModule" class="btn btn-primary" id="addModalBtn" >
                        {{ __('Add Module')}}
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="moduleTable">
                <thead>
                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center">{{ __('Id')}}</th>
                        <th class="text-center">{{ __('Name')}}</th>
                        <th class="text-center">{{ __('Action')}}</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($modules as $module)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $module->name }}</td>
                            <td class="text-center">
                                <button type="button" 
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select edit_module" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModule" 
                                    data-id="{{ $module->id }}" 
                                    data-name="{{ $module->name }}" 
                                    onclick="editModule(this)">
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
                                <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select delete_module" data-id="{{ $module->id }}" data-name="{{ $module->name }}">
                                    <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7H6V19ZM8 9H16V19H8V9Z" fill="currentColor"/>
                                            <path d="M19.7071 4.29289C20.0976 3.90237 20.0976 3.2692 19.7071 2.87868L17.1213 0.292893C16.7308 -0.0976311 16.0976 -0.0976311 15.7071 0.292893L14.4142 1.58579L18.4142 5.58579L19.7071 4.29289Z" fill="currentColor"/>
                                            <path d="M15.7071 4.29289C16.0976 3.90237 16.0976 3.2692 15.7071 2.87868L13.1213 0.292893C12.7308 -0.0976311 12.0976 -0.0976311 11.7071 0.292893L10.4142 1.58579L14.4142 5.58579L15.7071 4.29289Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </button>
                                <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 action-select" onclick="showModule(event)" data-id="{{ $module->id }}" data-name="{{ $module->name }}">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                        </svg>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No Data Found</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if ($totalPages > 1)
                <ul class="pagination">
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                            <a class="page-link pagination-link" href="#" data-page="{{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            @endif
        </div>
    </div>


    <!-- Create Module start -->
        <div class="modal fade modal-md" id="addModule" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addModuleTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Create Module')}}</h2>
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
                        <form id="moduleForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-4 " id="moduleNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Module')}}</label>
                                                        <input type="text" name="name" id="moduleName" class="form-control" maxlength="100" placeholder="Enter module name" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary moduleBtn" id="saveModuleBtn" onclick="saveModule(event)">{{ __('Create Module')}}</button>
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

    <!-- Update Module start -->
        <div class="modal fade modal-md" id="editModule" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="editModuleTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Update Module')}}</h2>
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
                        <form id="updateModuleForm" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="editModuleId">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-4 " id="updateModuleNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Module Name')}}</label>
                                                        <input type="text" name="name" id="editModuleName" class="form-control" maxlength="100" placeholder="Enter module name" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary moduleBtn" id="updateModuleBtn" onclick="updateModule(event)">{{ __('Update Module')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Update Module end -->

@endsection

@section('scripts')
<script src="{{asset('assets/js/custom/comman.js')}}"></script>
<script src="{{asset('assets/js/custom/roles/role.js')}}"></script>
@endsection