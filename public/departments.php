<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments / Groups | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI",Roboto,sans-serif }
        body { display:flex; background:#f4f6f9; min-height:100vh }
      .sidebar { width:230px; background:#222d32; min-height:100vh; color:#8aa4af; position:fixed }
      .sidebar.logo { padding:15px; color:white; font-size:18px; border-bottom:1px solid #2c3b41 }
      .sidebar.profile { padding:12px 15px; display:flex; gap:10px; align-items:center; border-bottom:1px solid #2c3b41 }
      .sidebar ul { list-style:none }
      .sidebar li { padding:10px 15px; font-size:14px; display:flex; align-items:center; cursor:pointer }
      .sidebar li:hover { background:#1e282c; color:white }
      .sidebar li.active { background:#007bff; color:white; border-radius:5px; margin:5px 8px }
      .sidebar.label { padding:12px 15px 5px 15px; font-size:11px; color:#5a7a87; text-transform:uppercase; margin-top:8px }
      .sidebar a.link { color:inherit; text-decoration:none; display:flex; gap:10px; align-items:center; width:100% }
      .main { margin-left:230px; width:calc(100% - 230px) }
      .topbar { background:white; height:50px; display:flex; justify-content:space-between; align-items:center; padding:0 20px; box-shadow:0 1px 2px rgba(0,0,0,0.08) }
      .topbar.left { display:flex; gap:20px; font-size:14px; color:#555 }
      .content { padding:20px }
      .row { display:grid; grid-template-columns:350px 1fr; gap:20px }
      .box { background:white; border-radius:5px; box-shadow:0 1px 2px rgba(0,0,0,0.05); border:1px solid #e9ecef }
      .box-head { padding:12px 15px; border-bottom:1px solid #eee; display:flex; justify-content:space-between; font-size:14px; font-weight:600 }
      .box-body { padding:15px }
      .input { width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:4px; margin:5px 0 12px 0; font-size:13px }
      .btn-blue { background:#007bff; color:white; border:none; padding:8px 14px; border-radius:4px; cursor:pointer; font-size:13px }
      .btn-clear { background:#f1f1f1; border:1px solid #ddd; color:#333; padding:8px 14px; border-radius:4px; cursor:pointer; margin-left:8px }
        table { width:100%; border-collapse:collapse; font-size:13px }
        th,td { padding:10px; border-bottom:1px solid #f0f0f0; text-align:left }
      .badge-active { background:#28a745; color:white; padding:4px 8px; border-radius:3px; font-size:11px; cursor:pointer; border:none }
      .badge-inactive { background:#6c757d; color:white; padding:4px 8px; border-radius:3px; font-size:11px; cursor:pointer; border:none }
      .badge-active:hover,.badge-inactive:hover { opacity:0.8 }
      .clickable { cursor:pointer; color:#007bff; font-weight:600 }
      .clickable:hover { text-decoration:underline }
      .people-count { cursor:pointer; color:#007bff; font-weight:700 }
      .people-count:hover { text-decoration:underline }
      .action-btn { padding:5px 7px; border-radius:3px; cursor:pointer; border:none; margin-right:3px }
      .edit-btn { background:#ffc107 }
      .del-btn { background:#dc3545; color:white }
      .modal-bg { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:999; justify-content:center; align-items:center }
      .modal-box { background:white; width:550px; max-width:95%; border-radius:6px; overflow:hidden; box-shadow:0 5px 20px rgba(0,0,0,0.2) }
      .modal-head { padding:12px 15px; background:#007bff; color:white; display:flex; justify-content:space-between; font-weight:600 }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div>
            <div><div style="color:white;font-size:13px">Yarcia John Paul</div><div style="font-size:11px">Super Administrator</div></div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li class="active"><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="left"><span><i class="fa-solid fa-bars"></i></span><span><i class="fa-solid fa-qrcode"></i> Scanner</span><span><i class="fa-solid fa-tv"></i> Public Kiosk</span></div>
            <div class="left"><i class="fa-solid fa-bell"></i><span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>
        <div class="content">
            <h2 style="font-weight:400;margin-bottom:15px">Departments / Groups</h2>
            <div class="row">
                <div class="box">
                    <div class="box-head" id="formTitle">Add Department / Group</div>
                    <div class="box-body">
                        <label style="font-size:12px">Parent Group</label>
                        <select class="input" id="parentGroup">
                            <option value="">— None —</option>
                            <option>BSCS 1A</option><option>BSCS 1B</option>
                            <option>BSCS 2A</option><option>BSCS 2B</option>
                            <option>BSCS 3A</option><option>BSCS 3B</option>
                            <option>BSCS 4A</option><option>BSCS 4B</option>
                        </select>
                        <label style="font-size:12px">Name *</label>
                        <input class="input" id="deptName" placeholder="e.g., BSCS 2B">
                        <label style="font-size:12px">Code</label>
                        <input class="input" id="deptCode" placeholder="e.g., BSCS2B - auto if empty">
                        <label style="font-size:12px">Description</label>
                        <textarea class="input" id="deptDesc" rows="3" placeholder="BSCS Section description"></textarea>
                        <label style="font-size:12px">Status</label>
                        <select class="input" id="deptStatus"><option value="Active">Active</option><option value="Inactive">Inactive</option></select>
                        <br>
                        <button class="btn-blue" id="saveBtn" onclick="saveGroup()">Save Group</button>
                        <button class="btn-clear" onclick="clearForm()">Clear</button>
                        <input type="hidden" id="editIndex" value="-1">
                    </div>
                </div>

                <div class="box">
                    <div class="box-head">Departments / Groups</div>
                    <div class="box-body" style="padding:0">
                        <table>
                            <thead><tr><th>Name</th><th>Parent</th><th>Code</th><th>People</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody id="deptTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-bg" id="deptModal" onclick="if(event.target.id==='deptModal') this.style.display='none'">
        <div class="modal-box">
            <div class="modal-head">
                <span id="modalTitle">BSCS 2B Students</span>
                <span style="cursor:pointer" onclick="document.getElementById('deptModal').style.display='none'"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <div style="padding:0; max-height:450px; overflow:auto">
                <table>
                    <thead><tr><th>Name</th><th>Department</th><th>Category</th></tr></thead>
                    <tbody id="modalBody"></tbody>
                </table>
            </div>
        </div>
    </div>

<script>
let departments = JSON.parse(localStorage.getItem('bscs_departments') || 'null');
if (!departments) {
    departments = [
        {name:'BSCS 1A', parent:'—', code:'BSCS1A', desc:'BSCS First Year Section A', status:'Inactive'},
        {name:'BSCS 1B', parent:'—', code:'BSCS1B', desc:'BSCS First Year Section B', status:'Inactive'},
        {name:'BSCS 2A', parent:'—', code:'BSCS2A', desc:'BSCS Second Year Section A', status:'Inactive'},
        {name:'BSCS 2B', parent:'—', code:'BSCS2B', desc:'BSCS Second Year Section B', status:'Active'},
        {name:'BSCS 3A', parent:'—', code:'BSCS3A', desc:'BSCS Third Year Section A', status:'Inactive'},
        {name:'BSCS 3B', parent:'—', code:'BSCS3B', desc:'BSCS Third Year Section B', status:'Inactive'},
        {name:'BSCS 4A', parent:'—', code:'BSCS4A', desc:'BSCS Fourth Year Section A', status:'Inactive'},
        {name:'BSCS 4B', parent:'—', code:'BSCS4B', desc:'BSCS Fourth Year Section B', status:'Inactive'},
    ];
    localStorage.setItem('bscs_departments', JSON.stringify(departments));
}

function saveDepts(){
    localStorage.setItem('bscs_departments', JSON.stringify(departments));
}

function loadDepts() {
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    const tbody = document.getElementById('deptTable');
    const counts = {};
    students.forEach(s => {
        const dep = s.department || 'BSCS 2B';
        counts[dep] = (counts[dep]||0)+1;
    });

    tbody.innerHTML = departments.map((d, i)=>{
        const people = counts[d.name] || (d.name==='BSCS 2B'? students.length : 0);
        const badge = d.status==='Active'
           ? `<button class="badge-active" onclick="toggleStatus(${i})" title="Click to set as Inactive">Active</button>`
            : `<button class="badge-inactive" onclick="toggleStatus(${i})" title="Click to set as Active">Inactive</button>`;

        return `<tr>
            <td><span class="clickable" onclick="showDept('${d.name}')">${d.name}</span><br><span style="font-size:11px;color:#888">${d.desc}</span></td>
            <td>${d.parent||'—'}</td>
            <td>${d.code}</td>
            <td><span class="people-count" onclick="showDept('${d.name}')">${people}</span></td>
            <td>${badge}</td>
            <td>
                <button class="action-btn edit-btn" onclick="editDept(${i})" title="Edit"><i class="fa-solid fa-pen"></i></button>
                <button class="action-btn del-btn" onclick="deleteDept(${i})" title="Delete"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>`;
    }).join('');
}

function toggleStatus(index){
    departments[index].status = departments[index].status==='Active'? 'Inactive' : 'Active';
    saveDepts();
    loadDepts();
}

function saveGroup(){
    const name = document.getElementById('deptName').value.trim();
    if(!name){
        alert('Please enter department name');
        return;
    }
    const parent = document.getElementById('parentGroup').value || '—';
    let code = document.getElementById('deptCode').value.trim();
    if(!code) code = name.replace(/\s+/g,'').toUpperCase();
    const desc = document.getElementById('deptDesc').value.trim() || name+' description';
    const status = document.getElementById('deptStatus').value;
    const editIndex = parseInt(document.getElementById('editIndex').value);

    if(editIndex >= 0){
        departments[editIndex] = {name, parent, code, desc, status};
    } else {
        departments.push({name, parent, code, desc, status});
    }
    saveDepts();
    clearForm();
    loadDepts();
}

function editDept(i){
    const d = departments[i];
    document.getElementById('deptName').value = d.name;
    document.getElementById('parentGroup').value = d.parent==='—'?'':d.parent;
    document.getElementById('deptCode').value = d.code;
    document.getElementById('deptDesc').value = d.desc;
    document.getElementById('deptStatus').value = d.status;
    document.getElementById('editIndex').value = i;
    document.getElementById('formTitle').innerText = 'Edit Department / Group - ' + d.name;
    document.getElementById('saveBtn').innerText = 'Update Group';
}

function clearForm(){
    document.getElementById('deptName').value='';
    document.getElementById('deptCode').value='';
    document.getElementById('deptDesc').value='';
    document.getElementById('deptStatus').value='Active';
    document.getElementById('parentGroup').value='';
    document.getElementById('editIndex').value='-1';
    document.getElementById('formTitle').innerText='Add Department / Group';
    document.getElementById('saveBtn').innerText='Save Group';
}

function deleteDept(i){
    if(confirm('Are you sure you want to delete ' + departments[i].name + '? This action cannot be undone.')){
        departments.splice(i,1);
        saveDepts();
        loadDepts();
    }
}

function showDept(deptName){
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    const filtered = students.filter(s => (s.department || 'BSCS 2B') === deptName);
    document.getElementById('modalTitle').innerText = `${deptName} - ${filtered.length} Students`;
    if(filtered.length===0){
        document.getElementById('modalBody').innerHTML = `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No students in ${deptName}</td></tr>`;
    } else {
        document.getElementById('modalBody').innerHTML = filtered.map(s=>`
            <tr>
                <td>${s.name||s.fullName}</td>
                <td><span style="background:#007bff;color:white;padding:2px 6px;border-radius:10px;font-size:11px">${s.department}</span></td>
                <td>${s.category||'Student'}</td>
            </tr>
        `).join('');
    }
    document.getElementById('deptModal').style.display='flex';
}

loadDepts();
</script>
</body>
</html>