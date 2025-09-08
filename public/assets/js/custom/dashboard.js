"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const parentModalEl = document.getElementById('applyLeave');
    const childModalEl  = document.getElementById('leaveType');

    const parentModal = new bootstrap.Modal(parentModalEl);
    const childModal  = new bootstrap.Modal(childModalEl, { backdrop:false });

    // Open parent from external button
    document.getElementById('applyLeave').addEventListener('click', function (e) {
        e.preventDefault();
        parentModal.show();
    });

    // Open child from inside parent
    document.getElementById('openChildModal').addEventListener('click', function (e) {
        e.preventDefault();
        childModal.show();
    });

    // Close child (X button)
    document.getElementById('closeChildModal').addEventListener('click', function () {
        childModal.hide();
    });

    // Map values to labels & color classes (for parent badge)
    const typeMeta = {
        absent:               {label:'Absent',                    cls:'cr-red'},
        present:              {label:'Present',                   cls:'cr-green'},
        leave_applied:        {label:'Leave Applied',             cls:'cr-orange'},
        leave_approved:       {label:'Leave Approved',            cls:'cr-blue'},
        weekly_off:           {label:'Weekly Off',                cls:'cr-purple'},
        holiday:              {label:'Holiday',                   cls:'cr-teal'},
        outdoor_wfh:          {label:'Outdoor/WFH',               cls:'cr-brown'},
        wfh:                  {label:'Work From Home',            cls:'cr-cyan'},
        deputation:           {label:'Deputation',                cls:'cr-indigo'},
        first_half_applied:   {label:'First Half Leave Applied',  cls:'cr-darkorange'},
        second_half_applied:  {label:'Second Half Leave Applied', cls:'cr-goldenrod'},
        half_day:             {label:'Half Day',                  cls:'cr-slate'},
        first_half_approved:  {label:'First Half Leave Approved', cls:'cr-dodger'},
        second_half_approved: {label:'Second Half Leave Approved',cls:'cr-sea'},
        multiple:             {label:'Multiple Leave Applications',cls:'cr-crimson'}
    };

    // Apply selection: set hidden input + badge + close child
    document.getElementById('applyLeaveType').addEventListener('click', function(){
        const sel = document.querySelector('input[name="leave_type_radio"]:checked');
        if(!sel) return;

        const val = sel.value;
        const meta = typeMeta[val] || {label:val, cls:''};

        document.getElementById('leave_type').value = val;
        const badge = document.getElementById('selectedLeaveBadge');
        badge.className = 'badge'; // reset
        badge.classList.add('text-bg-light'); // base
        badge.innerHTML = `<span class="swatch ${meta.cls}" style="margin-right:6px;"></span>${meta.label}`;
        childModal.hide();
    });
});

let currentDate = new Date();
const calendarGrid = document.getElementById("calendarGrid");
const monthYear = document.getElementById("monthYear");
const tooltip = document.getElementById("tooltip");

// Dummy attendance data
const attendanceData = {
    "2025-08-01": { status: "Present", punchIn: "09:00", punchOut: "18:00" },
    "2025-08-02": { status: "Absent" },
    "2025-08-03": { status: "Present", punchIn: "09:15", punchOut: "17:50" }
};

function renderCalendar(date) {
    calendarGrid.innerHTML = "";
    const year = date.getFullYear();
    const month = date.getMonth();
    const day = date.getDay();
    monthYear.innerText = date.toLocaleString("default", { month: "long" }) + " " + year;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    for (let i = 0; i < firstDay; i++) {
        calendarGrid.innerHTML += `<div></div>`; // Empty days
    }

    for (let day = 1; day <= lastDate; day++) {
        const fullDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const attData = attendanceData[fullDate];
        let color = "";

        if (attData) {
            if (attData.status === "Present") color = "style='background:#c8e6c9'";
            else if (attData.status === "Absent") color = "style='background:#ffcdd2'";
        } else {
            color = "style='background:#e0f7fa'"; // Default color for no data
        }

        calendarGrid.innerHTML += `<div class="day" data-date="${fullDate}" ${color}>${day}</div>`;
    }

    document.querySelectorAll(".day").forEach(dayEl => {
        dayEl.addEventListener("mouseover", showTooltip);
        dayEl.addEventListener("mouseout", hideTooltip);
        dayEl.addEventListener("click", handlePunch);
    });
}

function showTooltip(e) {
    const date = e.target.dataset.date;
    const data = attendanceData[date];
    if (data) {
        tooltip.innerHTML = `
        <b>${date}</b><br>
        Status: ${data.status}<br>
        ${data.punchIn ? `In: ${data.punchIn}<br>Out: ${data.punchOut}` : ""}
        `;
    } else {
        tooltip.innerHTML = `<b>${date}</b><br>No Data`;
    }
    tooltip.style.display = "block";
    tooltip.style.left = (e.pageX + 10) + "px";
    tooltip.style.top = (e.pageY + 10) + "px";
}

function hideTooltip() {
    tooltip.style.display = "none";
}

function handlePunch(e) {
    const date = e.target.dataset.date;
    const existing = attendanceData[date];
    if (!existing || !existing.punchIn) {
        attendanceData[date] = { status: "Present", punchIn: new Date().toLocaleTimeString() };
        Swal.fire({
            title: `Punched In for ${date}`,
            icon: "success",
            timer: 1500
        });
    } else if (!existing.punchOut) {
        existing.punchOut = new Date().toLocaleTimeString();
        Swal.fire({
            title: `Punched Out for ${date}`,
            icon: "success",
            timer: 1500
        });
    } else {
        Swal.fire({
            title: "Already Punched In and Out for this date.",
            icon: "error",
            timer: 1500
        });
    }
    renderCalendar(currentDate);
}

// Navigation
document.getElementById("prevMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
};
document.getElementById("nextMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
};
renderCalendar(currentDate);
