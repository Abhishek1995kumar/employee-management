@extends('layouts.auth')
@section('title', 'Candidate Login')
@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('assets/css/comman.css') }}">
@endsection
@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-5">
	<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-5">
		<div class="w-md-500px">
			<form class="form" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('candidate.save') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="text-center mb-11">
                    <img alt="Logo" src="{{ asset('/assets/media/logos/user.png')}} " class="mb-5" style="height: 100px;" />
					<div class="fs-1 fw-bolder text-dark mb-3">{{ __('Welcome to Rukmani Solution Pvt. Ltd.')}}</div>
					<div class="text-gray-500 fw-semibold fs-6">
                        {{ __('Please login or create an account below') }}
                    </div>
				</div>

				<div class="" id="loginDiv">
					<div class="fv-row mb-3">
						<input type="text" placeholder="Login Id" id="Login" name="phone" oninput="acceptOnlyNumber(event)" autocomplete="off" class="form-control bg-transparent" />
					</div>
					<div class="fv-row mb-3">
						<input type="password" placeholder="Password" id="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
					</div>
				</div>
				<div id="createDiv" style="display: none;">
                    <div class="fv-row mb-3">
                        <label class="form-label fs-6 fw-bold text-dark">Full Name</label>
                        <input id="name" name="name" type="text" placeholder="Enter Your Name" class="form-control bg-transparent" autocomplete="off" /> 
                    </div>
                </div>
				<div class="d-flex justify-content-between">
					<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
						<span class="indicator-label">{{ __('Sign In')}}</span>
						<span class="indicator-progress">{{ __('Please wait...')}}
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
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

@endsection
@section('footer')
    <script src="{{ asset('assets/js/custom/comman.js') }}"></script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById('kt_sign_in_form');
		const createDiv = document.getElementById('createDiv');
		form.addEventListener('submit', async function (e) {
			e.preventDefault();
			let formData = new FormData(form);

			const btn = document.getElementById('kt_sign_in_submit');
			btn.disabled = true;
			btn.querySelector('.indicator-progress').style.display = 'inline-block';
			btn.querySelector('.indicator-label').style.display = 'none';

			try {
				const response = await fetch("{{ route('candidate.save') }}", {
					method: "POST",
					headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
					body: formData
				});

				const result = await response.json();

				// ✅ Login success
				if (result.success && result.code === 1) {
					Swal.fire({
						title: 'Success',
						text: 'Login successful!',
						icon: 'success',
						timer: 1500,
						showConfirmButton: false
					}).then(() => {
						window.location.href = "{{ url('candidate/dashboard') }}";
					});
				} 
				// ✅ Account created
				else if (result.success && result.code === 0) {
					Swal.fire('Account Created', 'Your account has been created successfully.', 'success');
					form.reset();
					createDiv.style.display = 'none';
				} 
				// ✅ Ask for name
				else if (!result.success && result.code === 5) {
					Swal.fire('Create Account', 'Please enter your name to create a new account.', 'info');
					createDiv.style.display = 'block';
				} 
				// ❌ Other errors
				else {
					Swal.fire('Error', result.message, 'error');
					createDiv.style.display = 'none';
				}
			} catch (err) {
				Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
			} finally {
				btn.disabled = false;
				btn.querySelector('.indicator-progress').style.display = 'none';
				btn.querySelector('.indicator-label').style.display = 'inline-block';
			}
		});
	});
</script>

@endsection
