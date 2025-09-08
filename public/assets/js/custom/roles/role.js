"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
// sweetalert
function validationAlert(title, text, icon, timer, confirmButtonText, showConfirmButton) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        timer: timer, // Only set timer if confirm button is hidden
        confirmButtonText: confirmButtonText,
        showConfirmButton: showConfirmButton === undefined ? true : showConfirmButton,
    });
}

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
            validationAlert('Missing role name', 'Please enter a role name.', 'error', 2000, 'OK');
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
                    validationAlert('Role created', 'Successfully created a new role.', 'success', 2000, 'OK');
                    setTimeout(function() {
                        // fetchRoles();
                    }, 200);
                }
            },
            error: function(xhr) {
                $('.roleBtn').prop('disabled', false);
                if(xhr.responseJSON) {
                    validationAlert('Already exists ', xhr.responseJSON.message.role, 'error', 5000, "OOP's");
                    console.log(xhr.responseJSON.message.role);
                }
            }

        });
    }
    
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
            validationAlert('Missing role name', 'Please enter a role name.', 'error', 2000, 'OK');
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
                    validationAlert('Role updated', 'Successfully updated the role.', 'success', 2000, false);
                    setTimeout(function() {
                        // fetchRoles();
                    }, 200);
                }
            },
            error: function(xhr) {
                $('#updateRoleBtnId').prop('disabled', false);
                if(xhr.responseJSON) {
                    validationAlert('Already exists ', xhr.responseJSON.message.role, 'error', 5000, false);
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
        let routePattern = document.getElementById('routePattern').value;
        if (permissionName === '') {
            validationAlert('Missing permission name', 'Please enter a permission name.', 'error', 2000, 'OK');
            $('.permissionBtn').prop('disabled', false);
            return false;
        }
        if (routePattern === '') {
            validationAlert('Missing route name', 'Please enter a route name.', 'error', 2000, 'OK');
            $('.permissionBtn').prop('disabled', false);
            return false;
        }
        submitPermission(permissionName, routePattern);
    }

    function submitPermission(permissionName, routePattern) {
        let permissions = permissionName;
        let routes = routePattern;
        let url = '/admin/permission/save';
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                permission: permissionName,
                route_pattern: routePattern
            },
            success: function(res) {
                if(res.success) {
                    $('.permissionBtn').prop('disabled', false);
                    $('#addPermission').modal('hide');
                    $('#permissionName').val('');
                    $('#routePattern').val('');
                    validationAlert('Permission created', 'Successfully created a new permission.', 'success', 2000, 'OK');
                    setTimeout(function() {
                        // fetchPermissions();
                    }, 200);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON) {
                    validationAlert('Already exists ', xhr.responseJSON.message.permission, 'error', 5000, 'OK');
                    console.log(xhr.responseJSON.message.permission);
                }
            }
        })

    }

    function editPermission(button) {
        let permissionId = button.getAttribute('data-id');
        let permissionName = button.getAttribute('data-name');
        let routePattern = button.getAttribute('data-route-pattern');
        document.getElementById('hiddenPremissionId').value = permissionId;
        document.getElementById('updatePermissionName').value = permissionName;
        document.getElementById('updateRoutePattern').value = routePattern;
    }

    function updatePermission(e) {
        e.preventDefault();
        $('#updatePermissionBtn').prop('disabled', true);
        let permissionId = $("#hiddenPremissionId").val();
        let permissionName = $("#updatePermissionName").val();
        let routePattern = $("#updateRoutePattern").val();
        if (permissionName === '') {
            validationAlert('Missing permission name', 'Please enter a permission name.', 'error', 2000, 'OK');
            $('#updatePermissionBtn').prop('disabled', false);
            return false;
        }
        if (routePattern === '') {
            validationAlert('Missing route name', 'Please enter a route name.', 'error', 2000, 'OK');
            $('#updatePermissionBtn').prop('disabled', false);
            return false;
        }
        updatePermissionAjax(permissionId, permissionName, routePattern);
    }

    function updatePermissionAjax(permissionId, permissionName, routePattern) {
        let permissions = permissionName;
        let routes = routePattern;
        let id = permissionId;
        let url = '/admin/permission/update';
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                permission: permissions,
                route_pattern: routes,
                id: id
            },
            success: function(res) {
                if(res.success) {
                    $('#updatePermissionBtn').prop('disabled', false);
                    $('#editPermission').modal('hide');
                    $('#updatePermissionName').val('');
                    validationAlert('Permission updated', 'Successfully updated the permission.', 'success', 2000, 'OK');
                }
            },
            error: function(xhr) {
                $('#updatePermissionBtn').prop('disabled', false);
                if(xhr.responseJSON) {
                    validationAlert('Already exists', xhr.responseJSON.message.permission, 'error', 2000, 'OK');
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
        $('#createRolePermissionMappingBtn').prop('disabled', true);
        document.querySelectorAll('input[name="permission_id[]"]:checked').forEach(function(checkbox) {
            permissionIds.push(checkbox.value);
        });
        if (roleId === '') {
            validationAlert('Missing role', 'Please select a role.', 'error', 2000, 'OK');
            $('#createRolePermissionMappingBtn').prop('disabled', false);
            return false;
        }
        if (permissionIds.length === 0) {
            validationAlert('Missing permission', 'Please select at least one permission.', 'error', 2000, 'OK');
            $('#createRolePermissionMappingBtn').prop('disabled', false);
            return false;
        }
        saveRolePermission(roleId, permissionIds);
    }

    function saveRolePermission(roleId, permissionIds) {
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
                    validationAlert('Role Permission Mapping', 'Successfully assigned permissions to the role.', 'success', 2000, 'OK');
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
                if (xhr.responseText) {
                    validationAlert('Error', xhr.responseJSON.message, 'error', 5000, "OOP's");
                    console.log(xhr.responseJSON.message);
                }
            }
        });
    }

// Role permission mapping js end --





// Route permission mapping js start --
    $(document).ready(function() {
        $('#routeId').select2({
            placeholder: "Select Routes",
            closeOnSelect: false,
            allowClear: true
        });

        $('#routeUpdateId').select2({
            placeholder: "Select Routes",
            closeOnSelect: false,
            allowClear: true
        });
    });

    function saveRoutePermissionMapping(event) {
        event.preventDefault();
        $('#createRoutePermissionMappingBtn').prop('disabled', true);
        let permissionId = document.getElementById('permissionId').value;
        let routeIds = $('#routeId').val() || [];

        if (permissionId === '') {
            validationAlert('Missing permission', 'Please select a permission.', 'error', 2000, 'OK');
            $('#createRoutePermissionMappingBtn').prop('disabled', false);
            return false;
        }
        if (routeIds.length === 0) {
            validationAlert('Missing route', 'Please select at least one route.', 'error', 2000, 'OK');
            $('#createRoutePermissionMappingBtn').prop('disabled', false);
            return false;
        }

        saveRoutePermission(permissionId, routeIds);
    }

    function saveRoutePermission(permissionId, routeIds) {
        $('#addRolePermissionMapping').modal('hide');
        let url = 'admin/route-permission-mapping/save';
        $.ajax({
            url: url,
            method: "POST",
             data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                permission_id: permissionId,
                route_name: routeIds
            },
            success: function(res) {
                if (res.status === 'success') {
                    $('#createRoutePermissionMappingBtn').prop('disabled', false);
                    validationAlert('Route Permission Mapping', 'Successfully assigned routes to the permission.', 'success', 2000, "OK");
                    $('#routeId').val('').trigger('change');
                    document.getElementById('permissionId').value = '';
                    document.querySelectorAll('input[name="route_name[]"]').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    $('#addRoutePermissionMapping').modal('hide');
                }
            },
            error: function(xhr) {
                $('#createRolePermissionMappingBtn').prop('disabled', false);
                if (xhr.responseText) {
                    validationAlert('Error', xhr.responseJSON.message, 'error', 5000, "OOP's");
                }
            }
        });
    }

    function editRoutePermissionMapping(button) {
        var id = button.getAttribute('data-id');
        var permissionId = button.getAttribute('data-permission_id');
        var routeNames = JSON.parse(button.getAttribute('data-route_name')) || [];
        // document.getElementById('hiddenRoutePermissionId').value = id;
        // document.getElementById('permissionUpdateId').value = permissionId;
        // $('#routeUpdateId').val(routeNames).trigger('change');

        // Hidden input me id set karo
        document.querySelector("#editRoutePermission input[name='id']").value = id;

        // Permission select set karo
        $("#permissionUpdateId").val(permissionId).trigger("change");

        // Route select set karo (multiple)
        $("#routeUpdateId").val(routeNames).trigger("change");
    }
// Route permission mapping js end --








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
                validationAlert('Success', 'Documents uploaded successfully', 'success', 2000, false);
            },
            error: function (xhr) {
                validationAlert('Error', 'Failed to upload documents', 'error', 5000, false);
            }
        });
    }
// Document Js End --

