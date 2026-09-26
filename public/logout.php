<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI",Roboto,sans-serif }
        body { display:flex; background:#f4f6f9; min-height:100vh }
        .sidebar { width:230px; background:#222d32; min-height:100vh; color:#8aa4af; position:fixed }
        .sidebar .logo { padding:15px; color:white; font-size:18px; border-bottom:1px solid #2c3b41 }
        .sidebar .profile { padding:12px 15px; display:flex; gap:10px; align-items:center; border-bottom:1px solid #2c3b41 }
        .sidebar ul { list-style:none }
        .sidebar li { padding:10px 15px; font-size:14px; display:flex; align-items:center; cursor:pointer }
        .sidebar li:hover { background:#1e282c; color:white }
        .sidebar li.active { background:#dc3545; color:white; border-radius:5px; margin:5px 8px }
        .sidebar .label { padding:12px 15px 5px 15px; font-size:11px; color:#5a7a87; text-transform:uppercase; margin-top:8px }
        .sidebar a.link { color:inherit; text-decoration:none; display:flex; gap:10px; align-items:center; width:100% }
        .main { margin-left:230px; width:calc(100% - 230px) }
        .topbar { background:white; height:50px; display:flex; justify-content:space-between; align-items:center; padding:0 20px; box-shadow:0 1px 2px rgba(0,0,0,0.08) }
        .content { padding:20px; display:flex; justify-content:center; align-items:center; min-height:80vh }
        .logout-box { background:white; width:420px; max-width:95%; border-radius:6px; border:1px solid #e9ecef; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center; padding:30px 25px }
        .logout-icon { width:70px; height:70px; background:#f8d7da; color:#dc3545; border-radius:50%; display:flex; justify-content:center; align-items:center; margin:0 auto 15px auto; font-size:28px }
        .btn { padding:9px 18px; border:none; border-radius:4px; font-size:13px; cursor:pointer }
        .btn-danger { background:#dc3545; color:white }
        .btn-light { background:#f1f1f1; border:1px solid #ddd; color:#333; margin-right:8px }
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
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Account</div>
            <li class="active"><a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555"><span><i class="fa-solid fa-bars"></i></span><span><i class="fa-solid fa-qrcode"></i> Scanner</span></div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i><span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>
        <div class="content">
            <div class="logout-box">
                <div class="logout-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                <h3 style="font-weight:600;margin-bottom:8px">Ready to leave?</h3>
                <p style="font-size:13px;color:#777;margin-bottom:20px">Are you sure you want to logout from QR Attendance System?<br>Your BSCS data will remain saved.</p>
                <div>
                    <button class="btn btn-light" onclick="location.href='dashboard.php'">Cancel</button>
                    <button class="btn btn-danger" onclick="doLogout()"><i class="fa-solid fa-right-from-bracket"></i> Yes, Logout</button>
                </div>
                <div style="margin-top:15px;font-size:11px;color:#aaa" id="countInfo">BSCS 2B - 30 Students | Session Active</div>
            </div>
        </div>
    </div>
<script>
function doLogout(){
    localStorage.removeItem('bscs_current_user');
    localStorage.removeItem('bscs_is_logged_in');
    localStorage.removeItem('bscs_admin_logged');
    // DITO NA BABALIK SA INDEX.PHP - HINDI NA LOGIN.PHP
    window.location.href = 'index.php';
}
const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
document.getElementById('countInfo').innerText = 'BSCS 2B - ' + students.length + ' Students | Session Active';
</script>
</body>
</html>