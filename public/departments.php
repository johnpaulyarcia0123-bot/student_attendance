<?php
session_start();
date_default_timezone_set('Asia/Manila');
include '../includes/db.php';


// AUTO-CREATE TABLE IF NOT EXISTS

$conn->query("CREATE TABLE IF NOT EXISTS departments (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, code VARCHAR(50) NULL, head VARCHAR(100) NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

$cols_q = $conn->query("SHOW COLUMNS FROM departments");
$existing_cols = [];
while ($c = $cols_q->fetch_assoc()) {
    $existing_cols[] = $c['Field'];
}
if (!in_array('code', $existing_cols))
    $conn->query("ALTER TABLE departments ADD COLUMN code VARCHAR(50) NULL");
if (!in_array('head', $existing_cols))
    $conn->query("ALTER TABLE departments ADD COLUMN head VARCHAR(100) NULL");


// SAVE / UPDATE DEPARTMENT

if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $code = $conn->real_escape_string($_POST['code']);
    $head = $conn->real_escape_string($_POST['head']);
    $id = $_POST['edit_id'] ?? '';
    if ($id != "" && is_numeric($id))
        $conn->query("UPDATE departments SET name='$name', code='$code', head='$head' WHERE id='$id'");
    else
        $conn->query("INSERT INTO departments (name, code, head) VALUES ('$name','$code','$head')");
    header("Location: departments.php");
    exit;
}


// DELETE DEPARTMENT

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM departments WHERE id=$id");
    header("Location: departments.php");
    exit;
}

// FETCH FOR EDIT
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_data = $conn->query("SELECT * FROM departments WHERE id=$id")->fetch_assoc();
}


// VIEW DEPARTMENT - SHOW ALL STUDENTS

$view_dept = null;
$view_students = null;
$total_enrolled = 0;
if (isset($_GET['view'])) {
    $view_id = intval($_GET['view']);
    $view_dept = $conn->query("SELECT * FROM departments WHERE id=$view_id")->fetch_assoc();
    if ($view_dept) {
        // SHOW ALL STUDENTS FOR DEMO - IMPORTANT
        $view_students = $conn->query("SELECT * FROM students ORDER BY id DESC");
        $total_enrolled = $view_students ? $view_students->num_rows : 0;
    }
}


// VIEW SINGLE STUDENT DETAILS WITH QR - IMPORTANT

$single_student = null;
if (isset($_GET['student_id'])) {
    $sid = $conn->real_escape_string($_GET['student_id']);
    // Try by student_id or id
    $sq = $conn->query("SELECT * FROM students WHERE student_id='$sid' OR id='$sid' LIMIT 1");
    if ($sq && $sq->num_rows > 0) {
        $single_student = $sq->fetch_assoc();
    }
    // If viewing single student, also keep department view open
    if (isset($_GET['dept_view'])) {
        $view_id = intval($_GET['dept_view']);
        $view_dept = $conn->query("SELECT * FROM departments WHERE id=$view_id")->fetch_assoc();
        $view_students = $conn->query("SELECT * FROM students ORDER BY id DESC");
        $total_enrolled = $view_students ? $view_students->num_rows : 0;
    }
}

$departments = $conn->query("SELECT * FROM departments ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments | Student Attendance System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif
        }

        body {
            display: flex;
            background: #f4f6f9;
            min-height: 100vh
        }

        .sidebar {
            width: 230px;
            background: #1e293b;
            min-height: 100vh;
            color: #94a3b8;
            position: fixed;
            overflow-y: auto
        }

        .logo {
            padding: 15px;
            color: white;
            font-size: 16px;
            border-bottom: 1px solid #334155;
            display: flex;
            gap: 8px;
            align-items: center;
            font-weight: 600
        }

        .profile {
            padding: 12px 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #334155
        }

        .sidebar ul {
            list-style: none;
            padding-bottom: 20px
        }

        .sidebar li {
            padding: 10px 15px;
            font-size: 13px;
            display: flex;
            gap: 10px;
            align-items: center;
            color: #94a3b8
        }

        .sidebar li.active {
            background: #3b82f6;
            color: white;
            border-radius: 5px;
            margin: 5px 8px
        }

        .label {
            padding: 14px 15px 5px 15px;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px
        }

        .sidebar a.link {
            color: inherit;
            text-decoration: none;
            display: flex;
            gap: 10px;
            width: 100%
        }

        .main {
            margin-left: 230px;
            width: calc(100% - 230px)
        }

        .topbar {
            background: white;
            height: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            font-size: 13px;
            color: #666
        }

        .content {
            padding: 20px
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px
        }

        .header h2 {
            font-size: 22px;
            font-weight: 500;
            color: #1e293b
        }

        .grid {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 18px;
            align-items: start
        }

        .card {
            background: white;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 15px
        }

        .card-head {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            background: white;
            border-top: 3px solid #3b82f6;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .card-body {
            padding: 15px
        }

        .form-group {
            margin-bottom: 14px
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #1e293b
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 13px;
            height: 36px
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer
        }

        .btn-primary {
            background: #3b82f6;
            color: white
        }

        .btn-default {
            background: #e2e8f0;
            color: #334155;
            margin-left: 6px;
            text-decoration: none;
            display: inline-block
        }

        .ann-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .ann-item:hover {
            background: #f8fafc
        }

        .ann-item.active {
            background: #eff6ff;
            border-left: 3px solid #3b82f6
        }

        .action-btn {
            padding: 5px 9px;
            border-radius: 4px;
            font-size: 11px;
            text-decoration: none;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-left: 5px;
            cursor: pointer
        }

        .action-view {
            background: #3b82f6
        }

        .action-edit {
            background: #f59e0b
        }

        .action-del {
            background: #ef4444
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .student-table th {
            background: #f8fafc;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase
        }

        .student-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9
        }

        .badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600
        }

        /* STUDENT DETAIL MODAL */
        .detail-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e2e8f0
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px
        }

        .qr-box {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            border: 2px dashed #cbd5e1
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-graduation-cap"></i> SAS</div>
        <div class="profile">
            <div
                style="width:32px;height:32px;background:#334155;border-radius:50%;display:flex;justify-content:center;align-items:center;color:white">
                <i class="fa-solid fa-user" style="font-size:12px"></i></div>
            <div>
                <div style="color:white;font-size:12px;font-weight:600">Yarcia John Paul</div>
                <div style="font-size:10px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li class="active"><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i>
                    Departments / Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="topbar">
            <div>Departments</div>
            <div><i class="fa-regular fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="header">
                <h2>Departments / Groups</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / Departments</div>
            </div>

            <?php if ($single_student):
                $sname = $single_student['name'] ?? $single_student['fullname'] ?? $single_student['full_name'] ?? trim(($single_student['firstname'] ?? '') . ' ' . ($single_student['lastname'] ?? '')) ?: 'Unknown';
                $sid_display = $single_student['student_id'] ?? $single_student['id'];
                $qr_data = $single_student['student_id'] ?? $single_student['id'];
                ?>
                // SINGLE STUDENT DETAIL VIEW - IMPORTANT 
                <div class="card" style="border-top:3px solid #22c55e">
                    <div class="card-head" style="border-top:3px solid #22c55e">
                        <span><i class="fa-solid fa-user"></i> Student Details</span>
                        <a href="departments.php?view=<?php echo intval($_GET['dept_view'] ?? 1); ?>"
                            class="btn btn-default" style="font-size:11px">← Back to List</a>
                    </div>
                    <div class="card-body" style="display:grid; grid-template-columns: 1fr 300px; gap:20px">
                        <div class="detail-box">
                            <div class="detail-row"><span><b>Full
                                        Name:</b></span><span><?php echo htmlspecialchars($sname); ?></span></div>
                            <div class="detail-row"><span><b>Student ID:</b></span><span><span class="badge"
                                        style="font-size:13px"><?php echo htmlspecialchars($sid_display); ?></span></span>
                            </div>
                            <div class="detail-row">
                                <span><b>Email:</b></span><span><?php echo htmlspecialchars($single_student['email'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="detail-row">
                                <span><b>Department:</b></span><span><?php echo htmlspecialchars($view_dept['name'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="detail-row"><span><b>Category /
                                        Section:</b></span><span><?php echo htmlspecialchars($single_student['category'] ?? $single_student['section'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="detail-row"><span><b>Status:</b></span><span
                                    style="background:#dcfce7;color:#166534;padding:3px 8px;border-radius:10px;font-size:11px">Enrolled</span>
                            </div>
                            <div
                                style="margin-top:15px; padding:10px; background:#eff6ff; border-radius:4px; font-size:12px">
                                <b>Note for demo:</b> This QR code contains the Student ID. This will be scanned in QR
                                Scanner page.
                            </div>
                        </div>
                        <div class="qr-box">
                            <div style="font-size:13px; font-weight:600; margin-bottom:10px">QR Code</div>
                            // QR CODE GENERATED FROM STUDENT ID - IMPORTANT 
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($qr_data); ?>"
                                alt="QR Code" style="width:200px; height:200px;">
                            <div style="margin-top:10px; font-size:11px; color:#64748b">
                                <?php echo htmlspecialchars($qr_data); ?></div>
                            <div style="margin-top:15px">
                                <a href="javascript:window.print()" class="btn btn-primary" style="width:100%"><i
                                        class="fa-solid fa-print"></i> Print QR</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid">
                <div class="card">
                    <div class="card-head">New Department</div>
                    <div class="card-body">
                        <form method="POST"><input type="hidden" name="edit_id"
                                value="<?php echo $edit_data['id'] ?? ''; ?>">
                            <div class="form-group"><label>Department Name *</label><input type="text" name="name"
                                    class="form-control" value="<?php echo $edit_data['name'] ?? ''; ?>" required></div>
                            <div class="form-group"><label>Code</label><input type="text" name="code"
                                    class="form-control" value="<?php echo $edit_data['code'] ?? ''; ?>"
                                    placeholder="e.g. CCS"></div>
                            <div class="form-group"><label>Department Head</label><input type="text" name="head"
                                    class="form-control" value="<?php echo $edit_data['head'] ?? ''; ?>"></div>
                            <div style="margin-top:15px"><button class="btn btn-primary"
                                    name="save"><?php echo $edit_data ? 'Update Department' : 'Save Department'; ?></button><a
                                    href="departments.php" class="btn btn-default">Clear</a></div>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-head">Departments List</div>
                        <div>
                            <?php if ($departments->num_rows == 0) {
                                echo '<div style="padding:25px;color:#94a3b8">No departments.</div>';
                            }
                            while ($d = $departments->fetch_assoc()) {
                                $isActive = (isset($_GET['view']) && $_GET['view'] == $d['id']) ? 'active' : ''; ?>
                                <div class="ann-item <?php echo $isActive; ?>">
                                    <div style="cursor:pointer"
                                        onclick="location.href='departments.php?view=<?php echo $d['id']; ?>'"><b
                                            style="font-size:13px"><?php echo htmlspecialchars($d['name']); ?>
                                            (<?php echo htmlspecialchars($d['code']); ?>)</b>
                                        <div style="font-size:11px;color:#64748b">Head:
                                            <?php echo htmlspecialchars($d['head']); ?></div>
                                    </div>
                                    <div><a class="action-btn action-view"
                                            href="departments.php?view=<?php echo $d['id']; ?>"><i
                                                class="fa-solid fa-eye"></i> View</a><a class="action-btn action-edit"
                                            href="departments.php?edit=<?php echo $d['id']; ?>"><i
                                                class="fa-solid fa-pen"></i> Edit</a><a class="action-btn action-del"
                                            href="departments.php?delete=<?php echo $d['id']; ?>"
                                            onclick="return confirm('Delete <?php echo addslashes($d['name']); ?>?')"><i
                                                class="fa-solid fa-trash"></i> Delete</a></div>
                                </div><?php } ?>
                        </div>
                    </div>

                    <?php if ($view_dept): ?>
                        <div class="card" style="border-top:3px solid #22c55e">
                            <div class="card-head" style="border-top:3px solid #22c55e"><span><i
                                        class="fa-solid fa-users"></i> <?php echo htmlspecialchars($view_dept['name']); ?> -
                                    All Students (<?php echo $total_enrolled; ?>)</span><a href="departments.php"
                                    style="font-size:11px;color:#3b82f6;text-decoration:none">X Close</a></div>
                            <div style="max-height:600px;overflow-y:auto">
                                <?php if ($view_students && $view_students->num_rows > 0): ?>
                                    <table class="student-table">
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php $i = 1;
                                        while ($s = $view_students->fetch_assoc()) {
                                            $sname = $s['name'] ?? $s['fullname'] ?? $s['full_name'] ?? $s['student_name'] ?? trim(($s['firstname'] ?? '') . ' ' . ($s['lastname'] ?? '')) ?: 'Unknown';
                                            $sid = $s['student_id'] ?? $s['id'];
                                            $id_for_link = $s['student_id'] ?? $s['id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><span class="badge"><?php echo htmlspecialchars($sid); ?></span></td>
                                                <td><?php echo htmlspecialchars($sname); ?></td>
                                                <td>
                                                    <!-- VIEW DETAILS WITH QR - IMPORTANT -->
                                                    <a href="departments.php?view=<?php echo $view_dept['id']; ?>&student_id=<?php echo urlencode($id_for_link); ?>&dept_view=<?php echo $view_dept['id']; ?>"
                                                        class="action-btn action-view"><i class="fa-solid fa-eye"></i> View Details
                                                        & QR</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php else: ?>
                                    <div style="padding:25px;color:#94a3b8">No students</div><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>