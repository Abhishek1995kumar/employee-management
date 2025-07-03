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

    <form id="quickForm" action="{{ url('admin/animal/vaccination/update') .'/'. $firldVaccination->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="fw-bold m-0">{{ __('Create User')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="application_category_id" value="8">
                        <div class="row">

                            <div class="col-md-6 mb-4 ">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2"></label>
                                    <select name="assigned_to" class="form-select" id="requestSourceId" data-control="select2" required>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4" id="ngoCenterDiv">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2"></label>
                                    <select name="ngo_id" class="form-select" id="ngoNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 " id="">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="wordNameId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" id="councilWardDiv" style="display: none;">
                                <div class="form-group">
                                    <label class="required fs-6 fw-semibold mb-2" for="councilWordId"></label>
                                    <select name="word_id" class="form-select" id="wordNameId" data-control="select2" data-placeholder="Select area" required>
                                        <option value=""></option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer modal-footer">
                        <button type="submit" form="quickForm" class="btn btn-primary" id="submitGrievanceDetailsFromAdmin">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script>
    flatpickr("#start_date", {
        dateFormat: "d F Y",
    });

    flatpickr("#end_date", {
        dateFormat: "d F Y",
    });

    // $("#ngoCenterDiv").hide();
    // $("#councilWardDiv").hide();
    
    $(document).ready(function() {
        $('#requestSourceId').on('change', function() {
            let requestSource = $('#requestSourceId').val();
            if(requestSource == 1) {
                $("#ngoCenterDiv").show();
            } else {
                $("#ngoCenterDiv").hide();
            }
        });

        $('#wordNameId').on('change', function() {
            let wordName = $('#wordNameId').val();
            let selectedCouncilWard = "{{ $firldVaccination->council_word_id ?? '' }}"; // Already saved council ward ID
            if (wordName != '') {
                $.ajax({
                    url: "/admin/field-vaccination/get/council/" + wordName,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#councilWardDiv').show();
                            let councilWardDropdown = $('#councilWordId');
                            councilWardDropdown.empty();
                            councilWardDropdown.append('<option value="">Select Council Ward</option>');

                            $.each(response.councilWards, function(index, councilWard) {
                                let selected = (councilWard.id == selectedCouncilWard) ? 'selected' : '';
                                councilWardDropdown.append('<option value="' + councilWard.id + '" ' + selected + '>' + councilWard.name + '</option>');
                            });

                            $('#councilWordId').trigger('change'); // Select2 dropdown refresh
                        }
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            } else {
                $("#councilWardDiv").hide();
                $('#councilWordId').empty(); // Clear dropdown if no ward is selected
            }
        });

        // Trigger Ward Change on Page Load for Edit Mode**
        $(document).ready(function() {
            let selectedWord = "{{ $firldVaccination->word_id ?? '' }}"; // Already saved word_id
            let selectedNgo = "{{ $firldVaccination->ngo_id ?? '' }}"; 
            if (selectedNgo) {
                $('#ngoNameId').val(selectedNgo).trigger('change'); // Ward change event fire karega
            }
            if (selectedWord) {
                $('#wordNameId').val(selectedWord).trigger('change');
            }
        });

    });
</script>
@endsection