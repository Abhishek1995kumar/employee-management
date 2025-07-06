@extends('layouts.admin')

@section('title','Dashboard')

@section('header')

@endsection

@section('breadcrumb')
<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Dashboard</h1>

@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <img width="90px" height="90px" src="{{ asset('assets/media/logos/machine.png') }}">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">Machines</span>
                <h1 id="totalRequest">6464</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <img width="90px" height="90px" src="{{ asset('assets/media/logos/bottle.png') }}">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">Bottles (Weight)</span>
                <h1 id="totalRequest">9653</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <img width="90px" height="90px" src="{{ asset('assets/media/logos/user.png') }}">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">Transactions</span>
                <h1 id="totalRequest">7557</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-primary text-center pt-5 border border-primary d-flex flex-row">
            <img width="90px" height="90px" src="{{ asset('assets/media/logos/qr_code.png') }}">
            <div class="d-flex flex-column mx-5">
                <span class="alert-heading">Scan Devices</span>
                <h1 id="totalRequest">853</h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-10">
    <!-- ABC CENTER SUMMARY -->
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-1 mb-1">Last 12 months (Bottles)</span>
                        <span class="text-muted mt-1 fw-semibold fs-7"> Bottles (Weight) {{ __('15137507/272475 Kg')}}</span>
                    </h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- ABC CENTER SUMMARY -->

    <!-- Application Status Dashbaord -->
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-1 mb-1">Last 12 months (No of Machines Installed)</span>
                        <span class="text-muted mt-1 fw-semibold fs-7"> Machines - {{ __('538')}} </span>
                    </h3>
                    <div class="card-toolbar">

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
    <!-- Application Status Dashbaord -->

    <!-- Sterilized Animal Gender Distribution Graph -->
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 d-flex flex-column justify-content-between">
                    <span class="card-label fs-4 mb-1">
                        <span>Most Used Top 10 machines</span>
                        <span class="mx-5">{{ __('Top 10 List')}}</span>
                    </span>
                    <span class="card-label fs-4 mb-1 ">
                        <span>Total Customer </span>
                        <span class="mx-5">{{ __('5398')}} </span>
                    </span>
                    <span class="card-label fs-4 mb-1 ">
                        <span>Mobile App</span>
                        <span class="mx-5">{{ __('64')}}</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-1 mb-1">Map of the distribution of machines around the India</span>
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
    <!-- Sterilized Animal Gender Distribution Graph -->
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection