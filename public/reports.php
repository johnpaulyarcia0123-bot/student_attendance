<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Reports | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Roboto, sans-serif; }
        body { display: flex; background: #f4f6f9; min-height: 100vh; }
      .sidebar { width: 230px; background: #222d32; min-height: 100vh; color: #8aa4af; position: fixed; overflow-y: auto; }
      .sidebar.logo { padding: 15px; color: white; font-size: 18px; border-bottom: 1px solid #2c3b41; }
      .sidebar.profile { padding: 12px 15px; display: flex; gap: 10px; align-items: center; border-bottom: 1px solid #2c3b41; }
      .sidebar ul { list-style: none; padding-bottom: 20px; }
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
      .stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 15px; }
      .stat { background: white; border-radius: 5px; border: 1px solid #e9ecef; display: flex; align-items: center; gap: 12px; padding: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
      .stat-icon { width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; border-radius: 4px; color: white; font-size: 20px; }
      .stat b { font-size: 16px; display: block; }
      .filter-box { background: white; border-radius: 5px; border: 1px solid #e9ecef; padding: 15px; margin-bottom: 15px; }
      .filter-row { display: grid; grid-template-columns: 0.8fr 0.7fr 0.7fr 1fr 0.7fr; gap: 12px; margin-bottom: 12px; align-items: end; }
      .filter-row-2 { display: grid; grid-template-columns: 0.8fr 0.8fr 1fr auto auto; gap: 12px; align-items: end; }
      .form-group label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px; color: #444; }
      .form-control { width: 100%; padding: 7px 10px; border: 1px solid #d2d6de; border-radius: 3px; font-size: 13px; height: 34px; }
      .btn { padding: 7px 14px; border: none; border-radius: 3px; font-size: 13px; cursor: pointer; }
      .btn-primary { background: #007bff; color: white; }
      .btn-default { background: #f4f4f4; border: 1px solid #ddd; color: #444; }
      .export-row { display: flex; gap: 6px; margin-top: 15px; background: #f9f9f9; padding: 10px; border-radius: 4px; }
      .btn-pdf { background: #dc3545; color: white; }
      .btn-excel { background: #28a745; color: white; }
      .btn-csv { background: #17a2b8; color: white; }
      .btn-print { background: #6c757d; color: white; }
      .table-box { background: white; border-radius: 5px; border: 1px solid #e9ecef; }
      .table-head { padding: 12px 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 10px 12px; text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee; font-size: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div>
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
            <li class="active"><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
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
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i> <span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header">
                <h2>Attendance Reports</h2>
                <div style="font-size:13px;color:#777"><a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / Attendance Reports</div>
            </div>

            <div class="stats">
                <div class="stat"><div class="stat-icon" style="background:#00a8c5"><i class="fa-solid fa-list"></i></div><div><small>Records</small><b id="statRecords">0</b></div></div>
                <div class="stat"><div class="stat-icon" style="background:#28a745"><i class="fa-solid fa-check"></i></div><div><small>Present</small><b id="statPresent">0</b></div></div>
                <div class="stat"><div class="stat-icon" style="background:#ffc107;color:#333"><i class="fa-solid fa-clock"></i></div><div><small>Late</small><b id="statLate">0</b></div></div>
                <div class="stat"><div class="stat-icon" style="background:#6c757d"><i class="fa-solid fa-calendar-xmark"></i></div><div><small>No Class</small><b id="statNoClass">0</b></div></div>
                <div class="stat"><div class="stat-icon" style="background:#007bff"><i class="fa-solid fa-users"></i></div><div><small>BSCS Students</small><b id="statStudents">0</b></div></div>
            </div>

            <div class="filter-box">
                <div style="font-size:14px;font-weight:600;margin-bottom:12px;border-bottom:1px solid #eee;padding-bottom:10px">Report Filters - BSCS Only</div>
                <div class="filter-row">
                    <div class="form-group"><label>Report Type</label><select class="form-control" id="reportType"><option>Daily</option><option>Weekly</option><option>Monthly</option></select></div>
                    <div class="form-group"><label>From</label><input type="date" id="fromDate" class="form-control"></div>
                    <div class="form-group"><label>To</label><input type="date" id="toDate" class="form-control"></div>
                    <div class="form-group"><label>Person</label><select class="form-control" id="personFilter"><option>All students</option></select></div>
                    <div class="form-group"><label>Status</label><select class="form-control" id="statusFilter"><option>All statuses</option><option>Present</option><option>Late</option><option>No Class</option></select></div>
                </div>
                <div class="filter-row-2">
                    <div class="form-group"><label>Category</label><select class="form-control" id="catFilter"><option>All categories</option><option>Regular</option><option>Irregular</option></select></div>
                    <div class="form-group"><label>Department / Group</label><select class="form-control" id="deptFilter"><option>All departments</option><option>BSCS 1A</option><option>BSCS 1B</option><option>BSCS 2A</option><option>BSCS 2B</option><option>BSCS 3A</option><option>BSCS 3B</option><option>BSCS 4A</option><option>BSCS 4B</option></select></div>
                    <div class="form-group"><label>Search</label><input type="text" id="searchInput" class="form-control" placeholder="Name or Person ID"></div>
                    <div style="display:flex;gap:5px;align-items:end">
                        <button class="btn btn-primary" onclick="generateReport()"><i class="fa-solid fa-chart-bar"></i> Generate</button>
                        <button class="btn btn-default" onclick="resetFilters()">Reset</button>
                    </div>
                    <div style="display:flex;align-items:end"><label style="font-size:11px;display:flex;gap:4px;align-items:center;background:#fff3cd;padding:6px 8px;border-radius:3px;border:1px solid #ffc107"><input type="checkbox" id="hideNoClass" onchange="generateReport()"> Hide No Class<br>For Sir Export</label></div>
                </div>

                <div class="export-row">
                    <button class="btn btn-pdf btn-sm" onclick="exportPDF()"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                    <button class="btn btn-excel btn-sm" onclick="exportExcel()"><i class="fa-solid fa-file-excel"></i> Excel</button>
                    <button class="btn btn-csv btn-sm" onclick="exportCSV()"><i class="fa-solid fa-file-csv"></i> CSV</button>
                    <button class="btn btn-print btn-sm" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
                    <span style="font-size:11px;color:#888;margin-left:10px" id="exportNote">Check "Hide No Class" para malinis export kay Sir</span>
                </div>
            </div>

            <div class="table-box">
                <div class="table-head"><span>Report Results - <b id="resultCount">0 records</b></span><span style="font-size:11px;color:#888" id="dateRange">BSCS Attendance Report</span></div>
                <table id="reportTable">
                    <thead><tr><th>Person ID</th><th>Name</th><th>Category</th><th>Department</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Status</th><th>Remarks</th></tr></thead>
                    <tbody id="reportBody"><tr><td colspan="9" style="text-align:center;color:#999;padding:30px">Click Generate to view BSCS attendance report.</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>

<script>
let currentData = [];
function generateReport() {
    const attendance = JSON.parse(localStorage.getItem('bscs_attendance') || '[]');
    const students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const statusF = document.getElementById('statusFilter').value;
    const catF = document.getElementById('catFilter').value;
    const deptF = document.getElementById('deptFilter').value;
    const hideNoClass = document.getElementById('hideNoClass').checked;

    let filtered = attendance.filter(a => {
        let id = (a.student_id||a.qr_id||a.id||'').toString().toLowerCase();
        let name = (a.name||'').toString().toLowerCase();
        let dept = (a.department||'').toString().toLowerCase();
        let remarks = (a.remarks||a.type||'').toString().toLowerCase();
        let isNoClass = remarks.includes('no class');

        if(hideNoClass && isNoClass) return false;
        if(search &&!`${id} ${name} ${dept} ${remarks}`.includes(search)) return false;

        if(statusF!== 'All statuses'){
            if(statusF==='No Class' &&!isNoClass) return false;
            if(statusF==='Present' && (a.status!=='Present' || isNoClass)) return false;
            if(statusF==='Late' && a.status!=='Late') return false;
        }
        if(catF!== 'All categories' && (a.category||'')!== catF) return false;
        if(deptF!== 'All departments' && (a.department||'')!== deptF) return false;

        let adate = a.date || (a.time? new Date(a.time).toISOString().split('T')[0] : '');
        if(from && adate < from) return false;
        if(to && adate > to) return false;
        return true;
    });

    currentData = filtered;

    // STATS - FIXED PARA SA OPTION 2
    let realPresent = attendance.filter(a=> a.status==='Present' &&! (a.remarks||'').toLowerCase().includes('no class')).length;
    let realLate = attendance.filter(a=> a.status==='Late').length;
    let noClassCount = attendance.filter(a=> (a.remarks||'').toLowerCase().includes('no class')).length;

    document.getElementById('statRecords').innerText = filtered.length;
    document.getElementById('statPresent').innerText = realPresent;
    document.getElementById('statLate').innerText = realLate;
    document.getElementById('statNoClass').innerText = noClassCount;
    document.getElementById('statStudents').innerText = students.length;

    document.getElementById('resultCount').innerText = filtered.length + ' records' + (hideNoClass? ' (No Class hidden)' : '');
    document.getElementById('dateRange').innerText = hideNoClass? 'For Sir Export - Official Class Only' : 'BSCS Report - Including No Class logs';

    const tbody = document.getElementById('reportBody');
    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;color:#999;padding:30px">${hideNoClass? 'No records after hiding No Class - Uncheck to see Saturday logs' : 'No records matched the report filters.'}</td></tr>`;
        return;
    }

    tbody.innerHTML = filtered.slice().reverse().map(a => {
        let id = a.student_id||a.qr_id||a.id||'-';
        let name = a.name||'-';
        let cat = a.category||'Student';
        let dept = a.department||'BSCS 2B';
        let date = a.date || (a.time? new Date(a.time).toLocaleDateString() : '-');
        let timeIn = a.timeIn || (a.time? new Date(a.time).toLocaleTimeString() : '-');
        let timeOut = a.timeOut||'-';
        let status = a.status||'Present';
        let remarks = a.remarks || a.type || 'Time In'; // FIXED DITO PRE!
        let isNoClass = remarks.toLowerCase().includes('no class');

        let bg = isNoClass? '#6c757d' : (status==='Late'? '#ffc107' : '#28a745');
        let col = status==='Late'&&!isNoClass? '#333':'white';

        return `<tr style="${isNoClass? 'background:#f8fafc':''}">
            <td><b>${id}</b></td>
            <td>${name}</td>
            <td><span style="background:#eee;padding:2px 6px;border-radius:3px;font-size:11px">${cat}</span></td>
            <td><span style="background:#007bff;color:white;padding:2px 6px;border-radius:3px;font-size:11px">${dept}</span></td>
            <td>${date}</td>
            <td>${timeIn}</td>
            <td>${timeOut}</td>
            <td><span style="background:${bg};color:${col};padding:2px 6px;border-radius:3px;font-size:11px">${isNoClass? 'Present':status}</span></td>
            <td style="font-size:11px;color:${isNoClass? '#dc3545':'#555'};font-weight:${isNoClass? 'bold':'normal'}">${remarks}</td>
        </tr>`;
    }).join('');
}

function resetFilters() {
    document.getElementById('fromDate').value = '';
    document.getElementById('toDate').value = '';
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = 'All statuses';
    document.getElementById('catFilter').value = 'All categories';
    document.getElementById('deptFilter').value = 'All departments';
    document.getElementById('hideNoClass').checked = false;
    generateReport();
}

function exportCSV() {
    if (currentData.length === 0) { alert('Generate report first!'); return; }
    let csv = 'Person ID,Name,Category,Department,Date,Time In,Time Out,Status,Remarks\n';
    currentData.forEach(a => {
        csv += `"${a.student_id||a.qr_id||a.id}","${a.name}","${a.category||''}","${a.department||''}","${a.date||''}","${a.timeIn||''}","${a.timeOut||''}","${a.status||''}","${a.remarks||a.type||''}"\n`;
    });
    const blob = new Blob([csv], {type:'text/csv'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'BSCS_Attendance_Report_'+new Date().toISOString().split('T')[0]+'.csv';
    a.click();
}

function exportExcel(){ exportCSV(); }
function exportPDF(){ window.print(); }

window.onload = () => {
    let students = JSON.parse(localStorage.getItem('bscs_students')||'[]');
    let sel = document.getElementById('personFilter');
    sel.innerHTML = '<option>All students</option>' + students.map(s=>`<option value="${s.id}">${s.fullName||s.name} (${s.id})</option>`).join('');
    generateReport();
};
</script>
</body>
</html>