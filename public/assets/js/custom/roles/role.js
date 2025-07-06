"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// Role Js Start --
function saveRole(e) {
    e.preventDefault();
    $('.roleBtn').prop('disabled', true);
    let roleName = $("#roleName").val();
    if (roleName === '') {
        Swal.fire({
            title: 'Missing role name',
            text: "Please enter a role name.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    submitRole(roleName)
}

function submitRole(roleName) {
    let role = roleName;
    let url = 'admin/role/save';
    $.ajax({
        url: url,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            role: role
        },
        success: function(res) {
            if(res.success) {
                $('.roleBtn').prop('disabled', true);
                $('#addRole').modal('hide');
                $('#roleName').val('');
                Swal.fire({
                    title: 'Role created',
                    text: "Successfully created a new role.",
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        },
        error: function(xhr) {
            if(xhr.responseJSON) {
                Swal.fire({
                    title: 'Already exists ',
                    text: xhr.responseJSON.message.role,
                    icon: 'error',
                    timer: 5000,
                    showConfirmButton: false
                });
                console.log(xhr.responseJSON.message.role);
            }
        }

    });
}
// Role Js End --



// Permission Js Start --
function savePermission(e) {
    e.preventDefault();
    $('.permissionBtn').prop('disabled', true);
    let permissionName = $("#permissionName").val();
    if (permissionName === '') {
        Swal.fire({
            title: 'Missing permission name',
            text: "Please enter a permission name.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }

    submitPermission(permissionName);
}

function submitPermission(permissionName) {
    let permissions = permissionName;
    let url = '/admin/permission/save';
    $.ajax({
        url: url,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            permission: permissionName
        },
        success: function(res) {
            if(res.success) {
                $('.permissionBtn').prop('disabled', false);
                $('#addPermission').modal('hide');
                $('#permissionName').val('');
                Swal.fire({
                    title: 'Permission created',
                    text: "Successfully created a new permission.",
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        },
        error: function(xhr) {
            if(xhr.responseJSON) {
                Swal.fire({
                    title: 'Already exists ',
                    text: xhr.responseJSON.message.permission,
                    icon: 'error',
                    timer: 5000,
                    showConfirmButton: false
                });
                console.log(xhr.responseJSON.message.permission);
            }
        }
    })

}



// Permission Js End --

