<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
       .filter-box { background: white; border-radius: 5px; border: 1px solid #e9ecef; padding: 15px 15px 5px 15px; margin-bottom: 15px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
       .filter-row { display: grid; grid-template-columns: 1.2fr 0.8fr 0.8fr 0.8fr auto; gap: 12px; margin-bottom: 12px; align-items: end; }
       .filter-row-2 { display: grid; grid-template-columns: 0.6fr 0.6fr 2fr; gap: 12px; margin-bottom: 15px; align-items: end; }
       .form-group label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px; color: #444; }
       .form-control { width: 100%; padding: 7px 10px; border: 1px solid #d2d6de; border-radius: 3px; font-size: 13px; height: 34px; }
       .btn { padding: 7px 14px; border: none; border-radius: 3px; font-size: 13px; cursor: pointer; }
       .btn-primary { background: #007bff; color: white; }
       .btn-default { background: #f4f4f4; border: 1px solid #ddd; color: #444; }
       .btn-success { background: #28a745; color: white; }
       .btn-sm { padding: 5px 10px; font-size: 12px; }
       .table-box { background: white; border-radius: 5px; border: 1px solid #e9ecef; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
       .table-header { padding: 12px 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 10px 12px; text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee; color: #444; font-size: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <!-- SIDEBAR KONEKTADO LAHAT -->
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
            <li class="active"><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
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
            <div style="display:flex;gap:20px;font-size:14px;color:#555">
                <span><i class="fa-solid fa-bars"></i></span>
                <span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555">
                <i class="fa-solid fa-bell"></i>
                <span><i class="fa-solid fa-user"></i></span>
            </div>
        </div>

        <div class="content">
            <div class="header">
                <h2>Attendance Logs</h2>
                <div style="font-size:13px;color:#777">
                    <a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / Attendance Logs
                </div>
            </div>

            <div class="filter-box">
                <div class="filter-row">
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Name, ID, or QR token" onkeyup="renderLogs()">
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" id="fromDate" class="form-control" onchange="renderLogs()">
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" id="toDate" class="form-control" onchange="renderLogs()">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="statusFilter" onchange="renderLogs()">
                            <option>All statuses</option>
                            <option>Present</option>
                            <option>Late</option>
                            <option>No Class</option>
                        </select>
                    </div>
                    <div style="display:flex;gap:5px">
                        <button class="btn btn-primary" onclick="renderLogs()"><i class="fa-solid fa-filter"></i> Filter</button>
                        <button class="btn btn-default" onclick="resetFilter()">Reset</button>
                    </div>
                </div>
                <div class="filter-row-2">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="catFilter" onchange="renderLogs()">
                            <option>All</option>
                            <option>Regular</option>
                            <option>Irregular</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department / Group</label>
                        <select class="form-control" id="sectionSelect" onchange="renderLogs()">
                            <option>All</option>
                            <option>BSCS 1A</option>
                            <option>BSCS 1B</option>
                            <option>BSCS 2A</option>
                            <option>BSCS 2B</option>
                            <option>BSCS 3A</option>
                            <option>BSCS 3B</option>
                            <option>BSCS 4A</option>
                            <option>BSCS 4B</option>
                        </select>
                    </div>
                    <div></div>
                </div>
            </div>

            <div class="table-box">
                <div class="table-header">
                    <div style="font-size:14px">
                        Attendance Records
                        <span id="countBadge" style="background:#007bff;color:white;padding:2px 6px;border-radius:3px;font-size:11px">0</span>
                    </div>
                    <div style="display:flex;gap:5px">
                        <button class="btn btn-success btn-sm" onclick="location.href='scanner.php'">
                            <i class="fa-solid fa-qrcode"></i> Scan QR
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="alert('Add manual attendance - same as students.php')">
                            <i class="fa-solid fa-plus"></i> Manual Attendance
                        </button>
                        <button class="btn btn-default btn-sm" onclick="location.href='reports.php'">
                            <i class="fa-solid fa-file-export"></i> Reports
                        </button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>QR / Person ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="logTableBody">
                        <tr>
                            <td colspan="9" style="text-align:center;color:#999;padding:30px">No attendance records found. Scan QR first!</td>
                        </tr>
                    </tbody>
                </table>

                <div style="padding:12px 15px;border-top:1px solid #eee;display:flex;gap:8px;align-items:center">
                    <button onclick="clearLogs()" style="border:1px solid #dc3545;color:#dc3545;background:white;padding:6px 10px;border-radius:3px;font-size:12px;cursor:pointer">
                        <i class="fa-solid fa-trash"></i> Clear All Logs
                    </button>
                    <span style="font-size:11px;color:#999">BSCS Student Logs </span>
                </div>
            </div>
        </div>
    </div>

<script>
function renderLogs() {
    const attendance = JSON.parse(localStorage.getItem('bscs_attendance') || '[]');
    const search = document.getElementById('searchInput').value.toLowerCase();
    const statusF = document.getElementById('statusFilter').value;
    const catF = document.getElementById('catFilter').value;
    const deptF = document.getElementById('sectionSelect').value;
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;

    let filtered = attendance.filter(a => {
        // FIXED: suporta sa luma at bago
        let id = (a.student_id || a.qr_id || a.id || '').toString().toLowerCase();
        let name = (a.name || '').toString().toLowerCase();
        let dept = (a.department || '').toString().toLowerCase();
        let remarks = (a.remarks || a.type || '').toString().toLowerCase();
        let status = a.status || '';

        if (search &&!(`${id} ${name} ${dept} ${remarks}`.includes(search))) return false;

        if (statusF!== 'All statuses') {
            if (statusF === 'No Class' &&!remarks.includes('no class')) return false;
            if (statusF === 'Present' && status!== 'Present') return false;
            if (statusF === 'Late' && status!== 'Late') return false;
        }

        if (catF!== 'All' && (a.category||'')!== catF) return false;
        if (deptF!== 'All' && (a.department||'')!== deptF) return false;

        if (from) {
            let adate = a.date || (a.time? new Date(a.time).toISOString().split('T')[0] : '');
            if (adate < from) return false;
        }
        if (to) {
            let adate = a.date || (a.time? new Date(a.time).toISOString().split('T')[0] : '');
            if (adate > to) return false;
        }
        return true;
    });

    document.getElementById('countBadge').innerText = filtered.length;
    const tbody = document.getElementById('logTableBody');

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;color:#999;padding:30px">No attendance records found. Scan QR in scanner.php first!</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.slice().reverse().map(a => {
        // FIXED: kunin lahat ng possible fields
        let id = a.student_id || a.qr_id || a.id || '-';
        let name = a.name || '-';
        let category = a.category || 'Student';
        let department = a.department || 'BSCS 2B';
        let date = a.date || (a.time? new Date(a.time).toLocaleDateString() : '-');
        let timeIn = a.timeIn || (a.time? new Date(a.time).toLocaleTimeString() : '-');
        let timeOut = a.timeOut || '-';
        let status = a.status || 'Present';
        // DITO YUNG FIX PRE - REMARKS NA TALAGA!
        let remarks = a.remarks || a.type || 'Time In';
        let isNoClass = remarks.toLowerCase().includes('no class');

        let statusBg = isNoClass? '#6c757d' : (status === 'Late'? '#ffc107' : '#28a745');
        let statusColor = status === 'Late' &&!isNoClass? '#333' : 'white';

        return `
            <tr style="${isNoClass? 'background:#f8fafc' : ''}">
                <td><b>${id}</b></td>
                <td>${name}</td>
                <td><span style="background:#eee;padding:2px 6px;border-radius:3px;font-size:11px">${category}</span></td>
                <td><span style="background:#007bff;color:white;padding:2px 6px;border-radius:3px;font-size:11px">${department}</span></td>
                <td>${date}</td>
                <td>${timeIn}</td>
                <td>${timeOut}</td>
                <td><span style="background:${statusBg};color:${statusColor};padding:2px 6px;border-radius:3px;font-size:11px">${status}</span></td>
                <td style="font-size:11px;color:${isNoClass? '#dc3545' : '#555'};font-weight:${isNoClass? 'bold' : 'normal'}">${remarks}</td>
            </tr>
        `;
    }).join('');
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = 'All statuses';
    document.getElementById('catFilter').value = 'All';
    document.getElementById('sectionSelect').value = 'All';
    document.getElementById('fromDate').value = '';
    document.getElementById('toDate').value = '';
    renderLogs();
}

function clearLogs() {
    if (confirm('Clear all attendance logs? Sigurado ka pre?')) {
        localStorage.removeItem('bscs_attendance');
        renderLogs();
    }
}

function loadCategories() {
    const cats = JSON.parse(localStorage.getItem('bscs_categories') || '[]');
    if (cats.length > 0) {
        const sel = document.getElementById('catFilter');
        sel.innerHTML = '<option>All</option>' + cats.map(c => `<option>${c.name}</option>`).join('');
    }
}

loadCategories();
renderLogs();
</script>
</body>
</html>