@extends('layouts.auth')
@section('title', 'Employee Management System')
@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('assets/css/comman.css') }}">
@endsection
@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-5">
	<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-5">
		<div class="w-md-500px">
			<form class="form" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('admin.auth') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="text-center mb-11">
                    <img alt="Logo" src="{{ asset('/assets/media/logos/user.png')}} " class="mb-5" style="height: 100px;" />
					<div class="fs-1 fw-bolder text-dark mb-3">{{ __('Welcome to Employee Management Panel')}}</div>
				</div>

				<div class="" id="loginDiv">
					<div class="fv-row mb-3">
						<input type="text" placeholder="Login Id" id="Login" name="login" autocomplete="off" class="form-control bg-transparent" />
					</div>
					<div class="fv-row mb-3">
						<input type="password" placeholder="Password" id="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
					</div>
				</div>

				<div class="d-flex justify-content-between">
					<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
						<span class="indicator-label">{{ __('Sign In')}}</span>
						<span class="indicator-progress">{{ __('Please wait...')}}
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
					<a class="btn btn-info " id="forget-password" href="{{ url('forget/password') }}">{{ __('Forget Password?')}}</a>
				</div>
			</form>
			<?php
				$date = date('Y');
			?>
			<br><br>
			<div>
				<p class="text-center mt-5 mb-0">{{ __('Copyright')}} &copy; {{ $date }} <a href="https://www.technostacks.com/" target="_blank" class="text-primary text-hover-primary">{{ __('Rukmani Solutions')}}</a>. {{ __('All rights reserved.')}}</p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-md" id="otpModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="otpModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<input type="hidden" name="id" value="">
			<div class="modal-header">
				<h2 class="fw-bold">{{ __('OTP Section')}}</h2>
				<!-- <div data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
					<span class="svg-icon svg-icon-1">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
						</svg>
					</span>
				</div> -->
			</div>
			<div class="modal-body">
				<form id="roleForm" action="{{ route('admin.verify-otp') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 mb-4 " id="roleNameDiv">
											<div class="form-group">
												<label class="required fs-6 fw-semibold mb-2">{{ __('OTP Verification')}}</label>
												<input type="text" name="otp" id="otpCode" class="form-control" maxlength="6" placeholder="Enter OTP" oninput="acceptOnlyNumber(this)" />
												<input type="hidden" id="loggedInUserId" value="">
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer modal-footer">
									<button type="button" class="btn btn-primary" onclick="verifyOtp()">{{ __('Verify OTP')}}</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('footer')
    <script src="{{ asset('assets/js/custom/custom/comman.js') }}"></script>
	<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endsection
