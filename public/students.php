<?php
session_start();
include '../includes/db.php';

// AUTH CHECK
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$message = "";
$filter_cat = $_GET['category'] ?? '';
$edit_id = $_GET['edit'] ?? '';

// ADD STUDENT
if (isset($_POST['add_student'])) {
    $sid = $conn->real_escape_string(trim($_POST['student_id']));
    $fname = $conn->real_escape_string(trim($_POST['fullname']));
    $cat = $conn->real_escape_string($_POST['category']);
    $dept = $conn->real_escape_string($_POST['department']);
    $check = $conn->query("SELECT id FROM students WHERE student_id='$sid' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $message = "<div style='background:#fee2e2;color:#991b1b;padding:10px;border-radius:4px;margin-bottom:10px'>ID $sid already exists!</div>";
    } else {
        $conn->query("INSERT INTO students (student_id, name, category, department) VALUES ('$sid', '$fname', '$cat', '$dept')");
        $message = "<div style='background:#dcfce7;color:#166534;padding:10px;border-radius:4px;margin-bottom:10px'>Added: $fname - $cat</div>";
    }
}

// EDIT STUDENT
if (isset($_POST['edit_student'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $sid = $conn->real_escape_string(trim($_POST['student_id']));
    $fname = $conn->real_escape_string(trim($_POST['fullname']));
    $cat = $conn->real_escape_string($_POST['category']);
    $dept = $conn->real_escape_string($_POST['department']);
    $conn->query("UPDATE students SET student_id='$sid', name='$fname', category='$cat', department='$dept' WHERE id='$id'");
    header("Location: students.php?category=" . urlencode($cat));
    exit;
}

// DELETE LOGIC
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM students WHERE id='$id'");
    header("Location: students.php" . ($filter_cat ? "?category=" . urlencode($filter_cat) : ""));
    exit;
}

// EDIT FETCH
$edit_data = null;
if ($edit_id) {
    $edit_id_safe = $conn->real_escape_string($edit_id);
    $edit_q = $conn->query("SELECT * FROM students WHERE id='$edit_id_safe' LIMIT 1");
    if ($edit_q && $edit_q->num_rows > 0)
        $edit_data = $edit_q->fetch_assoc();
}

// FILTER FETCH
if ($filter_cat) {
    $fc = $conn->real_escape_string($filter_cat);
    if ($fc == 'BSCS 2B') {
        $students = $conn->query("SELECT * FROM students WHERE category IN ('$fc','Student','BSCS','') ORDER BY name ASC");
    } else {
        $students = $conn->query("SELECT * FROM students WHERE category='$fc' ORDER BY name ASC");
    }
} else {
    $students = $conn->query("SELECT * FROM students ORDER BY category ASC, name ASC");
}

// COUNT TOTAL
$total_row = $conn->query("SELECT COUNT(*) as c FROM students");
$total = $total_row ? $total_row->fetch_assoc()['c'] : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
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
            background: #ecf0f5;
            min-height: 100vh
        }

        .sidebar {
            width: 230px;
            background: #222d32;
            min-height: 100vh;
            color: #b8c7ce;
            position: fixed
        }

        .admin-box {
            padding: 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #2c3b41;
            background: #1a2226
        }

        .sidebar ul {
            list-style: none;
            padding-top: 10px
        }

        .sidebar li {
            padding: 10px 15px;
            font-size: 13px;
            display: flex;
            align-items: center
        }

        .sidebar li.active {
            background: #1e282c;
            color: white;
            border-left: 3px solid #3c8dbc
        }

        .sidebar a.link {
            color: #b8c7ce;
            text-decoration: none;
            display: flex;
            gap: 10px;
            width: 100%;
            align-items: center
        }

        .sidebar li.active a.link {
            color: white
        }

        .label {
            padding: 10px 15px 5px 15px;
            font-size: 11px;
            color: #4b646f;
            text-transform: uppercase;
            margin-top: 8px
        }

        .main {
            margin-left: 230px;
            width: calc(100% - 230px)
        }

        .content {
            padding: 20px
        }

        .box {
            background: white;
            border-radius: 3px;
            border-top: 3px solid #3c8dbc;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
            margin-bottom: 15px
        }

        .box-head {
            padding: 12px 15px;
            border-bottom: 1px solid #f4f4f4;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .box-body {
            padding: 15px
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d2d6de;
            border-radius: 3px;
            font-size: 13px;
            height: 38px
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 3px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block
        }

        .btn-blue {
            background: #3c8dbc;
            color: white
        }

        .btn-red {
            background: #dd4b39;
            color: white
        }

        .btn-green {
            background: #00a65a;
            color: white
        }

        .btn-gray {
            background: #ecf0f5;
            color: #444;
            border: 1px solid #d2d6de
        }

        .btn-orange {
            background: #f39c12;
            color: white
        }

        .btn-active {
            background: #3c8dbc;
            color: white;
            border: 1px solid #3c8dbc
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .table th {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 2px solid #f4f4f4;
            color: #666;
            background: #fafafa
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #f4f4f4
        }

        .badge {
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 11px;
            color: white;
            background: #3c8dbc;
            font-weight: 600
        }

        .filter-bar {
            display: flex;
            gap: 6px;
            flex-wrap: wrap
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="admin-box">
            <div
                style="width:40px;height:40px;background:#d2d6de;border-radius:50%;display:flex;justify-content:center;align-items:center">
                <i class="fa-solid fa-user"></i></div>
            <div>
                <div style="color:white;font-size:13px;font-weight:600">admin</div>
                <div style="font-size:11px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-qrcode"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li class="active"><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-building"></i> Departments / Groups</a>
            </li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="content">
            <h2 style="font-weight:400;margin-bottom:15px;font-size:22px">Students
                <?php if ($filter_cat)
                    echo "- $filter_cat"; ?> (<?php echo $total; ?>) <span
                    style="float:right;font-size:12px;color:#777;margin-top:8px"><a href="dashboard.php"
                        style="color:#3c8dbc;text-decoration:none">Home</a> / Students</span></h2>
            <?php echo $message; ?>
            <div class="box">
                <div class="box-head">Filter by Year & Section</div>
                <div class="box-body">
                    <div class="filter-bar">
                        <a href="students.php"
                            class="btn <?php echo !$filter_cat ? 'btn-active' : 'btn-gray'; ?>">All</a>
                        <a href="students.php?category=BSCS 1A"
                            class="btn <?php echo $filter_cat == 'BSCS 1A' ? 'btn-active' : 'btn-gray'; ?>">BSCS 1A</a>
                        <a href="students.php?category=BSCS 1B"
                            class="btn <?php echo $filter_cat == 'BSCS 1B' ? 'btn-active' : 'btn-gray'; ?>">BSCS 1B</a>
                        <a href="students.php?category=BSCS 2A"
                            class="btn <?php echo $filter_cat == 'BSCS 2A' ? 'btn-active' : 'btn-gray'; ?>">BSCS 2A</a>
                        <a href="students.php?category=BSCS 2B"
                            class="btn <?php echo $filter_cat == 'BSCS 2B' ? 'btn-active' : 'btn-gray'; ?>">BSCS 2B</a>
                        <a href="students.php?category=BSCS 3A"
                            class="btn <?php echo $filter_cat == 'BSCS 3A' ? 'btn-active' : 'btn-gray'; ?>">BSCS 3A</a>
                        <a href="students.php?category=BSCS 3B"
                            class="btn <?php echo $filter_cat == 'BSCS 3B' ? 'btn-active' : 'btn-gray'; ?>">BSCS 3B</a>
                        <a href="students.php?category=BSCS 4A"
                            class="btn <?php echo $filter_cat == 'BSCS 4A' ? 'btn-active' : 'btn-gray'; ?>">BSCS 4A</a>
                        <a href="students.php?category=BSCS 4B"
                            class="btn <?php echo $filter_cat == 'BSCS 4B' ? 'btn-active' : 'btn-gray'; ?>">BSCS 4B</a>
                    </div>
                </div>
            </div>
            <?php if ($edit_data): ?>
                <div class="box" style="border-top-color:#f39c12">
                    <div class="box-head" style="color:#f39c12">Edit Student -
                        <?php echo htmlspecialchars($edit_data['name']); ?> <a
                            href="students.php?category=<?php echo urlencode($filter_cat); ?>" class="btn btn-gray"
                            style="float:right">Cancel</a></div>
                    <div class="box-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                            <div class="form-grid">
                                <div><label style="font-size:12px">Student ID</label><input type="text" name="student_id"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($edit_data['student_id']); ?>" required></div>
                                <div><label style="font-size:12px">Full Name</label><input type="text" name="fullname"
                                        class="form-control" value="<?php echo htmlspecialchars($edit_data['name']); ?>"
                                        required></div>
                                <div><label style="font-size:12px">Year & Section</label><select name="category"
                                        class="form-control" required>
                                        <?php $opts = ['BSCS 1A', 'BSCS 1B', 'BSCS 2A', 'BSCS 2B', 'BSCS 3A', 'BSCS 3B', 'BSCS 4A', 'BSCS 4B'];
                                        foreach ($opts as $o) {
                                            $sel = ($edit_data['category'] == $o || ($edit_data['category'] == 'Student' && $o == 'BSCS 2B')) ? 'selected' : '';
                                            echo "<option value='$o' $sel>$o</option>";
                                        } ?>
                                    </select></div>
                                <div><label style="font-size:12px">Department</label><select name="department"
                                        class="form-control">
                                        <option value="BSCS" selected>BSCS</option>
                                    </select></div>
                            </div>
                            <button type="submit" name="edit_student" class="btn btn-orange"
                                style="margin-top:12px;width:100%"><i class="fa-solid fa-save"></i> Update Student</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="box">
                    <div class="box-head">Add New Student</div>
                    <div class="box-body">
                        <form method="POST">
                            <div class="form-grid">
                                <div><label style="font-size:12px">Student ID</label><input type="text" name="student_id"
                                        class="form-control" placeholder="e.g. 71202025" required></div>
                                <div><label style="font-size:12px">Full Name</label><input type="text" name="fullname"
                                        class="form-control" placeholder="e.g. Juan Dela Cruz" required></div>
                                <div><label style="font-size:12px">Year & Section</label><select name="category"
                                        class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <option value="BSCS 1A" <?php if ($filter_cat == 'BSCS 1A')
                                            echo 'selected'; ?>>BSCS 1A
                                        </option>
                                        <option value="BSCS 1B" <?php if ($filter_cat == 'BSCS 1B')
                                            echo 'selected'; ?>>BSCS 1B
                                        </option>
                                        <option value="BSCS 2A" <?php if ($filter_cat == 'BSCS 2A')
                                            echo 'selected'; ?>>BSCS 2A
                                        </option>
                                        <option value="BSCS 2B" <?php if ($filter_cat == 'BSCS 2B')
                                            echo 'selected'; ?>>BSCS 2B
                                        </option>
                                        <option value="BSCS 3A" <?php if ($filter_cat == 'BSCS 3A')
                                            echo 'selected'; ?>>BSCS 3A
                                        </option>
                                        <option value="BSCS 3B" <?php if ($filter_cat == 'BSCS 3B')
                                            echo 'selected'; ?>>BSCS 3B
                                        </option>
                                        <option value="BSCS 4A" <?php if ($filter_cat == 'BSCS 4A')
                                            echo 'selected'; ?>>BSCS 4A
                                        </option>
                                        <option value="BSCS 4B" <?php if ($filter_cat == 'BSCS 4B')
                                            echo 'selected'; ?>>BSCS 4B
                                        </option>
                                    </select></div>
                                <div><label style="font-size:12px">Department</label><select name="department"
                                        class="form-control">
                                        <option value="BSCS">BSCS</option>
                                    </select></div>
                            </div>
                            <button type="submit" name="add_student" class="btn btn-blue"
                                style="margin-top:12px;width:100%"><i class="fa-solid fa-plus"></i> Add to
                                <?php echo $filter_cat ? $filter_cat : 'BSCS'; ?></button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <div class="box">
                <div class="box-head"><?php echo $filter_cat ? "$filter_cat Students" : "All Students"; ?>
                    (<?php echo $students ? $students->num_rows : 0; ?>)</div>
                <div class="box-body" style="padding:0">
                    <table class="table">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Year & Section</th>
                            <th>QR</th>
                            <th>Action</th>
                        </tr>
                        <?php if ($students && $students->num_rows > 0):
                            while ($s = $students->fetch_assoc()):
                                $disp_cat = $s['category'];
                                if ($disp_cat == 'Student' || $disp_cat == 'BSCS' || $disp_cat == '')
                                    $disp_cat = 'BSCS 2B'; ?>
                                <tr>
                                    <td><b><?php echo htmlspecialchars($s['student_id']); ?></b></td>
                                    <td><?php echo htmlspecialchars($s['name']); ?></td>
                                    <td><span class="badge"><?php echo htmlspecialchars($disp_cat); ?></span></td>
                                    <td><a href="student_view.php?id=<?php echo $s['id']; ?>" class="btn btn-green"
                                            style="padding:4px 8px;font-size:11px"><i class="fa-solid fa-qrcode"></i> QR</a>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $s['id']; ?>&category=<?php echo urlencode($filter_cat); ?>"
                                            class="btn btn-orange" style="padding:4px 8px;font-size:11px"><i
                                                class="fa-solid fa-pen"></i></a>
                                        <a href="?delete=<?php echo $s['id']; ?>&category=<?php echo urlencode($filter_cat); ?>"
                                            onclick="return confirm('Delete?')" class="btn btn-red"
                                            style="padding:4px 8px;font-size:11px"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:25px;color:#999">No students in
                                    <?php echo $filter_cat ? $filter_cat : 'this section'; ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>