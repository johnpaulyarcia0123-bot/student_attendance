<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Announcements | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",Roboto,sans-serif}
        body{display:flex;background:#f4f6f9;min-height:100vh}
    .sidebar{width:230px;background:#1e293b;min-height:100vh;color:#94a3b8;position:fixed;overflow-y:auto}
    .sidebar.logo{padding:15px;color:white;font-size:16px;border-bottom:1px solid #334155;display:flex;gap:8px;align-items:center;font-weight:600}
    .sidebar.profile{padding:12px 15px;display:flex;gap:10px;align-items:center;border-bottom:1px solid #334155}
    .sidebar ul{list-style:none;padding-bottom:20px}
    .sidebar li{padding:10px 15px;font-size:13px;display:flex;gap:10px;align-items:center;cursor:pointer;color:#94a3b8}
    .sidebar li:hover{background:#2a3a4f;color:white}
    .sidebar li.active{background:#3b82f6;color:white;border-radius:5px;margin:5px 8px}
    .sidebar.label{padding:14px 15px 5px 15px;font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-top:5px}
    .sidebar a.link{color:inherit;text-decoration:none;display:flex;gap:10px;align-items:center;width:100%}
    .main{margin-left:230px;width:calc(100% - 230px)}
    .topbar{background:white;height:50px;display:flex;justify-content:space-between;align-items:center;padding:0 20px;box-shadow:0 1px 2px rgba(0,0,0,0.08);font-size:13px;color:#666}
    .content{padding:20px}.header{display:flex;justify-content:space-between;margin-bottom:18px}.header h2{font-size:22px;font-weight:500;color:#1e293b}
    .grid{display:grid;grid-template-columns:420px 1fr;gap:18px;align-items:start}
    .card{background:white;border-radius:4px;border:1px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.04);overflow:hidden}
    .card-head{padding:12px 15px;border-bottom:1px solid #e2e8f0;font-size:13px;font-weight:600;background:white;border-top:3px solid #3b82f6}
    .card-body{padding:15px}
    .form-group{margin-bottom:14px}.form-group label{font-size:13px;font-weight:600;display:block;margin-bottom:6px;color:#1e293b}
    .form-group label span{color:#ef4444}
    .form-control{width:100%;padding:8px 10px;border:1px solid #cbd5e1;border-radius:4px;font-size:13px;height:36px;background:white}
        textarea.form-control{height:120px;resize:vertical}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .btn{padding:8px 14px;border:none;border-radius:4px;font-size:13px;cursor:pointer}.btn-primary{background:#3b82f6;color:white}.btn-default{background:#e2e8f0;color:#334155;margin-left:6px}
    .empty{padding:25px 15px;color:#94a3b8;font-size:13px;text-align:left}
    .ann-item{padding:12px 15px;border-bottom:1px solid #f1f5f9}.ann-item:last-child{border-bottom:none}
    .badge-active{background:#22c55e;color:white;padding:2px 7px;border-radius:10px;font-size:10px;font-weight:600}
    .action-del{background:#ef4444;color:white;padding:3px 7px;border-radius:3px;cursor:pointer;font-size:11px;margin-left:6px}
    .action-edit{background:#f59e0b;color:white;padding:3px 7px;border-radius:3px;cursor:pointer;font-size:11px}
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile"><div style="width:32px;height:32px;background:#334155;border-radius:50%;display:flex;justify-content:center;align-items:center;color:white"><i class="fa-solid fa-user" style="font-size:12px"></i></div><div><div style="color:white;font-size:12px;font-weight:600">Yarcia John Paul</div><div style="font-size:10px">Super Administrator</div></div></div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li class="active"><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:18px;align-items:center">
                <span><i class="fa-solid fa-bars"></i></span>
                <span><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;align-items:center"><i class="fa-regular fa-bell"></i><span><i class="fa-regular fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header">
                <h2>System Announcements</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php" style="color:#3b82f6;text-decoration:none">Home</a> / System Announcements</div>
            </div>

            <div class="grid">
                <div class="card">
                    <div class="card-head">New Announcement</div>
                    <div class="card-body">
                        <div class="form-group"><label>Title <span>*</span></label><input type="text" id="annTitle" class="form-control"></div>
                        <div class="form-group"><label>Message <span>*</span></label><textarea id="annMessage" class="form-control"></textarea></div>
                        <div class="form-row">
                            <div class="form-group"><label>Starts At</label><input type="datetime-local" id="annStarts" class="form-control"></div>
                            <div class="form-group"><label>Ends At</label><input type="datetime-local" id="annEnds" class="form-control"></div>
                        </div>
                        <div class="form-group"><label>Status</label>
                            <select id="annStatus" class="form-control"><option>Active</option><option>Inactive</option></select>
                        </div>
                        <div style="margin-top:15px">
                            <button class="btn btn-primary" id="saveBtn" onclick="saveAnn()">Save Announcement</button>
                            <button class="btn btn-default" onclick="clearForm()">Clear</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">System Announcements</div>
                    <div id="annList"><div class="empty">No announcements.</div></div>
                </div>
            </div>

            <div style="margin-top:30px;font-size:11px;color:#94a3b8;text-align:right">
                © 2026 QR A S
            </div>
        </div>
    </div>

<script>
let announcements = JSON.parse(localStorage.getItem('bscs_announcements') || '[]');
let editIndex = -1;

function saveAnn(){
    const title=document.getElementById('annTitle').value.trim();
    const message=document.getElementById('annMessage').value.trim();
    const starts=document.getElementById('annStarts').value;
    const ends=document.getElementById('annEnds').value;
    const status=document.getElementById('annStatus').value;
    if(!title||!message){alert('Title and Message required!');return;}
    const data={title,message,starts,ends,status,date:new Date().toLocaleString()};
    if(editIndex>=0){announcements[editIndex]=data;editIndex=-1;document.getElementById('saveBtn').innerText='Save Announcement';}
    else{announcements.push(data);}
    localStorage.setItem('bscs_announcements', JSON.stringify(announcements));
    clearForm();renderAnn();
}
function clearForm(){
    document.getElementById('annTitle').value='';document.getElementById('annMessage').value='';
    document.getElementById('annStarts').value='';document.getElementById('annEnds').value='';
    document.getElementById('annStatus').value='Active';editIndex=-1;
    document.getElementById('saveBtn').innerText='Save Announcement';
}
function editAnn(i){
    const a=announcements[i];
    document.getElementById('annTitle').value=a.title;
    document.getElementById('annMessage').value=a.message;
    document.getElementById('annStarts').value=a.starts;
    document.getElementById('annEnds').value=a.ends;
    document.getElementById('annStatus').value=a.status;
    editIndex=i;document.getElementById('saveBtn').innerText='Update Announcement';
}
function deleteAnn(i){
    if(confirm('Delete "'+announcements[i].title+'"?')){
        announcements.splice(i,1);
        localStorage.setItem('bscs_announcements', JSON.stringify(announcements));
        renderAnn();
    }
}
function renderAnn(){
    const list=document.getElementById('annList');
    if(announcements.length===0){list.innerHTML='<div class="empty">No announcements.</div>';return;}
    list.innerHTML=announcements.slice().reverse().map((a,idx)=>{
        const realIdx = announcements.length-1-idx;
        const start = a.starts? new Date(a.starts).toLocaleString() : 'Now';
        const end = a.ends? new Date(a.ends).toLocaleString() : 'No end';
        return `<div class="ann-item">
            <div style="display:flex;justify-content:space-between">
                <div><b style="font-size:13px">${a.title}</b><div style="font-size:11px;color:#64748b">${start} → ${end}</div></div>
                <div><span class="action-edit" onclick="editAnn(${realIdx})"><i class="fa-solid fa-pen"></i></span><span class="action-del" onclick="deleteAnn(${realIdx})"><i class="fa-solid fa-trash"></i></span></div>
            </div>
            <div style="font-size:13px;color:#334155;margin-top:8px">${a.message}</div>
        </div>`;
    }).join('');
}
renderAnn();
</script>
</body>
</html>