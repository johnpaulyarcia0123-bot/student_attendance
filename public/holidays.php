<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",Roboto,sans-serif}
        body{display:flex;background:#f4f6f9;min-height:100vh}
      .sidebar{width:230px;background:#222d32;min-height:100vh;color:#8aa4af;position:fixed;overflow-y:auto}
      .sidebar ul{list-style:none;padding-bottom:20px}
      .sidebar li{padding:10px 15px;font-size:14px;display:flex;gap:10px;align-items:center;cursor:pointer}
      .sidebar li:hover{background:#1e282c;color:white}
      .sidebar li.active{background:#007bff;color:white;border-radius:5px;margin:5px 8px}
      .sidebar.label{padding:12px 15px 5px 15px;font-size:11px;color:#5a7a87;text-transform:uppercase;margin-top:8px}
      .sidebar a.link{color:inherit;text-decoration:none;display:flex;gap:10px;align-items:center;width:100%}
      .main{margin-left:230px;width:calc(100% - 230px)}
      .topbar{background:white;height:50px;display:flex;justify-content:space-between;align-items:center;padding:0 20px;box-shadow:0 1px 2px rgba(0,0,0,0.08)}
      .content{padding:20px}.header{display:flex;justify-content:space-between;margin-bottom:20px}.header h2{font-size:24px;font-weight:400}
      .grid{display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start}
      .card{background:white;border-radius:5px;border:1px solid #e9ecef;box-shadow:0 1px 2px rgba(0,0,0,0.05);overflow:hidden}
      .card-head{padding:12px 15px;border-bottom:1px solid #eee;font-size:14px;font-weight:600;background:#fff;border-top:3px solid #007bff}
      .card-body{padding:15px}.form-group{margin-bottom:15px}.form-group label{font-size:13px;font-weight:600;display:block;margin-bottom:6px;color:#333}
      .form-control{width:100%;padding:8px 10px;border:1px solid #d2d6de;border-radius:3px;font-size:13px;height:36px}
        textarea.form-control{height:90px;resize:vertical}
      .btn{padding:7px 14px;border:none;border-radius:3px;font-size:13px;cursor:pointer}.btn-primary{background:#007bff;color:white}.btn-default{background:transparent;color:#444}
        table{width:100%;border-collapse:collapse;font-size:13px}th{padding:12px 12px;text-align:left;background:white;border-bottom:1px solid #eee;color:#333;font-size:13px;font-weight:600}td{padding:12px 12px;border-bottom:1px solid #f0f0f0}
      .action-edit{background:#f39c12;color:white;width:22px;height:22px;display:inline-flex;justify-content:center;align-items:center;border-radius:3px;cursor:pointer;margin-right:2px}
      .action-del{background:#dd4b39;color:white;width:22px;height:22px;display:inline-flex;justify-content:center;align-items:center;border-radius:3px;cursor:pointer}
    </style>
</head>
<body>
    <div class="sidebar">
        <div style="padding:15px;color:white;border-bottom:1px solid #2c3b41"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div style="padding:12px 15px;display:flex;gap:10px;align-items:center;border-bottom:1px solid #2c3b41"><div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div><div><div style="color:white;font-size:13px">Yarcia John Paul</div><div style="font-size:11px">Super Administrator</div></div></div>
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
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li class="active"><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555"><span><i class="fa-solid fa-bars"></i></span><span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-qrcode"></i> Scanner</span><span><i class="fa-solid fa-tv"></i> Public Kiosk</span></div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i> <span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header"><h2>Holidays</h2><div style="font-size:13px;color:#777"><a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / Holidays</div></div>

            <div class="grid">
                <div class="card">
                    <div class="card-head">Add Holiday - BSCS</div>
                    <div class="card-body">
                        <div class="form-group"><label>Date <span style="color:red">*</span></label><input type="date" id="holidayDate" class="form-control"></div>
                        <div class="form-group"><label>Holiday Name <span style="color:red">*</span></label><input type="text" id="holidayName" class="form-control" placeholder="e.g., Foundation Day"></div>
                        <div class="form-group"><label>Description</label><textarea id="holidayDesc" class="form-control" placeholder="BSCS Holiday description"></textarea></div>
                        <div style="background:#f9f9f9;padding:10px 15px;margin:15px -15px -15px -15px;border-top:1px solid #eee;display:flex;gap:8px">
                            <button class="btn btn-primary" id="saveBtn" onclick="saveHoliday()">Save Holiday</button>
                            <button class="btn btn-default" onclick="clearForm()">Clear</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff;display:flex;justify-content:space-between"><span>Holiday Calendar</span><span id="holidayCount" style="font-size:11px;color:#888">0 holidays</span></div>
                    <div style="padding:0"><table><thead><tr><th>Date</th><th>Name</th><th>Description</th><th>Action</th></tr></thead><tbody id="holidayTableBody"></tbody></table></div>
                </div>
            </div>

            <div style="display:flex;justify-content:space-between;margin-top:20px;font-size:12px;color:#888">
                <span>© 2026 QR A S - BSCS Mode</span>
                <span id="connStatus">Connecting...</span>
            </div>
        </div>
    </div>

<script>
let holidays = JSON.parse(localStorage.getItem('bscs_holidays') || '[]');
let editIndex = -1;

function updateConnectionStatus(){
    const students = JSON.parse(localStorage.getItem('bscs_students')||'[]').length;
    const depts = JSON.parse(localStorage.getItem('bscs_departments')||'[]').length;
    const cats = JSON.parse(localStorage.getItem('bscs_categories')||'[]').length;
    const scheds = JSON.parse(localStorage.getItem('bscs_schedules')||'[]').length;
    const anns = JSON.parse(localStorage.getItem('bscs_announcements')||'[]').length;
    document.getElementById('connStatus').innerText = `KONEKTADO: Students ${students} | Depts ${depts||8} | Cats ${cats||2} | Scheds ${scheds} | Ann ${anns} | Holidays ${holidays.length}`;
    document.getElementById('holidayCount').innerText = holidays.length + ' holidays';
}

function saveHoliday(){
    const date=document.getElementById('holidayDate').value;
    const name=document.getElementById('holidayName').value.trim();
    const desc=document.getElementById('holidayDesc').value.trim();
    if(!date||!name){alert('Date and Name required!');return;}
    if(editIndex>=0){holidays[editIndex]={date,name,desc};editIndex=-1;document.getElementById('saveBtn').innerText='Save Holiday';}
    else{holidays.push({date,name,desc});}
    localStorage.setItem('bscs_holidays', JSON.stringify(holidays));
    clearForm();renderHolidays();
}
function clearForm(){document.getElementById('holidayDate').value='';document.getElementById('holidayName').value='';document.getElementById('holidayDesc').value='';editIndex=-1;document.getElementById('saveBtn').innerText='Save Holiday';}
function editHoliday(i){const h=holidays[i];document.getElementById('holidayDate').value=h.date;document.getElementById('holidayName').value=h.name;document.getElementById('holidayDesc').value=h.desc;editIndex=i;document.getElementById('saveBtn').innerText='Update Holiday';}
function deleteHoliday(i){if(confirm('Delete '+holidays[i].name+'?')){holidays.splice(i,1);localStorage.setItem('bscs_holidays', JSON.stringify(holidays));renderHolidays();}}
function renderHolidays(){
    holidays.sort((a,b)=>new Date(a.date)-new Date(b.date));
    const tbody=document.getElementById('holidayTableBody');
    if(holidays.length===0){tbody.innerHTML='<tr><td colspan="4" style="text-align:center;color:#999;padding:30px">No holidays configured.</td></tr>';updateConnectionStatus();return;}
    tbody.innerHTML=holidays.map((h,i)=>{
        const d=new Date(h.date);
        return `<tr>
            <td>${d.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}<br><small style="color:#aaa">${h.date}</small></td>
            <td><b>${h.name}</b></td>
            <td style="color:#666">${h.desc||'-'}</td>
            <td><span class="action-edit" onclick="editHoliday(${i})"><i class="fa-solid fa-pen" style="font-size:11px"></i></span><span class="action-del" onclick="deleteHoliday(${i})"><i class="fa-solid fa-trash" style="font-size:11px"></i></span></td>
        </tr>`;
    }).join('');
    updateConnectionStatus();
}
renderHolidays();
</script>
</body>
</html>