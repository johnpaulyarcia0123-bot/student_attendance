<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Demo Person | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",Roboto,sans-serif}
        body{display:flex;background:#f4f6f9;min-height:100vh}
       .sidebar{width:230px;background:#222d32;min-height:100vh;color:#8aa4af;position:fixed}
       .sidebar.logo{padding:15px;color:white;font-size:18px;border-bottom:1px solid #2c3b41;display:flex;gap:8px;align-items:center}
       .sidebar.profile{padding:12px 15px;display:flex;gap:10px;align-items:center;border-bottom:1px solid #2c3b41}
       .sidebar ul{list-style:none;padding-bottom:20px}
       .sidebar li{padding:10px 15px;font-size:14px;display:flex;gap:10px;align-items:center;cursor:pointer}
       .sidebar li:hover{background:#1e282c;color:white}
       .sidebar li.active{background:#007bff;color:white;border-radius:5px;margin:5px 8px}
       .sidebar.label{padding:12px 15px 5px 15px;font-size:11px;color:#5a7a87;text-transform:uppercase;margin-top:8px}
       .main{margin-left:230px;width:calc(100% - 230px)}
       .topbar{background:white;height:50px;display:flex;justify-content:space-between;align-items:center;padding:0 20px;box-shadow:0 1px 2px rgba(0,0,0,0.08)}
       .content{padding:20px}
       .header{display:flex;justify-content:space-between;margin-bottom:15px}
       .header h2{font-size:22px;font-weight:500;color:#333}
       .view-grid{display:grid;grid-template-columns:360px 1fr;gap:20px}
       .card{background:white;border-radius:4px;border:1px solid #d2d6de;border-top:3px solid #007bff;box-shadow:0 1px 1px rgba(0,0,0,0.05)}
       .card-body{padding:20px}
       .avatar{width:95px;height:95px;border-radius:50%;background:#6d1b4a;display:flex;justify-content:center;align-items:center;margin:0 auto;overflow:hidden;border:3px solid #eee}
       .avatar img{width:100%;height:100%;object-fit:cover}
       .info-line{display:flex;justify-content:space-between;padding:11px 0;border-bottom:1px solid #f4f4f4;font-size:13px}
       .info-line b{color:#333;font-size:13px}
       .info-line span{color:#666;font-size:13px}
       .badge-active{background:#28a745;color:white;padding:2px 7px;border-radius:3px;font-size:11px}
       .btn{padding:7px 12px;border:none;border-radius:3px;cursor:pointer;font-size:13px}
       .btn-primary{background:#007bff;color:white;width:100%;padding:9px;margin-top:15px}
       .qr-card{background:white;border-radius:4px;border:1px solid #d2d6de;box-shadow:0 1px 1px rgba(0,0,0,0.05)}
       .qr-card-head{padding:12px 15px;border-bottom:1px solid #eee;display:flex;justify-content:space-between;align-items:center}
       .qr-flex{display:flex;gap:25px;padding:20px}
       .token-box{background:#f9f9f9;border:1px solid #eee;padding:10px 12px;border-radius:4px;margin-top:12px}
       .btn-green{background:#00a65a;color:white;font-size:12px;padding:6px 10px}
       .btn-yellow{background:#f39c12;color:white;font-size:12px;padding:6px 10px}
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
    <div class="profile"><div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div><div><div style="color:white;font-size:13px">Yarcia John Paul</div><div style="font-size:11px">Super Administrator</div></div></div>
    <ul>
        <li onclick="location.href='dashboard.php'"><i class="fa-solid fa-gauge"></i> Dashboard</li>
        <li onclick="location.href='scanner.php'"><i class="fa-solid fa-camera"></i> QR Scanner</li>
        <div class="label">Attendance</div>
        <li onclick="location.href='attendance_logs.php'"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</li>
        <li onclick="location.href='reports.php'"><i class="fa-solid fa-chart-bar"></i> Reports & Export</li>
        <div class="label">People & Rules</div>
        <li class="active" onclick="location.href='students.php'"><i class="fa-solid fa-users"></i> People</li>
        <li><i class="fa-solid fa-tags"></i> Categories</li>
        <li><i class="fa-solid fa-diagram-project"></i> Departments / Groups</li>
        <li><i class="fa-solid fa-calendar"></i> Schedules</li>
        <li><i class="fa-solid fa-umbrella-beach"></i> Holidays</li>
        <li><i class="fa-solid fa-bullhorn"></i> Announcements</li>
    </ul>
</div>

<div class="main">
    <div class="topbar">
        <div style="display:flex;gap:20px;font-size:14px;color:#555">
            <span><i class="fa-solid fa-bars"></i></span>
            <span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-table-cells"></i> Scanner</span>
            <span><i class="fa-solid fa-desktop"></i> Public Kiosk</span>
        </div>
        <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i> <span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
    </div>

    <div class="content">
        <div class="header">
            <h2 id="headerName">Demo Person</h2>
            <div style="font-size:13px;color:#777"><a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / <span id="breadName">Demo Person</span></div>
        </div>

        <div class="view-grid">
            <!-- LEFT - gaya sa pic -->
            <div>
                <div class="card">
                    <div class="card-body" style="text-align:center">
                        <div class="avatar" id="avatarBox"><div style="font-size:50px;color:#7ec8e3">◧◨</div></div>
                        <div style="font-size:17px;font-weight:600;margin-top:12px" id="vName">Demo Person</div>
                        <div style="font-size:13px;color:#999;margin-top:4px" id="vRole">Sample Role</div>

                        <div style="margin-top:20px;text-align:left">
                            <div class="info-line"><b>Person ID</b><span id="vID" style="color:#dd4b39;font-size:12px">PER00003</span></div>
                            <div class="info-line"><b>Category</b><span id="vCategory">Visitor</span></div>
                            <div class="info-line"><b>Department</b><span id="vDept">Test Department</span></div>
                            <div class="info-line"><b>Schedule</b><span id="vSched">Test 2 kiosk</span></div>
                            <div class="info-line"><b>Status</b><span><span class="badge-active" id="vStatus">Active</span></span></div>
                        </div>

                        <button class="btn btn-primary" onclick="editNow()"><i class="fa-solid fa-pen-to-square"></i> Edit Person</button>
                    </div>
                </div>

                <div class="card" style="margin-top:15px;border-top:3px solid #f4f4f4">
                    <div style="padding:12px 15px;font-weight:600;font-size:14px;border-bottom:1px solid #eee;display:flex;justify-content:space-between">
                        Recent Attendance History
                        <a href="attendance_logs.php" style="font-size:11px;color:#007bff;text-decoration:none;border:1px solid #007bff;padding:3px 7px;border-radius:3px">Full Individual Report</a>
                    </div>
                    <div class="card-body" id="historyList" style="font-size:13px;color:#999;text-align:center;padding:15px">
                        No attendance yet
                    </div>
                </div>
            </div>

            <!-- RIGHT - QR Code & Contact Details - gaya sa pic -->
            <div class="qr-card">
                <div class="qr-card-head">
                    <div style="font-size:14px;font-weight:500">QR Code & Contact Details</div>
                    <button class="btn" style="border:1px solid #ddd;background:white;font-size:12px" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Card</button>
                </div>
                <div class="qr-flex">
                    <div style="text-align:center">
                        <div id="qrcode" style="border:1px solid #eee;padding:8px;background:white"></div>
                        <div style="display:flex;gap:6px;margin-top:12px;justify-content:center">
                            <button class="btn btn-green" onclick="downloadQR()"><i class="fa-solid fa-download"></i> Download QR</button>
                            <button class="btn btn-yellow" onclick="regenerateQR()"><i class="fa-solid fa-rotate"></i> Regenerate</button>
                        </div>
                    </div>

                    <div style="flex:1;font-size:13px">
                        <div style="display:grid;grid-template-columns:90px 1fr;gap:10px;margin-bottom:10px"><b>Gender</b><span id="vGender">Male</span></div>
                        <div style="display:grid;grid-template-columns:90px 1fr;gap:10px;margin-bottom:10px"><b>Birthdate</b><span id="vBirth">07 May 1985</span></div>
                        <div style="display:grid;grid-template-columns:90px 1fr;gap:10px;margin-bottom:10px"><b>Contact</b><span id="vContact">4444444440</span></div>
                        <div style="display:grid;grid-template-columns:90px 1fr;gap:10px;margin-bottom:10px"><b>Email</b><span id="vEmail">demoperson@mail.com</span></div>
                        <div style="display:grid;grid-template-columns:90px 1fr;gap:10px;margin-bottom:15px"><b>Address</b><span id="vAddress">7/7 Demo Address</span></div>

                        <div class="token-box">
                            <div style="font-weight:700;font-size:12px;margin-bottom:6px">QR validation token:</div>
                            <div id="vToken" style="font-size:11px;color:#dd4b39;word-break:break-all;line-height:1.4">acd4263b6cf7cf4d88a06752e54949daa7c2109d01c5927428dd6963e2a2db3b</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadView(){
    const idx = localStorage.getItem('view_student_idx');
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    if(idx===null ||!students[idx]){
        // Kung walang na-click, demo data gaya sa pic mo
        return; // ipakita demo
    }
    const s = students[idx];
    document.getElementById('pageTitle').innerText = s.fullName + ' | QR A S';
    document.getElementById('headerName').innerText = s.fullName;
    document.getElementById('breadName').innerText = s.fullName;
    document.getElementById('vName').innerText = s.fullName;
    document.getElementById('vRole').innerText = s.position || 'BSCS Student';
    document.getElementById('vID').innerText = s.id;
    document.getElementById('vCategory').innerText = s.category;
    document.getElementById('vDept').innerText = s.department;
    document.getElementById('vSched').innerText = s.department + ' kiosk';
    document.getElementById('vStatus').innerText = s.status;
    document.getElementById('vGender').innerText = s.gender;
    document.getElementById('vBirth').innerText = s.birthdate || 'Not set';
    document.getElementById('vContact').innerText = s.contact || 'No contact';
    document.getElementById('vEmail').innerText = s.email;
    document.getElementById('vAddress').innerText = s.address || 'No address';
    document.getElementById('vToken').innerText = s.qr + s.qr + Math.random().toString(16).substring(2,20);

    // avatar
    if(s.photo){
        document.getElementById('avatarBox').innerHTML = `<img src="${s.photo}">`;
    }

    // QR generate with real data
    document.getElementById('qrcode').innerHTML='';
    new QRCode(document.getElementById('qrcode'), {
        text: s.id + '|' + s.fullName + '|' + s.qr,
        width: 200,
        height: 200
    });

    // history
    const att = JSON.parse(localStorage.getItem('bscs_attendance')||'[]').filter(a=>a.id===s.id);
    if(att.length>0){
        document.getElementById('historyList').innerHTML = att.map(a=>`<div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eee;text-align:left"><span>${new Date(a.time).toLocaleString()}</span><span style="background:#00a65a;color:white;padding:2px 6px;border-radius:3px;font-size:11px">${a.status}</span></div>`).join('');
    }

    // save for download
    window.currentStudent = s;
}
function editNow(){ window.location.href='students.php'; }
function downloadQR(){
    const canvas = document.querySelector('#qrcode canvas');
    if(!canvas){ alert('No QR'); return; }
    const link = document.createElement('a');
    link.download = (window.currentStudent?.id || 'PER00003') + '_QR.png';
    link.href = canvas.toDataURL();
    link.click();
}
function regenerateQR(){
    const students = JSON.parse(localStorage.getItem('bscs_students')||'[]');
    const idx = localStorage.getItem('view_student_idx');
    if(idx!==null && students[idx]){
        students[idx].qr = Math.random().toString(16).substring(2,14)+Math.random().toString(16).substring(2,14)+Math.random().toString(16).substring(2,14);
        localStorage.setItem('bscs_students', JSON.stringify(students));
        loadView();
        alert('QR Regenerated!');
    } else {
        location.reload();
    }
}
// Default QR para sa Demo Person sa pic mo
new QRCode(document.getElementById('qrcode'), {
    text: 'PER00003|Demo Person|acd4263bcf7cf4d88a06752e54949daa7c2109d01c5927428dd6963e2a2db3b',
    width: 200,
    height: 200
});
loadView();
</script>

</body>
</html>