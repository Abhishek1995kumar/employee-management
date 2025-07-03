@extends('layouts.admin')
@section('title')
    Designation
@endsection

@section('header')

@endsection

@section('breadcrumb')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Add Designation</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/role')}}" class="text-muted text-hover-primary">Designation</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Add Designation</li>
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
                <h5 class="alert-heading">Total Designation</h5>
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
                <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#addDesignation" class="btn btn-primary" >
                    Add Designation
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
        <div class="modal fade modal-lg" id="addDesignation" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addDesignation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Create Designation')}}</h2>
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
                        <form id="designationForm" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" name="application_category_id" value="8">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 " id="departmentDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">Department</label>
                                                        <select name="department_name" class="form-select" id="departmentId" data-control="select2" data-placeholder="Select department name" >
                                                            <option ></option>
                                                            <option value="1">ABC Center</option>
                                                            <option value="2">Veterinary Health Department</option>
                                                            <option value="3">MR Rabies Response Team</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="designationNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">Designation</label>
                                                        <input type="text" name="name" id="designationName" class="form-control" maxlength="100" placeholder="Enter department name" >
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
<script>
    var KTAppEcommerceCategories = function() {
        var n = () => {

        };
        return {
            init: function() {
                (t = document.querySelector("#kt_table")) && ((e = $(t).DataTable({
                    info: !1,
                    order: [],
                    pageLength: 10,

                })).on("draw", (function() {
                    n()
                })), document.querySelector('[data-kt-table-filter="search"]').addEventListener("keyup", (function(t) {
                    e.search(t.target.value).draw()
                })), n())
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTAppEcommerceCategories.init()
    }));
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

<script>
    $('#addDesignation').on('hidden.bs.modal', function () {
        $('#animalVaccinationForm')[0].reset();
        $('#animalVaccinationForm').find('select').val('').trigger('change');
        $('#animalVaccinationForm').find('input[type="file"]').val('');
        $('#animalFirstImageId').val('');
        $('#animalImageId').val('');
    });

    function saveDesignation(e) {
        e.preventDefault(); 
        let departmentId = $("#departmentId").val();
        let designationName = $("#designationName").val();
        if (departmentId === '') {
            Swal.fire({
                title: 'Missing department name',
                text: "Please select a valid department name.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (designationName === '') {
            Swal.fire({
                title: 'Missing designation name',
                text: "Please enter a designation name.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        document.getElementById("designationForm").submit();
    }
</script>

@endsection