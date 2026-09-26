<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Schedules | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI",Roboto,sans-serif }
        body { display:flex; background:#f4f6f9; min-height:100vh }
       .sidebar { width:230px; background:#222d32; min-height:100vh; color:#8aa4af; position:fixed; overflow-y:auto }
       .sidebar.logo { padding:15px; color:white; font-size:18px; border-bottom:1px solid #2c3b41 }
       .sidebar.profile { padding:12px 15px; display:flex; gap:10px; align-items:center; border-bottom:1px solid #2c3b41 }
       .sidebar ul { list-style:none; padding-bottom:20px }
       .sidebar li { padding:10px 15px; font-size:14px; display:flex; gap:10px; align-items:center; cursor:pointer }
       .sidebar li:hover { background:#1e282c; color:white }
       .sidebar li.active { background:#007bff; color:white; border-radius:5px; margin:5px 8px }
       .sidebar.label { padding:12px 15px 5px 15px; font-size:11px; color:#5a7a87; text-transform:uppercase; margin-top:8px }
       .sidebar a.link { color:inherit; text-decoration:none; display:flex; gap:10px; align-items:center; width:100% }
       .main { margin-left:230px; width:calc(100% - 230px) }
       .topbar { background:white; height:50px; display:flex; justify-content:space-between; align-items:center; padding:0 20px; box-shadow:0 1px 2px rgba(0,0,0,0.08) }
       .content { padding:20px }
       .header { display:flex; justify-content:space-between; margin-bottom:15px }
       .header h2 { font-size:24px; font-weight:400 }
       .card { background:white; border-radius:5px; border:1px solid #e9ecef; box-shadow:0 1px 2px rgba(0,0,0,0.05); overflow:hidden }
       .card-head { padding:12px 15px; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center; font-size:14px }
       .btn { padding:7px 12px; border:none; border-radius:3px; font-size:13px; cursor:pointer }
       .btn-primary { background:#007bff; color:white }
       .btn-sm { padding:5px 8px; font-size:12px }
        table { width:100%; border-collapse:collapse; font-size:13px }
        th { padding:12px 10px; text-align:left; background:#fff; border-bottom:1px solid #eee; font-weight:600; font-size:13px; color:#333 }
        td { padding:12px 10px; border-bottom:1px solid #f0f0f0; vertical-align:top }
       .badge-day { background:#f4f4f4; border:1px solid #eee; padding:2px 6px; border-radius:3px; font-size:11px; margin-right:2px; display:inline-block; font-weight:600 }
       .badge-active { background:#00a65a; color:white; padding:3px 7px; border-radius:3px; font-size:11px }
       .action-edit { background:#f39c12; color:white; width:22px; height:22px; display:inline-flex; justify-content:center; align-items:center; border-radius:3px; cursor:pointer; margin-right:2px }
       .action-del { background:#dd4b39; color:white; width:22px; height:22px; display:inline-flex; justify-content:center; align-items:center; border-radius:3px; cursor:pointer }
       .modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000 }
       .modal.active { display:flex }
       .modal-box { background:white; width:600px; max-height:90vh; overflow-y:auto; border-radius:5px }
       .modal-head { padding:12px 15px; border-bottom:1px solid #eee; font-weight:600; display:flex; justify-content:space-between }
       .modal-body { padding:15px }
       .form-group { margin-bottom:12px }
       .form-group label { font-size:13px; font-weight:600; display:block; margin-bottom:5px }
       .form-control { width:100%; padding:7px 10px; border:1px solid #d2d6de; border-radius:3px; font-size:13px; height:34px }
       .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px }
       .days-check { display:flex; gap:6px; flex-wrap:wrap; margin-top:5px }
       .days-check label { font-weight:400; font-size:12px; display:flex; gap:4px; align-items:center; background:#f4f4f4; padding:4px 8px; border-radius:3px; cursor:pointer }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <div style="color:white;font-size:13px">Yarcia John Paul</div>
                <div style="font-size:11px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li class="active"><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555">
                <span><i class="fa-solid fa-bars"></i></span>
                <span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555">
                <i class="fa-solid fa-bell"></i>
                <span><i class="fa-solid fa-user"></i> Yarcia John Paul</span>
            </div>
        </div>

        <div class="content">
            <div class="header">
                <h2>Attendance Schedules</h2>
                <div style="font-size:13px;color:#777">
                    <a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / Attendance Schedules
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <span>Attendance Schedules - BSCS Only</span>
                    <button class="btn btn-primary btn-sm" onclick="openModal()">
                        <i class="fa-solid fa-plus"></i> Create Schedule
                    </button>
                </div>
                <div style="padding:0;overflow-x:auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th><th>Hours</th><th>Late After</th><th>Allowed Scan Window</th>
                                <th>Available Days</th><th>Assignments</th><th>Status</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="schedBody"></tbody>
                    </table>
                </div>
            </div>

            <div style="display:flex;justify-content:space-between;margin-top:20px;font-size:12px;color:#888">
                <span></span>
                <span id="connStatus">BSCS Students: 0 | Departments: 0 | Categories: 0</span>
            </div>
        </div>
    </div>

    <div class="modal" id="schedModal">
        <div class="modal-box">
            <div class="modal-head">
                <span id="modalTitle">Create BSCS Schedule</span>
                <span onclick="closeModal()" style="cursor:pointer"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Schedule Name *</label>
                    <input type="text" id="schedName" class="form-control" placeholder="e.g., BSCS Morning Class">
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Time In *</label><input type="time" id="timeIn" class="form-control" value="08:00"></div>
                    <div class="form-group"><label>Time Out *</label><input type="time" id="timeOut" class="form-control" value="17:00"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Late After (min)</label><input type="number" id="lateAfter" class="form-control" value="10"></div>
                    <div class="form-group"><label>Status</label><select id="schedStatus" class="form-control"><option>Active</option><option>Inactive</option></select></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Scan Window Before (min)</label><input type="number" id="beforeMin" class="form-control" value="60"></div>
                    <div class="form-group"><label>Scan Window After (min)</label><input type="number" id="afterMin" class="form-control" value="120"></div>
                </div>
                <div class="form-group">
                    <label>Available Days</label>
                    <div class="days-check">
                        <label><input type="checkbox" value="Mon" checked> Mon</label>
                        <label><input type="checkbox" value="Tue" checked> Tue</label>
                        <label><input type="checkbox" value="Wed" checked> Wed</label>
                        <label><input type="checkbox" value="Thu" checked> Thu</label>
                        <label><input type="checkbox" value="Fri" checked> Fri</label>
                        <label><input type="checkbox" value="Sat"> Sat</label>
                        <label><input type="checkbox" value="Sun"> Sun</label>
                    </div>
                </div>
                <div class="form-group"><label>Assign to BSCS Categories - KONEKTADO</label><select id="assignCat" class="form-control"></select></div>
                <div class="form-group"><label>Assign to BSCS Sections - KONEKTADO</label><select id="assignDept" class="form-control"></select></div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:15px">
                    <button class="btn btn-primary" onclick="saveSched()" id="saveBtn">Save Schedule</button>
                    <button class="btn" style="background:#f4f4f4" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<script>
let schedules = JSON.parse(localStorage.getItem('bscs_schedules') || JSON.stringify([
    {
        name:'BSCS Morning Kiosk',
        timeIn:'07:00',
        timeOut:'12:00',
        lateAfter:15,
        before:60,
        after:120,
        days:['Mon','Tue','Wed','Thu','Fri'],
        cat:'All Categories',
        dept:'All BSCS Sections 1A-4B',
        status:'Active'
    },
    {
        name:'BSCS Afternoon Class',
        timeIn:'13:00',
        timeOut:'17:00',
        lateAfter:10,
        before:60,
        after:120,
        days:['Mon','Tue','Wed','Thu','Fri'],
        cat:'Regular',
        dept:'BSCS 2A',
        status:'Active'
    }
]));

let editIndex = -1;

function formatTime(t){
    const[h,m]=t.split(':');
    const hour=parseInt(h);
    const ampm=hour>=12?'PM':'AM';
    const h12=hour%12||12;
    return `${String(h12).padStart(2,'0')}:${m} ${ampm}`;
}

function loadConnectedData(){
    const students = JSON.parse(localStorage.getItem('bscs_students')||'[]');
    const cats = JSON.parse(localStorage.getItem('bscs_categories')||'[]');
    const depts = JSON.parse(localStorage.getItem('bscs_departments')||'[]');
    document.getElementById('connStatus').innerText = `BSCS Students: ${students.length} | Departments: ${depts.length||8} | Categories: ${cats.length||2}`;

    const catSel = document.getElementById('assignCat');
    catSel.innerHTML = '<option>All Categories (Regular + Irregular)</option>' + cats.map(c=>`<option>${c.name}</option>`).join('') + (cats.length===0?'<option>Regular</option><option>Irregular</option>':'');

    const deptSel = document.getElementById('assignDept');
    deptSel.innerHTML = '<option>All BSCS Sections 1A-4B</option>' + depts.map(d=>`<option>${d.name}</option>`).join('') + (depts.length===0?'<option>BSCS 1A</option><option>BSCS 1B</option><option>BSCS 2A</option><option>BSCS 2B</option><option>BSCS 3A</option><option>BSCS 3B</option><option>BSCS 4A</option><option>BSCS 4B</option>':'');
    return {students, cats, depts};
}

function renderSched(){
    const {students, cats, depts} = loadConnectedData();
    const tbody=document.getElementById('schedBody');
    if(schedules.length===0){
        tbody.innerHTML=`<tr><td colspan="8" style="text-align:center;padding:30px;color:#999">No schedules yet. Create BSCS schedule!</td></tr>`;
        return;
    }
    tbody.innerHTML=schedules.map((s,i)=>{
        const catCount = cats.length||2;
        return `<tr>
            <td><b>${s.name}</b></td>
            <td>${formatTime(s.timeIn)} – ${formatTime(s.timeOut)}</td>
            <td>${s.lateAfter} min</td>
            <td>${s.before} min before<br>${s.after} min after</td>
            <td>${s.days.map(d=>`<span class="badge-day">${d}</span>`).join('')}</td>
            <td style="font-size:12px;color:#555">${catCount} categories<br><span style="font-size:11px">${s.dept} · ${students.length} people</span></td>
            <td><span class="badge-active">${s.status}</span></td>
            <td>
                <span class="action-edit" onclick="editSched(${i})"><i class="fa-solid fa-pen-to-square" style="font-size:11px"></i></span>
                <span class="action-del" onclick="deleteSched(${i})"><i class="fa-solid fa-trash" style="font-size:11px"></i></span>
            </td>
        </tr>`;
    }).join('');
}

function openModal(){
    loadConnectedData();
    document.getElementById('schedModal').classList.add('active');
    editIndex=-1;
    document.getElementById('modalTitle').innerText='Create BSCS Schedule';
    document.getElementById('saveBtn').innerText='Save Schedule';
    document.getElementById('schedName').value='';
}

function closeModal(){
    document.getElementById('schedModal').classList.remove('active');
}

function saveSched(){
    const name=document.getElementById('schedName').value.trim();
    if(!name) return alert('Please enter schedule name');

    const data={
        name,
        timeIn:document.getElementById('timeIn').value,
        timeOut:document.getElementById('timeOut').value,
        lateAfter:document.getElementById('lateAfter').value,
        before:document.getElementById('beforeMin').value,
        after:document.getElementById('afterMin').value,
        status:document.getElementById('schedStatus').value,
        cat:document.getElementById('assignCat').value,
        dept:document.getElementById('assignDept').value,
        days:[...document.querySelectorAll('.days-check input:checked')].map(c=>c.value)
    };

    if(editIndex>=0){
        schedules[editIndex]=data;
        editIndex=-1;
    } else {
        schedules.push(data);
    }

    localStorage.setItem('bscs_schedules',JSON.stringify(schedules));
    closeModal();
    renderSched();
}

function editSched(i){
    const s=schedules[i];
    editIndex=i;
    loadConnectedData();
    document.getElementById('modalTitle').innerText='Edit: '+s.name;
    document.getElementById('saveBtn').innerText='Update Schedule';
    document.getElementById('schedName').value=s.name;
    document.getElementById('timeIn').value=s.timeIn;
    document.getElementById('timeOut').value=s.timeOut;
    document.getElementById('lateAfter').value=s.lateAfter;
    document.getElementById('beforeMin').value=s.before;
    document.getElementById('afterMin').value=s.after;
    document.getElementById('schedStatus').value=s.status;
    document.getElementById('assignCat').value=s.cat;
    document.getElementById('assignDept').value=s.dept;
    document.querySelectorAll('.days-check input').forEach(cb=>{
        cb.checked=s.days.includes(cb.value);
    });
    document.getElementById('schedModal').classList.add('active');
}

// FIXED - Hindi na halatang AI
function deleteSched(i){
    if(confirm('Are you sure you want to delete ' + schedules[i].name + '? This action cannot be undone.')){
        schedules.splice(i,1);
        localStorage.setItem('bscs_schedules',JSON.stringify(schedules));
        renderSched();
    }
}

renderSched();
</script>
</body>
</html>