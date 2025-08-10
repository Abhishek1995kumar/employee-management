"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// Common function start 
const acceptOnlyNumber = (event) => {
    const input = event.target;
    console.log(`Input field: ${input.placeholder || input.name}`, `Value: ${input.value}`);
    const value = input.value;
    const regex = /^[0-9]*$/;
    if (!regex.test(value)) {
        input.value = value.replace(/[^0-9]/g, '');
        Swal.fire({
            title: 'Invalid Input',
            text: "Please enter a valid " + (input.placeholder || input.name) + "\nonly numbers are allowed.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
};

function handleTypeCheckbox(type) {
    let fixedCheckbox = document.getElementById('select_fixed_type');
    let percentageCheckbox = document.getElementById('select_percentage_type');
    if (type === 'fixed_amount_div') {
        if (fixedCheckbox.checked) {
            percentageCheckbox.checked = false;
            ifcheckThanShowDiv(fixedCheckbox, 'fixed_amount_div');
            ifcheckThanShowDiv(percentageCheckbox, 'percentage_amount_div');
        }
    } else if (type === 'percentage_amount_div') {
        if (percentageCheckbox.checked) {
            fixedCheckbox.checked = false;
            ifcheckThanShowDiv(percentageCheckbox, 'percentage_amount_div');
            ifcheckThanShowDiv(fixedCheckbox, 'fixed_amount_div');
        }
    }

    // Handle fixed time checkboxes start --
        let yesFixed = [], noFixed = [];
        for (let i = 1; i <= 8; i++) {
            yesFixed.push(document.getElementById('fixed_time_yes_' + i));
            noFixed.push(document.getElementById('fixed_time_no_' + i));
        }
        // YES case
        if (type.startsWith('fixed_time_div')) {
            let index = type.split('_').pop();
            if (yesFixed[index - 1].checked) {
                noFixed[index - 1].checked = false;
                document.getElementById('fixed_time_div_' + index).style.display = 'block';
            } else {
                document.getElementById('fixed_time_div_' + index).style.display = 'none';
            }
        }
        // NO case
        if (type.startsWith('no_fixed_time_div')) {
            for (let i = 1; i <= 8; i++) {
                yesFixed[i - 1].checked = false;
                document.getElementById('fixed_time_div_' + i).style.display = 'none';
            }
        }
    // Handle fixed time checkboxes end --


    // Handle late applicable checkboxes start --
        let yesLate = document.getElementById('yes_late_applicable');
        let noLate = document.getElementById('no_late_applicable');
        if (type === 'yes_late_woking_applicable_div') {
            noLate.checked = false;
            ifcheckThanShowDiv(yesLate, 'yes_late_woking_applicable_div');
            ifcheckThanShowDiv(noLate, 'no_late_woking_applicable_div');

        } else if (type === 'no_late_woking_applicable_div') {
            yesLate.checked = false;
            ifcheckThanShowDiv(noLate, 'no_late_woking_applicable_div');
            ifcheckThanShowDiv(yesLate, 'yes_late_woking_applicable_div');
        }
    // Handle late applicable checkboxes end --
    

    // Handle leave applicable checkboxes start --
        let yesLeave = document.getElementById('yes_accrued_period');
        let noLeave = document.getElementById('no_accrued_period');
        if (type === 'yes_accrued_period_div') {
            noLeave.checked = false;
            ifcheckThanShowDiv(yesLeave, 'yes_accrued_period_div');
            ifcheckThanShowDiv(noLeave, 'no_accrued_period_div');

        } else if (type === 'no_accrued_period_div') {
            yesLeave.checked = false;
            ifcheckThanShowDiv(noLeave, 'no_accrued_period_div');
            ifcheckThanShowDiv(yesLeave, 'yes_accrued_period_div');
        }
    // Handle leave applicable checkboxes end --

    // Handle Leaves Carry Forward checkboxes start --
        for (let i = 1; i <= 8; i++) {
            if (type === 'yes_carry_forward_' + i) {
                alert('yes_carry_forward_' + i);
                document.getElementById('no_carry_forward_' + i).checked = false;
            }
            if (type === 'no_carry_forward_' + i) {
                document.getElementById('yes_carry_forward_' + i).checked = false;
            }
        }
    // Handle Leaves Carry Forward checkboxes end --
}


const ifcheckThanShowDiv = (checkboxElement, divId) => {
    let targetDiv = document.getElementById(divId);
    console.log(`Checkbox: ${checkboxElement.name}`);
    if (checkboxElement.checked) {
        targetDiv.style.display = 'block';
    } else {
        targetDiv.style.display = 'none';
    }
};

const openFlatpickr = (event) => {
    const input = event.target;
    if (input.type !== 'text') {
        console.warn(`Input field with ID ${input.id} is not a text date input.`);
        return;
    }
    if (!input._flatpickr) {
        input._flatpickr = flatpickr(input, {
            dateFormat: 'Y-m-d',
            allowInput: true,
            onChange: function (selectedDates, dateStr) {
                input.value = dateStr;
            }
        });
    }
    input._flatpickr.open();
};

const stringValidation = (event) => {
    const input = event.target;
    console.log(`Input field: ${input.placeholder || input.name}`, `Value: ${input.value}`);
    const value = input.value;
    const regex = /^[a-zA-Z][a-zA-Z0-9\s.,-]*$/;
    if (!regex.test(value)) {
        input.value = '';
        Swal.fire({
            title: 'Invalid Input',
            text: "Please enter a valid " + (input.placeholder || input.name) + "\nonly alphanumeric characters, spaces, commas, periods, and hyphens are allowed.",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    } else {
        console.log(`Valid input for ${input.placeholder || input.name}: ${input.value}`);
    }
};   

// Common function end  

// Bank Details Management
function saveUserForm(event) {
    event.preventDefault();
    let form = {
        role_id: document.getElementById('roleId'),
        username: document.getElementById('username'),
        name: document.getElementById('name'),
        phone: document.getElementById('phone'),
        email: document.getElementById('email'),
        date_of_birth: document.getElementById('date_of_birth'),
        address: document.getElementById('address'),
        gender: document.getElementById('gender')
    };

    let flag = false;
    for (var key in form) {
        let element = form[key];
        if (!element) {
            console.warn("Element not found for key:", key);
            continue;
        }
        if (element.tagName === 'SELECT') {
            if (!element.value || element.value === '' || element.value === '0') {
                Swal.fire({
                    title: 'Missing fields',
                    text: "Please select " + (element.getAttribute('data-label') || key) + ".",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                flag = true;
                return;
            }
        } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
            if (!element.value || element.value.trim() === '') {
                Swal.fire({
                    title: 'Missing ' + key,
                    text: "Please enter " + (element.placeholder || key) + ".",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                flag = true;
                return;
            }
        }
    }

    if (flag) {
        return;
    }
    submitFormData(form);
}

function submitFormData(form) {
    let role_id = form.role_id.value;
    let username = form.username.value;
    let name = form.name.value;
    let phone = form.phone.value;
    let email = form.email.value;
    let date_of_birth = form.date_of_birth.value;
    let address = form.address.value;
    
    $.ajax({
        url: 'admin/user/save',
        type: 'POST',
        data: {
            role_id: role_id,
            username: username,
            name: name,
            phone: phone,
            email: email,
            date_of_birth: date_of_birth,
            address: address,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    fetchUserData();
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while saving the user data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}


function fetchUserData() {
    $.ajax({
        url: 'admin/user/save',
        method: 'GET',
        success: function(res) {
            
        }
    })
}



let addMoreRows=2;

function showUploadDocumentImage(input) {
    let files = input.files[0];
    let previewContainer = input.closest('.previewContainer');
    let imagePreview = previewContainer.querySelectorAll('.imagePreview')[0];
    let docPreview = previewContainer.querySelectorAll('.docPreview')[0];
    let iconPreview = previewContainer.querySelectorAll('.iconPreview')[0];
}

function addMoreBankDetails(e) {
    e.preventDefault();
    let newBankDetails = `
            <tr class="bankDetails_${addMoreRows}">
                <td >
                    <div class="btn btn-danger mt-1"><a type="button" id="nextButton" class="fa-solid fa-user-minus removeTr" onclick='removeTr(${addMoreRows})'></a><div>
                </td>
                <td><input type="text" name="bank_name[]" id="bank_name_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="bank name"></td>
                <td><input type="text" name="branch_name[]" id="branch_name_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="branch name"></td>
                <td><input type="text" name="account_holder_name[]" id="account_holder_name_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="account holder name"></td>
                <td><input type="text" name="account_number[]" id="account_number_${addMoreRows}" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="account number"></td>
                <td><input type="text" name="ifsc_code[]" id="ifsc_code_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="IFSC code"></td>
                <td><input type="text" name="beneficiary_name[]" id="beneficiary_name_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="beneficiary name"></td>
                <td>
                    <input type="file" name="documents[]" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                    <div class="previewContainer" style="display: none;">
                        <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                        <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;">X</span>
                        <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                        <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                    </div>
                </td>
            </tr>
    `;
    $('#bankDetailsTable tbody').append(newBankDetails);
    addMoreRows++;
    document.querySelectorAll('.removeTr').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });
}


function addMoreExperienceDetails(e) {
    e.preventDefault();
    let newExperienceDetails = `
            <tr class="experienceDetails_${addMoreRows}">
                <td>
                    <div class="btn btn-danger mt-1"><a type="button" id="nextButton" class="fa-solid fa-user-minus removeTr" onclick='removeTr(${addMoreRows})'></a><div>
                </td>
                <td><input type="text" name="company_name[]" id="company_name_${addMoreRows}" oninput="stringValidation(event)" oninput="stringValidation(event)"  class="form-control" placeholder="previous company name"></td>
                <td><input type="text" name="previous_role[]" id="previous_role_${addMoreRows}" oninput="stringValidation(event)"  class="form-control" placeholder="previous role"></td>
                <td><input type="text" name="experience[]" id="experience_${addMoreRows}" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="previous experience"></td>
                <td><input type="text" name="previous_doj[]" id="previous_doj_${addMoreRows}" onclick="openFlatpickr(event)" class="form-control" placeholder="previous joining working date"></td>
                <td><input type="text" name="previous_doe[]" id="previous_doe_${addMoreRows}" onclick="openFlatpickr(event)" class="form-control" placeholder="previous last working date"></td>
                <td><input type="number" name="previous_salary[]" id="previous_salary_${addMoreRows}" oninput="acceptOnlyNumber(event)" class="form-control" placeholder="previous salary"></td>
                <td><input type="text" name="previous_hr_name[]" id="previous_hr_name_${addMoreRows}" oninput="stringValidation(event)" class="form-control" placeholder="previous hr name"></td>
                <td><input type="text" name="previous_hr_contact[]" id="previous_hr_contact_${addMoreRows}" oninput="acceptOnlyNumber(event)"  class="form-control" placeholder="previous hr contact"></td>
                <td><input type="text" name="previous_project[]" id="_${addMoreRows}" oninput="stringValidation(event)"  class="form-control" placeholder="previous project"></td>
                <td><input type="text" name="previous_technology[]" id="previous_project_${addMoreRows}"  oninput="stringValidation(event)"  class="form-control" placeholder="previous technology use"></td>
                <td>
                    <input type="file" name="experience_documents[]" id="experience_documents_${addMoreRows}" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                    <div class="previewContainer" style="display: none;">
                        <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                        <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;">X</span>
                        <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                        <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                    </div>
                </td>
            </tr>
    `;
    $('#experienceDetailsTable tbody').append(newExperienceDetails);
    addMoreRows++;
    document.querySelectorAll('.removeTr').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('tr').remove();
        }); 
    });
}


// Attendence Management
document.querySelectorAll('input[name="choice"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        if (event.target.value === "punchValue1") {
            document.getElementById("content1").style.display = "block";
            document.getElementById("content2").style.display = "none";
        } else {
            document.getElementById("content1").style.display = "none";
            document.getElementById("content2").style.display = "block";
        }
    });
});


