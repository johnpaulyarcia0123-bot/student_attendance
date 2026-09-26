<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Users | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",Roboto,sans-serif}
        body{display:flex;background:#f4f6f9;min-height:100vh}
   .sidebar{width:230px;background:#1e293b;min-height:100vh;color:#94a3b8;position:fixed;overflow-y:auto}
   .sidebar ul{list-style:none;padding-bottom:20px}
   .sidebar li{padding:10px 15px;font-size:13px;display:flex;gap:10px;align-items:center;cursor:pointer;color:#94a3b8}
   .sidebar li:hover{background:#2a3a4f;color:white}
   .sidebar li.active{background:#3b82f6;color:white;border-radius:5px;margin:5px 8px}
   .sidebar.label{padding:14px 15px 5px 15px;font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-top:5px}
   .sidebar a.link{color:inherit;text-decoration:none;display:flex;gap:10px;align-items:center;width:100%}
   .main{margin-left:230px;width:calc(100% - 230px)}
   .topbar{background:white;height:50px;display:flex;justify-content:space-between;align-items:center;padding:0 20px;box-shadow:0 1px 2px rgba(0,0,0,0.08);font-size:13px;color:#666}
   .content{padding:20px}.header{display:flex;justify-content:space-between;margin-bottom:18px}.header h2{font-size:22px;font-weight:500;color:#1e293b}
   .grid{display:grid;grid-template-columns:380px 1fr;gap:18px;align-items:start}
   .card{background:white;border-radius:4px;border:1px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.04);overflow:hidden}
   .card-head{padding:12px 15px;border-bottom:1px solid #e2e8f0;font-size:13px;font-weight:600;background:white;border-top:3px solid #3b82f6}
   .card-body{padding:15px}
   .form-group{margin-bottom:12px}.form-group label{font-size:12px;font-weight:600;display:block;margin-bottom:5px;color:#1e293b}
   .form-group label span{color:#ef4444;font-weight:400;font-size:10px}
   .form-control{width:100%;padding:7px 10px;border:1px solid #cbd5e1;border-radius:4px;font-size:12px;height:34px;background:white}
   .form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
   .btn{padding:8px 14px;border:none;border-radius:4px;font-size:12px;cursor:pointer}.btn-primary{background:#3b82f6;color:white}
    table{width:100%;border-collapse:collapse;font-size:12px}th{padding:10px 10px;text-align:left;background:#f8fafc;border-bottom:1px solid #e2e8f0;font-weight:600;color:#475569;font-size:11px}td{padding:12px 10px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
   .user-avatar{width:32px;height:32px;background:#e2e8f0;border-radius:50%;display:inline-flex;justify-content:center;align-items:center;margin-right:8px;color:#64748b}
   .badge-active{background:#22c55e;color:white;padding:2px 7px;border-radius:10px;font-size:10px;font-weight:600}
   .action-edit{background:#fbbf24;color:#000;width:20px;height:20px;display:inline-flex;justify-content:center;align-items:center;border-radius:3px;cursor:pointer;margin-right:2px}
   .action-del{background:#ef4444;color:white;width:20px;height:20px;display:inline-flex;justify-content:center;align-items:center;border-radius:3px;cursor:pointer}
    </style>
</head>
<body>
    <div class="sidebar">
        <div style="padding:15px;color:white;border-bottom:1px solid #334155;display:flex;gap:8px;align-items:center;font-weight:600"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div style="padding:12px 15px;display:flex;gap:10px;align-items:center;border-bottom:1px solid #334155"><div style="width:32px;height:32px;background:#334155;border-radius:50%;display:flex;justify-content:center;align-items:center;color:white"><i class="fa-solid fa-user" style="font-size:12px"></i></div><div><div style="color:white;font-size:12px;font-weight:600">Yarcia John Paul</div><div style="font-size:10px">Super Administrator</div></div></div>
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
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li class="active"><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:18px;align-items:center"><span><i class="fa-solid fa-bars"></i></span><span><i class="fa-solid fa-qrcode"></i> Scanner</span><span><i class="fa-solid fa-tv"></i> Public Kiosk</span></div>
            <div style="display:flex;gap:15px;align-items:center"><i class="fa-regular fa-bell"></i><span><i class="fa-regular fa-user"></i> Yarcia John Paul Admin</span></div>
        </div>

        <div class="content">
            <div class="header"><h2>System Users</h2><div style="font-size:13px;color:#64748b"><a href="dashboard.php" style="color:#3b82f6;text-decoration:none">Home</a> / System Users</div></div>

            <div class="grid">
                <!-- LEFT EXACT SA SCREENSHOT -->
                <div class="card">
                    <div class="card-head">Add System User</div>
                    <div class="card-body">
                        <div class="form-group"><label>Full Name <span>*</span></label><input type="text" id="uName" class="form-control"></div>
                        <div class="form-row">
                            <div class="form-group"><label>Username <span>*</span></label><input type="text" id="uUsername" class="form-control"></div>
                            <div class="form-group"><label>Phone</label><input type="text" id="uPhone" class="form-control"></div>
                        </div>
                        <div class="form-group"><label>Email <span>*</span></label><input type="email" id="uEmail" class="form-control"></div>
                        <div class="form-row">
                            <div class="form-group"><label>Role <span>*</span></label><select id="uRole" class="form-control"><option>Super Administrator</option><option>Staff / Operator</option><option>BSCS Adviser</option></select></div>
                            <div class="form-group"><label>Status</label><select id="uStatus" class="form-control"><option>Active</option><option>Inactive</option></select></div>
                        </div>
                        <div class="form-group"><label>Password <span style="color:#64748b">required for new users</span></label><input type="password" id="uPass" class="form-control"></div>
                        <div class="form-group"><label>Photo</label><input type="file" id="uPhoto" class="form-control" style="padding:4px"></div>
                        <div style="margin-top:15px"><button class="btn btn-primary" id="saveBtn" onclick="saveUser()">Save User</button></div>
                    </div>
                </div>

                <!-- RIGHT EXACT SA SCREENSHOT -->
                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">Authorized Users</div>
                    <div style="overflow-x:auto">
                        <table>
                            <thead><tr><th>User</th><th>Username</th><th>Role</th><th>Status</th><th>Last Login</th><th>Action</th></tr></thead>
                            <tbody id="userBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
let users = JSON.parse(localStorage.getItem('bscs_users') || JSON.stringify([
    {fullName:'Test Staff', username:'staff', email:'staff@mail.com', phone:'', role:'Staff / Operator', status:'Active', lastLogin:'29 Jul 2026 01:37 PM'},
    {fullName:'Yarcia John Paul', username:'admin', email:'admin@mail.com', phone:'', role:'Super Administrator', status:'Active', lastLogin:'03 Aug 2026 02:04 PM'}
]));
let editIndex=-1;

function saveUser(){
    const fullName=document.getElementById('uName').value.trim();
    const username=document.getElementById('uUsername').value.trim();
    const phone=document.getElementById('uPhone').value.trim();
    const email=document.getElementById('uEmail').value.trim();
    const role=document.getElementById('uRole').value;
    const status=document.getElementById('uStatus').value;
    if(!fullName||!username||!email){alert('Full Name, Username, Email required!');return;}
    const now=new Date(); const lastLogin=now.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'})+' '+now.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit'});
    const data={fullName,username,phone,email,role,status,lastLogin};
    if(editIndex>=0){users[editIndex]={...users[editIndex],...data};editIndex=-1;document.getElementById('saveBtn').innerText='Save User';}
    else{users.push(data);}
    localStorage.setItem('bscs_users', JSON.stringify(users));
    clearForm();renderUsers();
}
function clearForm(){
    document.getElementById('uName').value='';document.getElementById('uUsername').value='';document.getElementById('uPhone').value='';document.getElementById('uEmail').value='';document.getElementById('uPass').value='';editIndex=-1;
}
function editUser(i){
    const u=users[i];
    document.getElementById('uName').value=u.fullName;document.getElementById('uUsername').value=u.username;document.getElementById('uPhone').value=u.phone;document.getElementById('uEmail').value=u.email;document.getElementById('uRole').value=u.role;document.getElementById('uStatus').value=u.status;
    editIndex=i;document.getElementById('saveBtn').innerText='Update User';window.scrollTo(0,0);
}
function deleteUser(i){
    if(users[i].username==='admin'){alert('Cannot delete Super Admin!');return;}
    if(confirm('Delete '+users[i].fullName+'?')){users.splice(i,1);localStorage.setItem('bscs_users', JSON.stringify(users));renderUsers();}
}
function renderUsers(){
    const tbody=document.getElementById('userBody');
    tbody.innerHTML=users.map((u,i)=>`
        <tr>
            <td><div style="display:flex;align-items:center"><span class="user-avatar"><i class="fa-solid fa-user" style="font-size:11px"></i></span><div><b style="font-size:12px">${u.fullName}</b><br><span style="font-size:10px;color:#64748b">${u.email}</span></div></div></td>
            <td>${u.username}</td>
            <td>${u.role}</td>
            <td><span class="badge-active">${u.status}</span></td>
            <td style="font-size:11px;color:#475569">${u.lastLogin}</td>
            <td>
                <span class="action-edit" onclick="editUser(${i})"><i class="fa-solid fa-pen" style="font-size:10px"></i></span>
                ${u.username!=='admin'?`<span class="action-del" onclick="deleteUser(${i})"><i class="fa-solid fa-trash" style="font-size:10px"></i></span>`:''}
            </td>
        </tr>
    `).join('');
}
renderUsers();
</script>
</body>
</html>