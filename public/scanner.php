<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Roboto, sans-serif; }
        body { display: flex; background: #f4f6f9; min-height: 100vh; }
       .sidebar { width: 230px; background: #222d32; min-height: 100vh; color: #8aa4af; position: fixed; }
       .sidebar.logo { padding: 15px; color: white; font-size: 18px; border-bottom: 1px solid #2c3b41; }
       .sidebar.profile { padding: 12px 15px; display: flex; gap: 10px; align-items: center; border-bottom: 1px solid #2c3b41; }
       .sidebar ul { list-style: none; }
       .sidebar li { padding: 10px 15px; font-size: 14px; display: flex; align-items: center; cursor: pointer; }
       .sidebar li:hover { background: #1e282c; color: white; }
       .sidebar li.active { background: #007bff; color: white; border-radius: 5px; margin: 5px 8px; }
       .sidebar.label { padding: 12px 15px 5px 15px; font-size: 11px; color: #5a7a87; text-transform: uppercase; margin-top: 8px; }
       .sidebar a.link { color: inherit; text-decoration: none; display: flex; gap: 10px; align-items: center; width: 100%; }
       .main { margin-left: 230px; width: calc(100% - 230px); }
       .topbar { background: white; height: 50px; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.08); }
       .content { padding: 20px; }
       .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
       .header h2 { font-size: 24px; font-weight: 400; }
       .row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
       .box { background: white; border-radius: 5px; border: 1px solid #e9ecef; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
       .box-head { padding: 12px 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; font-weight: 600; font-size: 14px; }
       .box-body { padding: 15px; }
       .form-row { display: flex; gap: 10px; margin-bottom: 15px; }
       .form-group { flex: 1; }
       .form-group label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px; color: #444; }
       .form-control { width: 100%; padding: 7px 10px; border: 1px solid #d2d6de; border-radius: 3px; font-size: 13px; height: 34px; }
       .btn { padding: 7px 15px; border: none; border-radius: 3px; font-size: 13px; cursor: pointer; }
       .btn-primary { background: #007bff; color: white; }
       .btn-danger { background: #dc3545; color: white; }
       .badge { background: #6c757d; color: white; padding: 3px 7px; border-radius: 3px; font-size: 11px; }
        #reader { width: 100%; border: 1px solid #eee; border-radius: 4px; overflow: hidden; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
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
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li class="active"><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
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

    <!-- MAIN -->
    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555">
                <span><i class="fa-solid fa-bars"></i></span>
                <span><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555">
                <i class="fa-solid fa-bell"></i>
                <span><i class="fa-solid fa-user"></i>Yarcia John Paul</span>
            </div>
        </div>

        <div class="content">
            <div class="header">
                <h2>QR Attendance Scanner</h2>
                <div style="font-size:13px;color:#777">
                    <a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / QR Attendance Scanner
                </div>
            </div>

            <div class="row">
                <!-- Scanner Box -->
                <div class="box">
                    <div class="box-head">
                        <span><i class="fa-solid fa-camera"></i> Camera Scanner</span>
                        <span class="badge" id="statusBadge">Not started</span>
                    </div>
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Scan Action</label>
                                <select class="form-control" id="scanAction">
                                    <option>Auto: Time In then Time Out</option>
                                    <option>Force Time In</option>
                                    <option>Force Time Out</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Scanner Location</label>
                                <div style="display:flex;gap:5px">
                                    <input type="text" class="form-control" value="BSCS Room">
                                    <button class="btn btn-primary" id="scanBtn" onclick="toggleScanner()">
                                        <i class="fa-solid fa-play"></i> Start
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="reader"></div>
                        <div style="margin-top:15px;display:flex">
                            <input type="text" id="manualInput" class="form-control" placeholder="Paste QR: BSCS001|Name|token or ID" style="border-radius:3px 0 0 3px">
                            <button class="btn btn-primary" style="border-radius:0 3px 3px 0" onclick="submitManual()">Submit</button>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div>
                    <div class="box">
                        <div class="box-head">Attendance Confirmation</div>
                        <div class="box-body" id="confirmationBox" style="text-align:center;padding:40px;color:#999">
                            <div style="font-size:50px"><i class="fa-solid fa-qrcode"></i></div>
                            <p style="font-size:13px;margin-top:10px">Scan a registered BSCS QR code to display the result.</p>
                        </div>
                    </div>
                    <div class="box" style="margin-top:20px">
                        <div class="box-head">Recent Scans - Today</div>
                        <div class="box-body" id="recentScans" style="font-size:13px;color:#888">No scans in this session.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
let html5QrCode;
let isScanning = false;

function toggleScanner() {
    const btn = document.getElementById('scanBtn');
    const badge = document.getElementById('statusBadge');
    if (isScanning) {
        html5QrCode.stop().then(() => {
            badge.textContent = 'Not started';
            badge.style.background = '#6c757d';
            btn.innerHTML = '<i class="fa-solid fa-play"></i> Start';
            btn.className = 'btn btn-primary';
            isScanning = false;
            document.getElementById('reader').innerHTML = '';
        });
        return;
    }
    html5QrCode = new Html5Qrcode("reader");
    badge.textContent = 'Scanning...';
    badge.style.background = '#28a745';
    btn.innerHTML = '<i class="fa-solid fa-stop"></i> Cancel';
    btn.className = 'btn btn-danger';
    isScanning = true;
    html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, (txt) => { processQR(txt); }, () => {});
}

// ===== OPTION 2: Check if may klase ngayon =====
function getTodaySchedule() {
    const schedules = JSON.parse(localStorage.getItem('bscs_schedules') || '[]');
    const now = new Date();
    const dayShort = now.toLocaleDateString('en-US', { weekday: 'short' });
    const fullDay = now.toLocaleDateString('en-US', { weekday: 'long' });

    return schedules.find(sc => {
        if (sc.days && sc.days.includes(dayShort)) return true;
        if (fullDay === 'Tuesday' && sc.name && sc.name.toLowerCase().includes('tuesday')) return true;
        if (fullDay === 'Thursday' && sc.name && sc.name.toLowerCase().includes('thursday')) return true;
        if (sc.name && sc.name.toLowerCase().includes(dayShort.toLowerCase())) return true;
        return false;
    }) || null;
}

function processQR(qrText) {
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    const attendance = JSON.parse(localStorage.getItem('bscs_attendance') || '[]');

    let id = qrText.split('|')[0] || qrText;
    let student = students.find(s => s.id === id || s.qr === qrText || qrText.includes(s.id));

    if (!student) {
        document.getElementById('confirmationBox').innerHTML = `
            <div style="text-align:center;padding:15px">
                <div style="width:60px;height:60px;background:#dc3545;color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;margin:0 auto 10px auto;font-size:28px">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <h3 style="color:#dc3545">Not Found!</h3>
                <p style="font-size:13px">QR: <b>${qrText}</b><br>Not registered in BSCS Students</p>
            </div>`;
        return;
    }

    const today = new Date().toDateString();
    const already = attendance.find(a => a.id === student.id && new Date(a.time).toDateString() === today);
    let type = already? 'Time Out' : 'Time In';

    // ===== OPTION 2 LOGIC =====
    let todaySched = getTodaySchedule();
    let status;
    let remarksText = '';
    const nowCheck = new Date();
    const fullDayName = nowCheck.toLocaleDateString('en-US', { weekday: 'long' });

    if (!todaySched) {
        status = 'Present';
        remarksText = `No Class - ${fullDayName} (Outside Schedule)`;
    } else {
        let timePart = todaySched.hours || todaySched.time || '02:00 PM - 04:00 PM';
        let startStr = timePart.split('-')[0].trim();
        let lateAfter = parseInt(todaySched.lateAfter || '15');
        let startDate = new Date(nowCheck.toDateString() + ' ' + startStr);
        let lateLimit = new Date(startDate.getTime() + lateAfter * 60000);

        if (nowCheck > lateLimit) {
            status = 'Late';
            remarksText = `${todaySched.name} - Late ${Math.round((nowCheck - startDate)/60000)} min`;
        } else {
            status = 'Present';
            remarksText = `${todaySched.name} - On Time`;
        }
    }

    // Save
    attendance.push({
        id: student.id,
        student_id: student.id,
        qr_id: student.id,
        name: student.fullName,
        category: student.category,
        department: student.department,
        time: new Date().toISOString(),
        date: new Date().toISOString().split('T')[0],
        timeIn: new Date().toLocaleTimeString(),
        type: type,
        status: status,
        remarks: remarksText
    });
    localStorage.setItem('bscs_attendance', JSON.stringify(attendance));

    // Confirmation
    let isNoClass = remarksText.includes('No Class');
    document.getElementById('confirmationBox').innerHTML = `
        <div style="text-align:center;padding:15px">
            <div style="width:60px;height:60px;background:${isNoClass?'#6c757d':'#28a745'};color:white;border-radius:50%;display:flex;justify-content:center;align-items:center;margin:0 auto 10px auto;font-size:28px">
                <i class="fa-solid fa-${isNoClass?'calendar-xmark':'check'}"></i>
            </div>
            <h3 style="color:${isNoClass?'#6c757d':'#28a745'}">${student.fullName}</h3>
            <p style="font-size:13px;margin:5px 0">${student.id} | ${student.department} | ${student.category}</p>
            <div style="background:#f4f6f9;padding:8px;border-radius:4px;margin-top:10px">
                <b>${type}</b> - ${new Date().toLocaleTimeString()}<br>
                <span style="background:${isNoClass?'#6c757d':status==='Late'?'#ffc107':'#28a745'};color:${status==='Late'&&!isNoClass?'#333':'white'};padding:2px 6px;border-radius:3px;font-size:11px">${status}</span><br>
                <small style="color:${isNoClass?'#dc3545':'#666'};font-weight:${isNoClass?'bold':'normal'}">${remarksText}</small>
            </div>
        </div>`;

    // Recent
    const recent = document.getElementById('recentScans');
    if (recent.textContent.includes('No scans')) recent.innerHTML = '';
    recent.innerHTML = `
        <div style="padding:8px;border-bottom:1px solid #eee;display:flex;justify-content:space-between">
            <span><b>${student.fullName}</b> (${student.id})<br>
            <small>${type} - ${new Date().toLocaleTimeString()}<br><small style="color:${isNoClass?'red':'#888'}">${remarksText}</small></small></span>
            <span style="background:${isNoClass?'#6c757d':'#28a745'};color:white;padding:2px 6px;border-radius:3px;font-size:11px;height:fit-content">${status}</span>
        </div>` + recent.innerHTML;
}

function submitManual() {
    const v = document.getElementById('manualInput').value.trim();
    if (!v) return;
    processQR(v);
    document.getElementById('manualInput').value = '';
}

function loadRecent() {
    const attendance = JSON.parse(localStorage.getItem('bscs_attendance') || '[]');
    const today = new Date().toDateString();
    const todayAtt = attendance.filter(a => new Date(a.time).toDateString() === today).reverse();
    const recent = document.getElementById('recentScans');
    if (todayAtt.length > 0) {
        recent.innerHTML = todayAtt.slice(0, 10).map(a => `
            <div style="padding:8px;border-bottom:1px solid #eee;display:flex;justify-content:space-between">
                <span><b>${a.name}</b> (${a.id})<br>
                <small>${a.type} - ${new Date(a.time).toLocaleTimeString()}<br>
                <small style="color:${a.remarks&&a.remarks.includes('No Class')?'red':'#888'}">${a.remarks||''}</small></small></span>
                <span style="background:${a.remarks&&a.remarks.includes('No Class')?'#6c757d':'#28a745'};color:white;padding:2px 6px;border-radius:3px;font-size:11px;height:fit-content">${a.status}</span>
            </div>`).join('');
    }
}
loadRecent();
</script>
</body>
</html>