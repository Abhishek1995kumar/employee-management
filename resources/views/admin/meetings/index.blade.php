@extends('layouts.admin')
@section('title') 
    {{ __('Meeting Management')}} 
@endsection

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/comman.css') }}">
@endsection

@section('breadcrumb')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ __('Add Meeting')}}</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/dashboard')}}" class="text-muted text-hover-primary">{{ __('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{url('/admin/permission')}}" class="text-muted text-hover-primary">{{ __('Meeting')}}</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">{{ __('Add Meeting')}}</li>
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
                <h5 class="alert-heading">{{ __('Todays Total Meeting')}}</h5>
                <p class="mb-0" id="totalMeeting"></p>
            </div>
        </div>
        <div class="col-3">
            <div class="alert alert-success text-center border border-success">
                <h5 class="alert-heading">{{ __('Todays Complete Meeting')}}</h5>
                <p class="mb-0" id="completeMeeting"></p>
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
                @foreach($permissions as $permission)
                    @if($permission->route_url == 'admin.meeting.save')
                        <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#addMeeting" class="btn btn-primary" id="addModalBtnMeeting" >
                            {{ __('Add Meeting')}}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="permissionTable">
                <thead>
                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center">{{ __('Id')}}</th>
                        <th class="text-center">{{ __('Name')}}</th>
                        <th class="text-center">{{ __('Url Name')}}</th>
                        <th class="text-center">{{ __('Module Name')}}</th>
                        <th class="text-center">{{ __('Action')}}</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    
                </tbody>
            </table>
        </div>
    </div>

    
    <!-- Create Meeting start -->
        <div class="modal fade modal-md" id="addMeeting" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addPermissionTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Create Meeting')}}</h2>
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
                        <form id="meetingForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 " id="locationDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Location')}}</label>
                                                        <input type="text" name="location" id="location" class="form-control" maxlength="100" placeholder="Enter location" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="clientNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Client Name')}}</label>
                                                        <input type="text" name="client_name" id="clientName" class="form-control" oninput="stringValidation(event)" maxlength="100" placeholder="Enter client name" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="meetingDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Meeting Time')}}</label>
                                                        <input name="meeting_time" id="meetingTime" type="text" class="form-control" maxlength="100" oninput="acceptOnlyNumber(event)" placeholder="Enter meeting time (In minutes)">
                                                        <span>Avalaible Time (9:00 AM - 6:00 PM)</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="meetingDateDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Meeting Date')}}</label>
                                                        <input name="meeting_date" id="meetingDate" type="text" class="form-control" onclick="openFlatpickr(event)" placeholder="Enter meeting date">
                                                    </div>
                                                </div>

                                                <input name="latitude" id="latitude" type="hidden" class="form-control" >
                                                <input name="longitude" id="longitude" type="hidden" class="form-control">
                                                <input name="ip" id="ip" type="hidden" class="form-control">
                                                <input name="city" id="city" type="hidden" class="form-control">
                                                <input name="distance_in_km" id="distance_in_km" type="hidden" class="form-control">
                                                <input name="duration_in_minutes" id="duration_in_minutes" type="hidden" class="form-control">
                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary meetingBtn" id="saveMeetingBtn" onclick="saveMeeting(event)">{{ __('Create Meeting')}}</button>
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

    <!-- Update Permission start -->
        <div class="modal fade modal-md" id="editPermission" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="editPermissionTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h2 class="fw-bold">{{ __('Update Permission')}}</h2>
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
                        <form id="updatePermissionForm" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="hiddenPremissionId">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 " id="updateModuleNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Route Name')}}</label>
                                                        <select name="module_id" class="form-select" id="updateModuleName" data-control="select2" data-placeholder="Select module name">
                                                            <option></option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4 " id="updatePermissionNameDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Permission')}}</label>
                                                        <input type="text" name="permission" id="updatePermissionName" class="form-control" maxlength="100" placeholder="Enter role name" >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-4 " id="updateAppUrlDiv">
                                                    <div class="form-group">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('Set URL')}}</label>
                                                        <input type="text" name="app_url" id="updateAppUrl" class="form-control" maxlength="100" placeholder="Enter url name related permission" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer modal-footer">
                                            <button type="submit" class="btn btn-primary permissionBtn" id="updatePermissionBtn" onclick="updatePermission(event)">{{ __('Update Permission')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Update Permission end -->

    <!-- <div class="modal fade modal-lg" id="addDocument" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addPermissionTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <h2 class="fw-bold">{{ __('Create document')}}</h2>
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
                    <form id="documentForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-4 " id="fileTypeIdDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('File Type')}}</label>
                                                    <select name="file_type[]" class="form-control">
                                                        <option value="">{{ __('Select')}}</option>
                                                        <option value="marksheet">{{ __('Marksheet')}}</option>
                                                        <option value="aadhar">{{ __('Aadhar')}}</option>
                                                        <option value="pan_card">{{ __('Pan Card')}}</option>
                                                        <option value="bank_details">{{ __('Bank Details')}}</option>
                                                        <option value="address_proof">{{ __('Address Proof')}}</option>
                                                        <option value="licence">{{ __('Licence')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4 " id="documentIdDiv">
                                                <div class="form-group">
                                                    <label class="required fs-6 fw-semibold mb-2">{{ __('Document')}}</label>
                                                    <input type="file" name="document[]" id="documentId" class="form-control" maxlength="100" placeholder="Select file" >
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-4">
                                                <button type="button" class="btn btn-danger removeRow">{{ __('Remove')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="card-footer modal-footer mt-4">
                                        <button type="button" class="btn btn-secondary" onclick="addRow()">{{ __('Add More')}}</button>
                                        <button type="submit" class="btn btn-primary" onclick="saveAllDocuments(event)">{{ __('Final Submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

@endsection

@section('scripts')

<script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script src="{{ asset('assets/js/custom/roles/role.js') }}"></script>
<script src="{{ asset('assets/js/google_meeting/ajaxgoogle.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY5p5e5PtJuJLl_nRpjefL0S094jdhEP8&libraries=places"></script>

<script>
    $(document).ready(function() {
        let autocomplete;
        let to = 'location';

        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById(to),
            { types: ['geocode'] }
        );

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            let nearPlace = autocomplete.getPlace();
            JQuery('#latitude').val(nearPlace.geometry.location.lat());
            JQuery('#longitude').val(nearPlace.geometry.location.lng());
            $.getJSON("https://api.ipify.org/?format=json", function(data) {
                let ip = data.ip
                JQuery('#ip').val(ip);
                getCity(ip);
            })
        })

        function getCity(ip) {
            let req = new XMLHttpRequest();
            req.open("GET", "http://ip-api.com/json/" + ip, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    let response = JSON.parse(req.responseText);
                    let city = response.city;
                    let state = response.regionName;
                    let country = response.country;
                    let pincode = response.zip;
                    let lat = response.lat;
                    let lon = response.lon;
                    let location = city + ', ' + state + ', ' + country;
                    $('#location').val(location);
                    $('#city').val(city);
                    calculateDistance(lat, lon);
                }
            }
        }


        function calculateDistance(lat, lon) {
            // let origin = new google.maps.LatLng(28.6139, 77.2090); // New Delhi coordinates
            // let destination = new google.maps.LatLng(lat, lon);
            let origin = $('#city').val(city); // New Delhi coordinates
            let destination = $('#location').val(location);
            let service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins: [origin],
                    destinations: [destination],
                    // travelMode: 'DRIVING',
                    travelMode: google.maps.TravelMode.DRIVING, // Use DRIVING for car distance
                    unitSystem: google.maps.UnitSystem.METRIC, // Use METRIC for kilometers me distance ko nikal sakte hai
                    avoidHighways: false,
                    avoidTolls: false,
                },
                function(response, status) {
                    if (status === google.maps.DistanceMatrixStatus.OK) {
                        let results = response.rows[0].elements;
                        if (results[0].status === google.maps.DistanceMatrixStatus.OK) {
                            let distanceInKm = results[0].distance.value / 1000; // Convert meters to kilometers
                            let durationInMinutes = results[0].duration.value / 60; // Convert seconds to minutes
                            $('#distance_in_km').val(distanceInKm.toFixed(2));
                            $('#duration_in_minutes').val(durationInMinutes.toFixed(2));
                            console.log('Distance in km:', distanceInKm.toFixed(2));
                            console.log('Duration in minutes:', durationInMinutes.toFixed(2));
                        } else {
                            // google.maps.DistanceMatrixStatus.ZERO_RESULTS
                            console.error('Not have proper road :', results[0].status);
                        }
                    } else {
                        console.error('Error with Distance Matrix service:', status);
                    }
                }
            );
        }
    
    })
</script>

@endsection