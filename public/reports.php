<?php
session_start();
include '../includes/db.php';

// AUTH CHECK - redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// FILTER LOGIC build where clause
$where = "1=1";
if (isset($_GET['filter_date']) && $_GET['filter_date'] != "") {
    $d = $conn->real_escape_string($_GET['filter_date']);
    $where .= " AND DATE(a.time_in)='$d'";
}
if (isset($_GET['course']) && $_GET['course'] != "") {
    $c = $conn->real_escape_string($_GET['course']);
    $where .= " AND s.course='$c'";
}

// MAIN QUERY fetch attendance logs
$logs = $conn->query("SELECT a.*, s.name, s.course, s.year FROM attendance_logs a LEFT JOIN students s ON s.student_id=a.student_id WHERE $where ORDER BY a.time_in DESC");

// FETCH COURSES for dropdown filter
$courses = $conn->query("SELECT DISTINCT course FROM students");

// COUNT TOTAL for header display
$total = $logs ? $logs->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Export | QR A S</title>
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
            background: #222d32;
            min-height: 100vh;
            color: #8aa4af;
            position: fixed;
            overflow-y: auto
        }

        .logo {
            padding: 15px;
            color: white;
            font-size: 18px;
            border-bottom: 1px solid #2c3b41
        }

        .profile {
            padding: 12px 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #2c3b41
        }

        .sidebar ul {
            list-style: none;
            padding-bottom: 20px
        }

        .sidebar li {
            padding: 10px 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            color: #8aa4af
        }

        .sidebar li:hover {
            background: #1e282c;
            color: white
        }

        .sidebar li.active {
            background: #3b82f6;
            color: white;
            border-radius: 5px;
            margin: 5px 8px
        }

        .sidebar .label {
            padding: 12px 15px 5px 15px;
            font-size: 11px;
            color: #5a7a87;
            text-transform: uppercase;
            margin-top: 8px
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
            box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
            font-size: 13px
        }

        .content {
            padding: 20px
        }

        .card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04)
        }

        .form-control {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 13px;
            height: 36px;
            outline: none
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1)
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s
        }

        .btn-primary {
            background: #3b82f6;
            color: white
        }

        .btn-primary:hover {
            background: #2563eb
        }

        .btn-success {
            background: #22c55e;
            color: white;
            text-decoration: none
        }

        .btn-success:hover {
            background: #16a34a
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        th {
            background: #f8fafc;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #475569
        }

        td {
            padding: 11px 10px;
            border-bottom: 1px solid #f1f5f9
        }

        tr:hover {
            background: #f8fafc
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div
                style="width:32px;height:32px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center">
                <i class="fa-solid fa-user"></i></div>
            <div>
                <div style="color:white;font-size:13px">Yarcia John Paul</div>
                <div style="font-size:11px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li class="active"><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports &
                    Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments /
                    Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Account</div>
            <li><a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div>Reports & Export</div>
            <div><i class="fa-solid fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">

            <!-- FILTER SECTION -->
            <div class="card" style="display:flex;gap:10px;align-items:end;flex-wrap:wrap">
                <form method="GET" style="display:flex;gap:10px;align-items:end">
                    <div><label style="font-size:11px">Date</label><br><input type="date" name="filter_date"
                            class="form-control" value="<?php echo $_GET['filter_date'] ?? ''; ?>"></div>
                    <div><label style="font-size:11px">Course</label><br><select name="course" class="form-control">
                            <option value="">All Courses</option>
                            <?php
                            // COURSE DROPDOWN  loop distinct courses
                            if ($courses) {
                                while ($co = $courses->fetch_assoc()) {
                                    $sel = ($_GET['course'] ?? '') == $co['course'] ? 'selected' : '';
                                    echo "<option $sel>{$co['course']}</option>";
                                }
                            }
                            ?>
                        </select></div>
                    <div><button class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter</button> <a
                            href="reports.php" class="btn"
                            style="background:#e2e8f0;text-decoration:none;color:#333">Clear</a></div>
                </form>
                <div style="margin-left:auto;display:flex;gap:8px">
                    <!-- EXPORT SECTION - csv and print -->
                    <a href="export.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success"><i
                            class="fa-solid fa-file-excel"></i> Export CSV</a>
                    <button onclick="window.print()" class="btn" style="background:#334155;color:white"><i
                            class="fa-solid fa-print"></i> Print</button>
                </div>
            </div>

            //TABLE SECTION - display attendance 
            <div class="card">
                <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                    <h3 style="font-size:14px">Attendance Report (<?php echo $total; ?> records)</h3><span
                        style="font-size:12px;color:#64748b"><?php echo date('M d, Y'); ?></span>
                </div>
                <div style="overflow-x:auto">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Time In</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        // TABLE LOOP - render logs
                        if (!$logs || $logs->num_rows == 0) {
                            echo "<tr><td colspan='7' style='padding:20px;text-align:center;color:#94a3b8'>No records found. Please scan QR code first.</td></tr>";
                        } else {
                            $i = 1;
                            while ($r = $logs->fetch_assoc()) {
                                $time = date('M d, Y h:i A', strtotime($r['time_in']));
                                $status = $r['status'] ?? 'Present';
                                echo "<tr>
              <td>$i</td>
              <td>{$r['student_id']}</td>
              <td>{$r['name']}</td>
              <td>{$r['course']}</td>
              <td>{$r['year']}</td>
              <td>$time</td>
              <td><span style='background:#22c55e;color:white;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600'>$status</span></td>
            </tr>";
                                $i++;
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>

</html>