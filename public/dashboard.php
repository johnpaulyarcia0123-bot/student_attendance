<?php
session_start();
if(!isset($_SESSION['bscs_admin'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Roboto, sans-serif; }
        body { display: flex; background: #f4f6f9; min-height: 100vh; }
        .sidebar { width: 230px; background: #222d32; min-height: 100vh; color: #8aa4af; position: fixed; }
        .sidebar .logo { padding: 15px; color: white; font-size: 18px; border-bottom: 1px solid #2c3b41; }
        .sidebar .profile { padding: 12px 15px; display: flex; gap: 10px; align-items: center; border-bottom: 1px solid #2c3b41; }
        .sidebar ul { list-style: none; }
        .sidebar li { padding: 10px 15px; font-size: 14px; display: flex; align-items: center; cursor: pointer; }
        .sidebar li:hover { background: #1e282c; color: white; }
        .sidebar li.active { background: #007bff; color: white; border-radius: 5px; margin: 5px 8px; }
        .sidebar .label { padding: 12px 15px 5px 15px; font-size: 11px; color: #5a7a87; text-transform: uppercase; margin-top: 8px; }
        .sidebar a.link { color: inherit; text-decoration: none; display: flex; gap: 10px; align-items: center; width: 100%; }
        .main { margin-left: 230px; width: calc(100% - 230px); }
        .topbar { background: white; height: 50px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.08); }
        .topbar .left { display: flex; gap: 20px; font-size: 14px; color: #555; }
        .content { padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .header h2 { font-size: 24px; font-weight: 400; }
        .cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .card { border-radius: 5px; padding: 15px; color: white; position: relative; overflow: hidden; min-height: 120px; }
        .card h1 { font-size: 32px; }
        .card .icon { position: absolute; right: 15px; top: 20px; font-size: 65px; opacity: 0.25; }
        .card .footer { background: rgba(0,0,0,0.1); margin: 12px -15px -15px -15px; padding: 7px; text-align: center; font-size: 13px; cursor: pointer; }
        .bg-blue { background: #00a8c5; }
        .bg-green { background: #28a745; }
        .bg-yellow { background: #ffc107; color: #333 !important; }
        .bg-red { background: #dc3545; }
        .row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .box { background: white; border-radius: 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e9ecef; }
        .box-head { padding: 12px 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; }
        .box-body { padding: 15px; }
        .btn-blue { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .time-box { border: 1px solid #e9ecef; display: flex; align-items: center; gap: 15px; padding: 10px; border-radius: 4px; margin-bottom: 12px; cursor: pointer; }
        .time-box:hover { background: #f8f9fa; border-color: #007bff; }
        .time-icon { width: 55px; height: 55px; display: flex; justify-content: center; align-items: center; border-radius: 4px; color: white; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px; border-bottom: 1px solid #f0f0f0; text-align: left; }
        .modal-bg { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 999; justify-content: center; align-items: center; }
        .modal-box { background: white; width: 500px; max-width: 95%; border-radius: 6px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .modal-head { padding: 12px 15px; background: #007bff; color: white; display: flex; justify-content: space-between; font-weight: 600; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div>
            <div><div style="color:white;font-size:13px"><?php echo htmlspecialchars($_SESSION['bscs_admin']); ?></div><div style="font-size:11px">Super Administrator</div></div>
        </div>
        <ul>
            <li class="active"><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="topbar">
            <div class="left">
                <span><i class="fa-solid fa-bars"></i></span>
                <span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="position:relative">
                <div style="display:flex;gap:15px;font-size:14px;color:#555;cursor:pointer;align-items:center" onclick="toggleUserMenu()" id="userBtn">
                    <i class="fa-solid fa-bell"></i>
                    <span><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['bscs_admin']); ?> <i class="fa-solid fa-caret-down" style="font-size:10px;margin-left:4px"></i></span>
                </div>
                <div id="userDropdown" style="display:none;position:absolute;right:0;top:35px;background:white;width:220px;border:1px solid #ddd;border-radius:5px;box-shadow:0 4px 15px rgba(0,0,0,0.15);z-index:9999;overflow:hidden">
                    <div style="padding:12px 15px;border-bottom:1px solid #eee;background:#f9f9f9">
                        <div style="font-size:13px;font-weight:600;color:#333"><?php echo htmlspecialchars($_SESSION['bscs_admin']); ?></div>
                        <div style="font-size:11px;color:#888">Super Administrator</div>
                        <div style="font-size:10px;color:#28a745;margin-top:4px"><i class="fa-solid fa-circle" style="font-size:6px"></i> Active now</div>
                    </div>
                    <div style="padding:5px 0">
                        <a href="profile.php" style="display:flex;gap:10px;align-items:center;padding:9px 15px;font-size:13px;color:#333;text-decoration:none"><i class="fa-solid fa-user-gear" style="width:18px"></i> My Profile</a>
                        <a href="settings.php" style="display:flex;gap:10px;align-items:center;padding:9px 15px;font-size:13px;color:#333;text-decoration:none"><i class="fa-solid fa-gear" style="width:18px"></i> Settings</a>
                        <div style="border-top:1px solid #eee;margin:5px 0"></div>
                        <a href="logout.php" style="display:flex;gap:10px;align-items:center;padding:10px 15px;font-size:13px;color:#dc3545;text-decoration:none;font-weight:600;background:#fff5f5"><i class="fa-solid fa-right-from-bracket" style="width:18px"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="header"><h2>Dashboard</h2><div style="font-size:13px;color:#777"><a href="#" style="color:#007bff;text-decoration:none">Home</a> / Dashboard</div></div>
            <div class="cards">
                <div class="card bg-blue"><h1 id="totalStudents">0</h1><p>Registered Students</p><i class="fa-solid fa-users icon"></i><div class="footer" onclick="showAllStudents()">Manage people <i class="fa-solid fa-circle-arrow-right"></i></div></div>
                <div class="card bg-green"><h1 id="presentCount">0</h1><p>Today's Present</p><i class="fa-solid fa-user-check icon"></i><div class="footer" onclick="showPresentList()">View logs <i class="fa-solid fa-circle-arrow-right"></i></div></div>
                <div class="card bg-yellow"><h1 id="lateCount">0</h1><p>Today's Late</p><i class="fa-solid fa-clock icon"></i><div class="footer" onclick="showLateList()">View late records <i class="fa-solid fa-circle-arrow-right"></i></div></div>
                <div class="card bg-red"><h1 id="absentCount">0</h1><p>Today's Absent</p><i class="fa-solid fa-user-xmark icon"></i><div class="footer" onclick="showAbsentList()">View absences <i class="fa-solid fa-circle-arrow-right"></i></div></div>
            </div>
            <div class="row">
                <div class="box">
                    <div class="box-head">7-Day Attendance Overview <button class="btn-blue" onclick="location.href='scanner.php'"><i class="fa-solid fa-qrcode"></i> Open Scanner</button></div>
                    <div class="box-body" id="overviewBox" style="text-align:center;color:#bbb;padding:40px">No data yet</div>
                </div>
                <div class="box">
                    <div class="box-head">Time In / Time Out</div>
                    <div class="box-body">
                        <div class="time-box" onclick="showTimeIn()"><div class="time-icon" style="background:#007bff"><i class="fa-solid fa-right-to-bracket"></i></div><div><div style="font-size:13px">Time In Recorded</div><b style="font-size:18px" id="timeInCount">0</b></div></div>
                        <div class="time-box" onclick="showTimeOut()"><div class="time-icon" style="background:#6c757d"><i class="fa-solid fa-right-from-bracket"></i></div><div><div style="font-size:13px">Time Out Recorded</div><b style="font-size:18px" id="timeOutCount">0</b></div></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="box">
                    <div class="box-head">Recent Attendance <a href="attendance_logs.php" style="font-size:12px;color:#007bff;text-decoration:none">View all</a></div>
                    <div class="box-body" style="padding:0">
                        <table>
                            <thead><tr><th>Person</th><th>Category</th><th>Time In</th><th>Time Out</th><th>Status</th></tr></thead>
                            <tbody id="recentTable"><tr><td colspan="5" style="text-align:center;color:#999;padding:20px">No recent attendance</td></tr></tbody>
                        </table>
                    </div>
                </div>
                <div class="box">
                    <div class="box-head">System Announcements</div>
                    <div class="box-body" style="color:#888;font-size:13px" id="announceBox">No active announcements.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-bg" id="timeModal" onclick="closeModal(event)">
        <div class="modal-box">
            <div class="modal-head"><span id="modalTitle">List</span><span style="cursor:pointer" onclick="document.getElementById('timeModal').style.display='none'"><i class="fa-solid fa-xmark"></i></span></div>
            <div style="padding:0; max-height:400px; overflow:auto">
                <table><thead><tr><th>Person</th><th>Section</th><th>Time / Info</th></tr></thead><tbody id="modalBody"></tbody></table>
            </div>
        </div>
    </div>
<script>
let todayAllGlobal = [];
let allStudentsGlobal = [];
function toggleUserMenu(){
    const menu = document.getElementById('userDropdown');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}
document.addEventListener('click', function(e){
    const btn = document.getElementById('userBtn');
    const menu = document.getElementById('userDropdown');
    if(btn && menu && !btn.contains(e.target) && !menu.contains(e.target)){
        menu.style.display = 'none';
    }
});
function loadDashboard() {
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    const attendance = JSON.parse(localStorage.getItem('bscs_attendance') || '[]');
    allStudentsGlobal = students;
    document.getElementById('totalStudents').innerText = students.length;
    const today = new Date().toDateString();
    const isSaturday = new Date().getDay() === 6;
    const todayAtt = attendance.filter(a => {
        let d = a.date ? new Date(a.date).toDateString() : (a.time ? new Date(a.time).toDateString() : '');
        return d === today;
    });
    todayAllGlobal = todayAtt;
    document.getElementById('presentCount').innerText = todayAtt.length;
    document.getElementById('timeInCount').innerText = todayAtt.length;
    document.getElementById('timeOutCount').innerText = todayAtt.filter(a=>a.type==='Time Out' || a.timeOut).length || 0;
    document.getElementById('lateCount').innerText = todayAtt.filter(a=>a.status==='Late').length;
    document.getElementById('absentCount').innerText = Math.max(0, students.length - todayAtt.length);
    const recentBody = document.getElementById('recentTable');
    if (todayAtt.length === 0) {
        recentBody.innerHTML = `<tr><td colspan="5" style="text-align:center;color:#999;padding:20px">No recent attendance - Add students and scan QR first</td></tr>`;
        document.getElementById('overviewBox').innerHTML = students.length > 0 ? `You have <b>${students.length} students</b> registered.<br> BSCS Sections: ${[...new Set(students.map(s=>s.department))].join(', ')}<br><br><button class="btn-blue" onclick="location.href='scanner.php'"><i class="fa-solid fa-qrcode"></i> Start Scanning</button>` : 'No data yet - Add BSCS students first';
    } else {
        recentBody.innerHTML = todayAtt.slice(-5).reverse().map(a=>{
            const timeText = a.timeIn || (a.time ? new Date(a.time).toLocaleTimeString() : '-');
            const remarks = (a.remarks || '').toLowerCase();
            const showNoClass = isSaturday || remarks.includes('no class');
            const statusBadge = showNoClass ? `<span style="background:#6c757d;color:white;padding:2px 6px;border-radius:8px;font-size:11px">No Class - Saturday (Outside Schedule)</span>` : `<span style="background:#28a745;color:white;padding:2px 6px;border-radius:8px;font-size:11px">${a.status||'Present'}</span>`;
            return `<tr><td>${a.name}</td><td>${a.category||'Student'}</td><td>${timeText}</td><td>-</td><td>${statusBadge}</td></tr>`;
        }).join('');
        document.getElementById('overviewBox').innerHTML = `<b>${todayAtt.length} present today</b> out of ${students.length} students<br><br><div style="display:flex;gap:5px;justify-content:center;flex-wrap:wrap">${students.slice(0,4).map(s=>`<span style="background:#007bff;color:white;padding:3px 8px;border-radius:12px;font-size:11px">${s.department}</span>`).join('')}</div>`;
    }
}
function openModal(title, html) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalBody').innerHTML = html;
    document.getElementById('timeModal').style.display = 'flex';
}
function showPresentList() {
    if (todayAllGlobal.length === 0) { openModal("Today's Present - 0", `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No present today</td></tr>`); return; }
    const html = todayAllGlobal.map(a=>{ const t = a.timeIn || (a.time ? new Date(a.time).toLocaleTimeString() : '-'); return `<tr><td>${a.name}</td><td>${a.department||'BSCS 2B'}</td><td>${t}</td></tr>`; }).join('');
    openModal(`Today's Present - ${todayAllGlobal.length}`, html);
}
function showLateList() {
    const late = todayAllGlobal.filter(a=> (a.status||'').toLowerCase() === 'late');
    if (late.length === 0) { openModal("Today's Late - 0", `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No late today</td></tr>`); return; }
    const html = late.map(a=>`<tr><td>${a.name}</td><td>${a.department||'BSCS 2B'}</td><td>${a.timeIn || new Date(a.time).toLocaleTimeString()}</td></tr>`).join('');
    openModal(`Today's Late - ${late.length}`, html);
}
function showAbsentList() {
    const presentIds = todayAllGlobal.map(a=>a.studentId || a.id || a.name);
    const absent = allStudentsGlobal.filter(s=>{ const sid = s.id || s.studentId || s.name; return !presentIds.includes(sid) && !presentIds.includes(s.name); });
    if (absent.length === 0) { openModal("Today's Absent - 0", `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No absent - All present!</td></tr>`); return; }
    const html = absent.map(s=>`<tr><td>${s.name || s.fullName}</td><td>${s.department||'BSCS 2B'}</td><td><span style="background:#dc3545;color:white;padding:2px 6px;border-radius:8px;font-size:11px">Absent</span></td></tr>`).join('');
    openModal(`Today's Absent - ${absent.length}`, html);
}
function showAllStudents() {
    if (allStudentsGlobal.length === 0) { openModal("Registered Students - 0", `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No students</td></tr>`); return; }
    const html = allStudentsGlobal.slice(0,50).map(s=>`<tr><td>${s.name || s.fullName}</td><td>${s.department||'BSCS 2B'}</td><td>${s.category||'Student'}</td></tr>`).join('');
    openModal(`Registered Students - ${allStudentsGlobal.length}`, html);
}
function showTimeIn() { showPresentList(); }
function showTimeOut() {
    const outs = todayAllGlobal.filter(a=>a.type==='Time Out' || a.timeOut);
    if (outs.length === 0) { openModal("Time Out Recorded - 0", `<tr><td colspan="3" style="text-align:center;color:#999;padding:20px">No Time Out yet</td></tr>`); return; }
    const html = outs.map(a=>`<tr><td>${a.name}</td><td>${a.department||'BSCS 2B'}</td><td>${a.timeOut || new Date(a.time).toLocaleTimeString()}</td></tr>`).join('');
    openModal(`Time Out Recorded - ${outs.length}`, html);
}
function closeModal(e) { if (e.target.id === 'timeModal') document.getElementById('timeModal').style.display = 'none'; }
loadDashboard();
</script>
</body>
</html>