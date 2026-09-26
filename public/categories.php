<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | QR A S</title>
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
       .cat-grid { display: grid; grid-template-columns: 350px 1fr; gap: 20px; align-items: start; }
       .card { background: white; border-radius: 5px; border: 1px solid #e9ecef; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; }
       .card-head { padding: 12px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: 600; background: #fff; border-top: 3px solid #007bff; }
       .card-body { padding: 15px; }
       .form-group label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 6px; color: #333; }
       .form-control { width: 100%; padding: 8px 10px; border: 1px solid #d2d6de; border-radius: 3px; font-size: 13px; }
       .btn { padding: 8px 14px; border: none; border-radius: 3px; font-size: 13px; cursor: pointer; }
       .btn-primary { background: #007bff; color: white; }
       .btn-default { background: transparent; color: #333; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { padding: 10px 12px; text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee; color: #444; font-size: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; }
       .badge-active { background: #00a65a; color: white; padding: 2px 7px; border-radius: 3px; font-size: 11px; }
       .action-btn { width: 22px; height: 22px; display: inline-flex; justify-content: center; align-items: center; border-radius: 3px; color: white; font-size: 11px; margin-right: 2px; cursor: pointer; }
        textarea.form-control { height: 90px; resize: vertical; }
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
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li class="active"><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
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
                <span onclick="location.href='scanner.php'" style="cursor:pointer"><i class="fa-solid fa-table-cells"></i> Scanner</span>
                <span><i class="fa-solid fa-desktop"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i> <span><i class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header">
                <h2>Categories</h2>
                <div style="font-size:13px;color:#777"><a href="dashboard.php" style="color:#007bff;text-decoration:none">Home</a> / Categories</div>
            </div>

            <div class="cat-grid">
                <div class="card">
                    <div class="card-head">Add Category - BSCS Students Only</div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom:15px">
                            <label>Category Name <span style="color:red">*</span></label>
                            <input type="text" id="catName" class="form-control" placeholder="e.g., Regular or Irregular">
                        </div>
                        <div class="form-group" style="margin-bottom:15px">
                            <label>Description</label>
                            <textarea id="catDesc" class="form-control" placeholder="BSCS Student category"></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom:15px">
                            <label>Status</label>
                            <select id="catStatus" class="form-control">
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                        <div style="background:#f9f9f9;padding:10px 15px;margin:0 -15px -15px -15px;border-top:1px solid #eee;display:flex;gap:10px">
                            <button class="btn btn-primary" onclick="saveCategory()" id="saveBtn">Save Category</button>
                            <button class="btn btn-default" onclick="clearForm()">Clear</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff;background:#fff">BSCS Student Categories</div>
                    <div style="padding:0">
                        <table>
                            <thead><tr><th>Name</th><th>Description</th><th>People</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody id="catTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="display:flex;justify-content:space-between;margin-top:30px;font-size:12px;color:#888">
                <span></span><span></span>
            </div>
        </div>
    </div>

    <script>
        let categories = JSON.parse(localStorage.getItem('bscs_categories') || JSON.stringify([
            {name:'Regular', desc:'BSCS Regular Students - full load', status:'Active'},
            {name:'Irregular', desc:'BSCS Irregular Students - with backlog', status:'Active'}
        ]));
        let editIndex = -1;

        function saveCategory(){
            const name = document.getElementById('catName').value.trim();
            const desc = document.getElementById('catDesc').value.trim();
            const status = document.getElementById('catStatus').value;
            if(!name){ alert('Category Name required!'); return; }
            if(editIndex>=0){
                categories[editIndex] = {name, desc, status};
                editIndex=-1;
                document.getElementById('saveBtn').innerText='Save Category';
            } else {
                categories.push({name, desc, status});
            }
            localStorage.setItem('bscs_categories', JSON.stringify(categories));
            clearForm();
            renderCategories();
        }

        function clearForm(){
            document.getElementById('catName').value='';
            document.getElementById('catDesc').value='';
            document.getElementById('catStatus').value='Active';
            editIndex=-1;
            document.getElementById('saveBtn').innerText='Save Category';
        }

        function editCat(i){
            const c = categories[i];
            document.getElementById('catName').value=c.name;
            document.getElementById('catDesc').value=c.desc;
            document.getElementById('catStatus').value=c.status;
            editIndex=i;
            document.getElementById('saveBtn').innerText='Update Category';
        }

        function deleteCat(i){
            if(confirm('Delete this category?')){
                categories.splice(i,1);
                localStorage.setItem('bscs_categories', JSON.stringify(categories));
                renderCategories();
            }
        }

        function renderCategories(){
            const students = JSON.parse(localStorage.getItem('bscs_students')||'[]');
            const tbody = document.getElementById('catTableBody');
            tbody.innerHTML = categories.map((c,i)=>{
                const count = students.filter(s=>s.category===c.name).length;
                return `<tr>
                    <td><b>${c.name}</b></td>
                    <td style="color:#666">${c.desc||'-'}</td>
                    <td><span style="background:#f4f4f4;padding:2px 6px;border-radius:10px">${count}</span></td>
                    <td><span class="badge-active">${c.status}</span></td>
                    <td>
                        <span class="action-btn" style="background:#f39c12" onclick="editCat(${i})"><i class="fa-solid fa-pen"></i></span>
                        <span class="action-btn" style="background:#dd4b39" onclick="deleteCat(${i})"><i class="fa-solid fa-trash"></i></span>
                    </td>
                </tr>`;
            }).join('');
        }

        renderCategories();
    </script>
</body>
</html>