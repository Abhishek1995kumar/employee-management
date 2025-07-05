@extends('layouts.auth')
@section('title', 'Login')
@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-5">
	<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-5">
		<div class="w-md-500px">
			<form class="form" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('admin.auth') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="text-center mb-11">
                    <img alt="Logo" src="{{ asset('/assets/media/logos/user.png')}} " class="mb-5" style="height: 100px;" />
					<div class="fs-1 fw-bolder text-dark mb-3">Welcome to Employee Management Panel</div>
				</div>

				<div class="" id="loginDiv">
					<div class="fv-row mb-3">
						<input type="text" placeholder="Login Id" id="Login" name="login" autocomplete="off" class="form-control bg-transparent" />
					</div>
					<div class="fv-row mb-3">
						<input type="password" placeholder="Password" id="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
					</div>
				</div>

				<div class="d-grid mb-10">
					<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
						<span class="indicator-label">Sign In</span>
						<span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endsection
