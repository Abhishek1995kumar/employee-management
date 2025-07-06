"use strict";

const sleep = (ms) => new Promise((res) => setTimeout(res, ms));
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
var KTModalAdd = function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            r = document.querySelector("#kt_sign_in_form"),
                t = r.querySelector("#kt_sign_in_submit"),
                n = FormValidation.formValidation(r, {
                    fields: {
                        login: {
                            validators: {
                                notEmpty: {
                                    message: "Login Id is required"
                                },
                                regexp: {
                                    regexp: /(^[^\s@]+@[^\s@]+\.[^\s@]+$)|(^[0-9]{10}$)/,
                                    message: "Please enter a valid login id"
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Password is required"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                }),
                t.addEventListener("click", function (n) {
                    n.preventDefault();
                    n.stopPropagation();
                    var loginn = document.getElementById("Login").value;
                    var passwordd = document.getElementById("Password").value;
                    $.ajax({
                        type: "POST",
                        url: "/auth",
                        data: {
                            login: loginn,
                            password: passwordd
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.success == 200) {
                                swal.fire({
                                    text: "Your credentials matches our record",
                                    icon: "success",
                                    showConfirmButton: false
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                                const work = async () => {
                                    await sleep(1000);
                                    swal.close();
                                    if(response.data.otp_verified == 0) {
                                        $('#otpModal').modal('show');
                                        $('#loggedInUserId').val(response.data.user_id);
                                    }
                                };
                                work();
                            } else if (response.success == 201) {
                                swal.fire({
                                    text: "Password is incorrect",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                            } else if (response.success == 202) {
                                swal.fire({
                                    text: "User not found in our records",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                            } else if (response.success == 204) {
                                swal.fire({
                                    text: "You have been deactivated from logging into the panel. Kindly contact the admin to reinstate your privileges.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                            } else if (response.success == 205) {
                                swal.fire({
                                    text: "You have been banned from accessing the Admin Panel.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    KTUtil.scrollTop();
                                });
                            } else if (response.success == 206) {
                                swal.fire({
                                    text: "You are not authorised to log into Admin Panel.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    KTUtil.scrollTop();
                                });
                            }else {
                                swal.fire({
                                    text: "User already logged in.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                            }
                        }
                    });
                });
        }
    }
}();
KTUtil.onDOMContentLoaded(function () {
    KTModalAdd.init();
});

function verifyOtp() {
    let otp = document.getElementById('otpCode').value;
    let userId = document.getElementById('loggedInUserId').value;
    let verifyOtpUrl = window.verifyOtpUrl || '/admin/verify-otp'; 
    $.ajax({
        url: verifyOtpUrl,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            otp: otp,
            user_id: userId
        },
        success: function(res) {
            if(res.success) {
                Swal.fire({
                    text: "OTP Verified Successfully!",
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/admin/dashboard";
                });
            } else {
                Swal.fire({
                    text: res.message,
                    icon: "error",
                    showConfirmButton: true
                });
            }
        }
    });
}

