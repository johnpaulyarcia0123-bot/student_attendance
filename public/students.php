<!DOCTYPE html><?php
session_start();
if(!isset($_SESSION['bscs_admin'])){
    header("Location: index.php");
    exit;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
       .header { display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center; }
       .header h2 { font-size: 24px; font-weight: 400; }
       .card { background: white; border-radius: 5px; border: 1px solid #e9ecef; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px; }
       .card-head { padding: 12px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: 600; border-top: 3px solid #007bff; display: flex; justify-content: space-between; align-items: center; }
       .card-body { padding: 15px; }
       .form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px; }
       .form-group label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 6px; color: #333; }
       .form-control { width: 100%; padding: 8px 10px; border: 1px solid #d2d6de; border-radius: 3px; font-size: 13px; height: 34px; }
       .btn { padding: 8px 14px; border: none; border-radius: 3px; font-size: 13px; cursor: pointer; }
       .btn-primary { background: #007bff; color: white; }
       .btn-success { background: #28a745; color: white; }
       .btn-default { background: #f4f4f4; border: 1px solid #ddd; color: #444; }
       .filter-bar { display: flex; gap: 10px; margin-bottom: 15px; align-items: end; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 10px 12px; text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee; color: #444; font-size: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
       .badge { padding: 2px 6px; border-radius: 10px; font-size: 11px; color: white; }
       .action-btn { width: 26px; height: 26px; display: inline-flex; justify-content: center; align-items: center; border-radius: 3px; color: white; font-size: 12px; margin-right: 3px; cursor: pointer; }
        /* Modal */
       .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 999; }
       .modal.active { display: flex; }
       .modal-box { background: white; border-radius: 5px; padding: 20px; width: 350px; text-align: center; }
    </style>
</head>
<body>

    <!-- SIDEBAR - SAME SA LAHAT - KONEKTADO -->
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center"><i class="fa-solid fa-user"></i></div>
            <div><div style="color:white;font-size:13px">Yarcia John Paul</div><div style="font-size:11px">Super Administrator</div></div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li class="active"><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments / Groups</a></li>
            <li><i class="fa-solid fa-calendar"></i> Schedules</li>
            <li><i class="fa-solid fa-umbrella-beach"></i> Holidays</li>
            <li><i class="fa-solid fa-bullhorn"></i> Announcements</li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555">
                <span><i class="fa-solid fa-bars"></i></span>
                <span>BSCS Students Only</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i> <span>Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header">
                <h2>BSCS Students Management</h2>
                <div style="display:flex;gap:8px">
                    <span style="background:#007bff;color:white;padding:5px 10px;border-radius:3px;font-size:12px"><span id="totalCount">0</span> Students</span>
                    <button class="btn btn-success" onclick="document.getElementById('formCard').scrollIntoView({behavior:'smooth'})"><i class="fa-solid fa-plus"></i> Add Student</button>
                </div>
            </div>

            <!-- ADD FORM -->
            <div class="card" id="formCard">
                <div class="card-head">
                    <span id="formTitle">Add BSCS Student</span>
                    <span style="font-size:11px;color:#888">QR Auto Generated: BSCS001|Name|token</span>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Student ID * <small style="color:#888">e.g., BSCS001</small></label>
                            <input type="text" id="studId" class="form-control" placeholder="BSCS001">
                        </div>
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" id="studName" class="form-control" placeholder="Juan Dela Cruz">
                        </div>
                        <div class="form-group">
                            <label>Category *</label>
                            <select id="studCat" class="form-control">
                                <option>Regular</option>
                                <option>Irregular</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Department / Section *</label>
                            <select id="studDept" class="form-control">
                                <option>BSCS 1A</option><option>BSCS 1B</option>
                                <option>BSCS 2A</option><option>BSCS 2B</option>
                                <option>BSCS 3A</option><option>BSCS 3B</option>
                                <option>BSCS 4A</option><option>BSCS 4B</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email (Optional)</label>
                            <input type="text" id="studEmail" class="form-control" placeholder="student@email.com">
                        </div>
                        <div class="form-group" style="display:flex;align-items:end;gap:8px">
                            <button class="btn btn-primary" id="saveBtn" onclick="saveStudent()" style="flex:1">Save Student</button>
                            <button class="btn btn-default" onclick="clearForm()">Clear</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER + TABLE -->
            <div class="card">
                <div class="card-head">
                    <span>BSCS Student List</span>
                    <div class="filter-bar">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search ID or Name" style="width:200px" onkeyup="renderStudents()">
                        <select id="filterDept" class="form-control" style="width:130px" onchange="renderStudents()">
                            <option>All Sections</option>
                            <option>BSCS 1A</option><option>BSCS 1B</option><option>BSCS 2A</option><option>BSCS 2B</option>
                            <option>BSCS 3A</option><option>BSCS 3B</option><option>BSCS 4A</option><option>BSCS 4B</option>
                        </select>
                        <select id="filterCat" class="form-control" style="width:120px" onchange="renderStudents()">
                            <option>All Category</option><option>Regular</option><option>Irregular</option>
                        </select>
                    </div>
                </div>
                <div style="padding:0">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th><th>Name</th><th>Category</th><th>Section</th><th>QR Code</th><th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studTableBody">
                            <tr><td colspan="6" style="text-align:center;padding:30px;color:#999">No BSCS students yet. Add now!</td></tr>
                        </tbody>
                    </table>
                </div>
                <div style="padding:12px 15px;border-top:1px solid #eee;display:flex;gap:8px">
                    <button class="btn btn-default" style="font-size:12px" onclick="exportStudents()">Export CSV</button>
                    <button class="btn" style="font-size:12px;background:#dc3545;color:white" onclick="clearAllStudents()">Clear All Students</button>
                    <span style="font-size:11px;color:#888;margin-left:auto">Konektado sa scanner.php, dashboard.php, attendance_logs.php</span>
                </div>
            </div>
        </div>
    </div>

    <!-- QR MODAL -->
    <div class="modal" id="qrModal">
        <div class="modal-box">
            <h3 id="qrName" style="margin-bottom:10px"></h3>
            <p id="qrId" style="font-size:13px;color:#666;margin-bottom:15px"></p>
            <div id="qrCode" style="display:flex;justify-content:center;margin-bottom:15px"></div>
            <p style="font-size:11px;color:#888;margin-bottom:15px" id="qrText"></p>
            <button class="btn btn-primary" onclick="closeQR()">Close</button>
            <button class="btn btn-default" onclick="printQR()">Print</button>
        </div>
    </div>

    <script>
        let students = JSON.parse(localStorage.getItem('bscs_students') || '[]');
        let editIndex = -1;

        function saveStudent() {
            const id = document.getElementById('studId').value.trim().toUpperCase();
            const fullName = document.getElementById('studName').value.trim();
            const category = document.getElementById('studCat').value;
            const department = document.getElementById('studDept').value;
            const email = document.getElementById('studEmail').value.trim();

            if (!id ||!fullName) { alert('ID and Full Name required!'); return; }

            const token = 'BSCS-' + Math.random().toString(36).substr(2,6).toUpperCase();
            const qr = `${id}|${fullName}|${token}`;

            const data = { id, fullName, category, department, email, qr, token };

            if (editIndex >= 0) {
                // keep old qr if editing
                data.qr = students[editIndex].qr;
                data.token = students[editIndex].token;
                students[editIndex] = data;
                editIndex = -1;
                document.getElementById('formTitle').innerText = 'Add BSCS Student';
                document.getElementById('saveBtn').innerText = 'Save Student';
            } else {
                if (students.find(s=>s.id===id)) { alert('ID already exists!'); return; }
                students.push(data);
            }

            localStorage.setItem('bscs_students', JSON.stringify(students));
            clearForm();
            renderStudents();
        }

        function clearForm() {
            document.getElementById('studId').value = '';
            document.getElementById('studName').value = '';
            document.getElementById('studEmail').value = '';
            document.getElementById('studCat').value = 'Regular';
            document.getElementById('studDept').value = 'BSCS 1A';
            editIndex = -1;
            document.getElementById('formTitle').innerText = 'Add BSCS Student';
            document.getElementById('saveBtn').innerText = 'Save Student';
        }

        function editStudent(i) {
            const s = students[i];
            document.getElementById('studId').value = s.id;
            document.getElementById('studName').value = s.fullName;
            document.getElementById('studCat').value = s.category;
            document.getElementById('studDept').value = s.department;
            document.getElementById('studEmail').value = s.email||'';
            editIndex = i;
            document.getElementById('formTitle').innerText = 'Edit: ' + s.fullName;
            document.getElementById('saveBtn').innerText = 'Update Student';
            document.getElementById('formCard').scrollIntoView({behavior:'smooth'});
        }

        function deleteStudent(i) {
            if (confirm('Delete ' + students[i].fullName + '?')) {
                students.splice(i,1);
                localStorage.setItem('bscs_students', JSON.stringify(students));
                renderStudents();
            }
        }

        function showQR(i) {
            const s = students[i];
            document.getElementById('qrName').innerText = s.fullName;
            document.getElementById('qrId').innerText = s.id + ' | ' + s.department + ' | ' + s.category;
            document.getElementById('qrText').innerText = s.qr;
            document.getElementById('qrCode').innerHTML = '';
            new QRCode(document.getElementById('qrCode'), { text: s.qr, width: 180, height: 180 });
            document.getElementById('qrModal').classList.add('active');
        }

        function closeQR() { document.getElementById('qrModal').classList.remove('active'); }
        function printQR() { window.print(); }

        function renderStudents() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const fDept = document.getElementById('filterDept').value;
            const fCat = document.getElementById('filterCat').value;

            let filtered = students.filter(s => {
                if (search &&!(`${s.id} ${s.fullName}`.toLowerCase().includes(search))) return false;
                if (fDept!== 'All Sections' && s.department!== fDept) return false;
                if (fCat!== 'All Category' && s.category!== fCat) return false;
                return true;
            });

            document.getElementById('totalCount').innerText = students.length;

            const tbody = document.getElementById('studTableBody');
            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:30px;color:#999">No BSCS students found.</td></tr>`;
                return;
            }

            tbody.innerHTML = filtered.map((s, idx) => {
                const realIndex = students.indexOf(s);
                return `<tr>
                    <td><b>${s.id}</b></td>
                    <td>${s.fullName}<br><small style="color:#888">${s.email||''}</small></td>
                    <td><span class="badge" style="background:${s.category==='Regular'?'#007bff':'#ffc107'};color:${s.category==='Regular'?'white':'#333'}">${s.category}</span></td>
                    <td><span class="badge" style="background:#222d32">${s.department}</span></td>
                    <td><button class="btn btn-default" style="font-size:11px;padding:3px 8px" onclick="showQR(${realIndex})"><i class="fa-solid fa-qrcode"></i> View QR</button></td>
                    <td>
                        <span class="action-btn" style="background:#f39c12" onclick="editStudent(${realIndex})"><i class="fa-solid fa-pen"></i></span>
                        <span class="action-btn" style="background:#dd4b39" onclick="deleteStudent(${realIndex})"><i class="fa-solid fa-trash"></i></span>
                    </td>
                </tr>`;
            }).join('');

            // load categories dynamically
            const cats = JSON.parse(localStorage.getItem('bscs_categories') || '[]');
            if (cats.length > 0) {
                const sel = document.getElementById('studCat');
                const filterSel = document.getElementById('filterCat');
                sel.innerHTML = cats.map(c=>`<option>${c.name}</option>`).join('');
                filterSel.innerHTML = '<option>All Category</option>' + cats.map(c=>`<option>${c.name}</option>`).join('');
            }

            const depts = JSON.parse(localStorage.getItem('bscs_departments') || '[]');
            if (depts.length > 0) {
                const sel = document.getElementById('studDept');
                const filterSel = document.getElementById('filterDept');
                sel.innerHTML = depts.map(d=>`<option>${d.name}</option>`).join('');
                filterSel.innerHTML = '<option>All Sections</option>' + depts.map(d=>`<option>${d.name}</option>`).join('');
            }
        }

        function exportStudents() {
            if (students.length === 0) return alert('No students!');
            let csv = 'ID,Full Name,Category,Department,Email,QR\n';
            students.forEach(s=>{ csv += `${s.id},${s.fullName},${s.category},${s.department},${s.email||''},${s.qr}\n`; });
            const blob = new Blob([csv], {type:'text/csv'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href = url; a.download = 'BSCS_Students.csv'; a.click();
        }

        function clearAllStudents() {
            if (confirm('Clear ALL BSCS students? Sigurado ka pre?')) {
                localStorage.removeItem('bscs_students');
                students = [];
                renderStudents();
            }
        }

        renderStudents();
    </script>
</body>
</html>