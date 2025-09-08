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
        timer: timer,
        confirmButtonText: confirmButtonText,
        showConfirmButton: showConfirmButton,
    });
}


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

const showThreeMonthBefroreFromCrruentMonthAndOneMonthAfter = (event) => {
    const input = event.target;
    if (input.type !== 'text') {
        console.warn(`Input field with ID ${input.id} is not a text date input.`);
        return;
    }
    if (!input._flatpickr) {
        const today = new Date();
        const threeMonthsBefore = new Date(today.getFullYear(), today.getMonth() - 3, 1);
        const oneMonthAfter = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        input._flatpickr = flatpickr(input, {
            dateFormat: 'Y-m-d',
            allowInput: true,
            minDate: threeMonthsBefore,
            maxDate: oneMonthAfter,
            onChange: function (selectedDates, dateStr) {
                input.value = dateStr;
            }
        }); 
    }
    input._flatpickr.open();
}

const timePicker = (event) => {
    const input = event.target;
    if (input.type !== 'text') {
        console.warn(`Input field with ID ${input.id} is not a text time input.`);
        return;
    }
    if (!input._flatpickr) {
        input._flatpickr = flatpickr(input, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
            allowInput: true,
            defaultDate: "01:45 PM",
            onChange: function (selectedDates, dateStr) {
                input.value = dateStr;
            }
        });
    }
    input._flatpickr.open();
}

// Automatically calculate hours from the date input
document.addEventListener('DOMContentLoaded', function() {
    function calculateTotalHour() {
        let inTime = document.getElementById('in_time_outdoor').value;
        let outTime = document.getElementById('out_time_outdoor').value;
        inTime = inTime.split(' ')[0];
        outTime = outTime.split(' ')[0];
        const totalHourInput = document.getElementById('total_hour_outdoor');
        if (inTime && outTime) {
            const [inHour, inMin] = inTime.split(':').map(Number);
            const [outHour, outMin] = outTime.split(':').map(Number);
            let start = new Date();
            let end = new Date();
            start.setHours(inHour, inMin, 0, 0);
            end.setHours(outHour, outMin, 0, 0);
            let diff = (end - start) / 1000 / 60 / 60;
            if (diff < 0) diff += 24;
            totalHourInput.value = diff.toFixed(2);
        } else {
            totalHourInput.value = '';
        }
    }
    document.getElementById('in_time_outdoor').addEventListener('change', calculateTotalHour);
    document.getElementById('out_time_outdoor').addEventListener('change', calculateTotalHour);
});

const multiSelectFlatpickrCalendar = (event) => {
    const input = event.target;
    if (input.type !== 'text') {
        console.warn(`Input field with ID ${input.id} is not a text date input.`);
        return;
    }
    if (!input._flatpickr) {
        // Calculate current year last date (December 31)
        const today = new Date();
        const lastDate = new Date(today.getFullYear(), 11, 31); // month is 0-indexed

        input._flatpickr = flatpickr(input, {
            mode: "multiple",
            dateFormat: 'Y-m-d',
            allowInput: true,
            minDate: today,
            maxDate: lastDate,
            conjunction: " , ",
            onChange: function (selectedDates, dateStr) {
            input.value = dateStr;
            }
        });
    }
    input._flatpickr.open();
};


// agar date picker automatically open hi rakhna hai tab onclick ki jagah onfocus use karein
const initFlatpickrCalendar = (event) => {
    const input = document.getElementById('apply_leave');
    if (!input._flatpickr) {
        input._flatpickr = flatpickr(input, {
            inline: true,
            mode: "multiple",
            dateFormat: 'Y-m-d',
            allowInput: true,
            minDate: "today",
            conjunction: " , ",
            maxDate: new Date().fp_incr(365),
            onChange: function (selectedDates, dateStr) {
                input.value = dateStr;
            }
        });
    }
    input._flatpickr.open();
};
// document.getElementById('applyLeave').addEventListener('shown.bs.modal', function () {
//     initFlatpickrCalendar();
// });


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

