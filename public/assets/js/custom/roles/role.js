"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// Role Js Start --
    // function fetchRoles() {
    //     $.ajax({
    //         url: 'admin/role',
    //         method: "GET",
    //         success: function(res) {
    //             let tbody = '';
    //             if(res) {
    //                 $.each(res, function(_, role) {
    //                     tbody += '<tr>';
    //                     tbody += '<td class="text-center">' + role.id + '</td>';
    //                     tbody += '<td class="text-center">' + role.name + '</td>';
    //                     tbody += '<td class="text-center">';
    //                     tbody += '<button class="btn btn-sm btn-primary editRole" data-id="'+role.id+'">Edit</button> ';
    //                     tbody += '<button class="btn btn-sm btn-danger deleteRole" data-id="'+role.id+'">Delete</button>';
    //                     tbody += '</td>';
    //                     tbody += '</tr>';
    //                 });
    //             } else {
    //                 tbody = '<tr><td colspan="3" class="text-center">No roles found.</td></tr>';
    //             }
    //             $('#kt_table tbody').html(tbody);
    //             $('#completeValue').text(res.total || res.length);
    //         }   
    //     });
    // }

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
            $('.roleBtn').prop('disabled', false);
            return false;
        }
        submitRole(roleName)
    }

    function submitRole(roleName) {
        let role = roleName;
        let url = 'admin/role/save';
        $('#addRole').modal('hide');
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
                    $('#roleName').val('');
                    Swal.fire({
                        title: 'Role created',
                        text: "Successfully created a new role.",
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        // fetchRoles();
                    }, 200);
                }
            },
            error: function(xhr) {
                $('.roleBtn').prop('disabled', false);
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
    // fetchRoles();

    // update role
    function editRole(button) {
        var roleId = button.getAttribute('data-id')
        var roleName = button.getAttribute('data-name')
        document.getElementById('roleId').value = roleId;
        document.getElementById('updateRoleName').value = roleName;
    }

    function editRoleBtn(e) {
        e.preventDefault();
        $('#updateRoleBtnId').prop('disabled', true);
        let id = $("#roleId").val();
        let roleName = $("#updateRoleName").val();
        if (roleName === '') {
            Swal.fire({
                title: 'Missing role name',
                text: "Please enter a role name.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $('#updateRoleBtnId').prop('disabled', false);
            return false;
        }
        // alert('abhishek mishra' + '\n' + roleName + '\n' + id);
        updateRole(id, roleName)
    }

    function updateRole(id, roleName) {
        let role = roleName;
        let url = 'admin/role/update';
        $('#editRole').modal('hide');
        // alert('abhishek mishra' + '\n' + role + '\n' + url);
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                role: role,
                id: id
            },
            success: function(res) {
                if(res.success) {
                    $('#updateRoleBtnId').prop('disabled', true);
                    $('#updateRoleName').val('');
                    Swal.fire({
                        title: 'Role created',
                        text: "Successfully update role.",
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        // fetchRoles();
                    }, 200);
                }
            },
            error: function(xhr) {
                $('#updateRoleBtnId').prop('disabled', false);
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

    function editPermission(button) {
        let permissionId = button.getAttribute('data-id');
        let permissionName = button.getAttribute('data-name');
        document.getElementById('hiddenPremissionId').value = permissionId;
        document.getElementById('updatePermissionName').value = permissionName;
    }

    function updatePermission(e) {
        e.preventDefault();
        $('#updatePermissionBtn').prop('disabled', true);
        let permissionId = $("#hiddenPremissionId").val();
        let permissionName = $("#updatePermissionName").val();
        if (permissionName === '') {
            Swal.fire({
                title: 'Missing permission name',
                text: "Please enter a permission name.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $('#updatePermissionBtn').prop('disabled', false);
            return false;
        }
        updatePermissionAjax(permissionId, permissionName);
    }

    function updatePermissionAjax(permissionId, permissionName) {
        let permissions = permissionName;
        let id = permissionId;
        let url = '/admin/permission/update';
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                permission: permissions,
                id: id
            },
            success: function(res) {
                if(res.success) {
                    $('#updatePermissionBtn').prop('disabled', false);
                    $('#editPermission').modal('hide');
                    $('#updatePermissionName').val('');
                    Swal.fire({
                        title: 'Permission updated',
                        text: "Successfully updated the permission.",
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                $('#updatePermissionBtn').prop('disabled', false);
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
        });
    }

// Permission Js End --



// Role permission mapping js start --
    function saveRolePermissionMapping(event) {
        event.preventDefault();
        let permissionIds = [];
        let roleId = document.getElementById('roleId').value;

        document.querySelectorAll('input[name="permission_id[]"]:checked').forEach(function(checkbox) {
            permissionIds.push(checkbox.value);
        });
        if (roleId === '') {
            Swal.fire({
                title: 'Missing role',
                text: "Please select a role.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }
        if (permissionIds.length === 0) {
            Swal.fire({
                title: 'Missing permission',
                text: "Please select at least one permission.",
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        $('#createRolePermissionMappingBtn').prop('disabled', true);

        saveRolePermission(roleId, permissionIds);
    }

    function saveRolePermission(roleId, permissionIds) {
        alert('abhishek kumar mishra');
        let url = 'admin/role-permission-mapping/save';
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                role_id: roleId,
                permission_id: permissionIds
            },
            success: function(res) {
                $('#createRolePermissionMappingBtn').prop('disabled', false);
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Role Permission Mapping',
                        text: "Successfully assigned permissions to the role.",
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reset form
                    document.getElementById('roleId').value = '';
                    document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    $('#addRolePermissionMapping').modal('hide');
                }
            },
            error: function(xhr) {
                $('#createRolePermissionMappingBtn').prop('disabled', false);
                if (xhr.responseJSON) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false
                    });
                    console.log(xhr.responseJSON.message);
                }
            }
        });
    }

// Role permission mapping js end --









// Document Js Start --
    function addRow() {
        let html = `
        <div class="row documentRow">
            <div class="col-md-5 mb-3">
                <select name="file_type[]" class="form-control">
                    <option value="">Select</option>
                    <option value="marksheet">Marksheet</option>
                    <option value="aadhar">Aadhar</option>
                    <option value="pan_card">Pan Card</option>
                    <option value="bank_details">Bank Details</option>
                    <option value="address_proof">Address Proof</option>
                    <option value="licence">Licence</option>
                </select>
            </div>
            <div class="col-md-5 mb-3">
                <input type="file" name="document[]" class="form-control">
            </div>
            <div class="col-md-2 mt-2">
                <button type="button" class="btn btn-danger removeRow">Remove</button>
            </div>
        </div>
        `;
        $('#documentContainer').append(html);
    }

    $(document).on('click', '.removeRow', function () {
        $(this).closest('.documentRow').remove();
    });

    function saveAllDocuments(event) {
        event.preventDefault();

        let formData = new FormData(document.getElementById("documentForm"));

        $.ajax({
            url: '{{ route("your.route.name") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire('Success', response.message, 'success');
            },
            error: function (xhr) {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        });
    }
// Document Js End --

