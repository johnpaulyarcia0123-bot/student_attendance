<?php
session_start();
date_default_timezone_set('Asia/Manila');
include '../includes/db.php';


// FUNCTION GET SCHEDULE FOR A SPECIFIC DATE - IMPORTANT
// Used to check if log is within class schedule

function getScheduleForDate($conn, $date_str)
{
    $day_name = strtolower(date('l', strtotime($date_str)));
    $q = $conn->query("SELECT * FROM schedules");
    if ($q) {
        while ($row = $q->fetch_assoc()) {
            $title = strtolower($row['title'] ?? '');
            if (strpos($title, $day_name) !== false || $title == $day_name)
                return $row;
        }
    }
    return null;
}


// FUNCTION: GET STUDENT NAME - IMPORTANT

function getName($conn, $sid)
{
    $sid = $conn->real_escape_string($sid);
    $q = $conn->query("SELECT * FROM students WHERE student_id='$sid' OR id='$sid' LIMIT 1");
    if ($q && $q->num_rows > 0) {
        $s = $q->fetch_assoc();
        return $s['name'] ?? $s['fullname'] ?? $s['full_name'] ?? (($s['firstname'] ?? '') . ' ' . ($s['lastname'] ?? '')) ?: $sid;
    }
    return $sid;
}


// DELETE ATTENDANCE LOG - IMPORTANT

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM attendance_logs WHERE id=$id");
    header("Location: attendance_logs.php");
    exit;
}


// FETCH ALL LOGS

$logs_q = $conn->query("SELECT * FROM attendance_logs ORDER BY time_in DESC");

// Get todays schedule for header display
$today_sched = getScheduleForDate($conn, date('Y-m-d'));
$sched_text = "";
if ($today_sched) {
    $sched_text = "Schedule: " . ucfirst($today_sched['title']) . " " . date('h:i A', strtotime($today_sched['time_in'])) . " - " . date('h:i A', strtotime($today_sched['time_out']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Logs | Student Attendance System</title>
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
            border-bottom: 1px solid #2c3b41;
            font-weight: 600;
            display: flex;
            gap: 8px;
            align-items: center
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

        .sidebar li.active {
            background: #3b82f6;
            color: white;
            border-radius: 5px;
            margin: 5px 8px
        }

        .label {
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
            font-size: 13px;
            color: #334155
        }

        .content {
            padding: 20px
        }

        .card {
            background: white;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04)
        }

        .card-head {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            border-top: 3px solid #3b82f6;
            display: flex;
            justify-content: space-between
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .table th {
            padding: 12px 15px;
            text-align: left;
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 600
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle
        }

        .table td:nth-child(5) {
            text-align: center
        }

        .badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            min-width: 90px;
            text-align: center
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca
        }

        .btn-del {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            gap: 5px;
            align-items: center
        }

        .btn-del:hover {
            background: #dc2626
        }
    </style>
</head>

<body>
    <div class="sidebar">
        // SYSTEM LOGO 
        <div class="logo"><i class="fa-solid fa-graduation-cap"></i> SAS</div>
        <div class="profile">
            <div
                style="width:32px;height:32px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <div style="color:white;font-size:13px">Yarcia John Paul</div>
                <div style="font-size:11px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li class="active"><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i>
                    Attendance Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments /
                    Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div>Attendance Logs - <?php echo $logs_q ? $logs_q->num_rows : 0; ?> records | <?php echo $sched_text; ?>
            </div>
            <div><i class="fa-solid fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-head">Recent Attendance<span
                        style="font-weight:400;color:#64748b;font-size:12px"><?php echo date('l, M d Y h:i A'); ?></span>
                </div>
                <div style="overflow-x:auto">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Time In</th>
                            <th style="text-align:center">Status</th>
                            <th>Action</th>
                        </tr>
                        <?php

                        // DISPLAY ATTENDANCE RECORDS IMPORTANT

                        if ($logs_q && $logs_q->num_rows > 0) {
                            $i = 1;
                            while ($r = $logs_q->fetch_assoc()) {
                                $name = getName($conn, $r['student_id']);
                                $log_time = strtotime($r['time_in']);
                                $log_date = date('Y-m-d', $log_time);
                                $sched_for_log = getScheduleForDate($conn, $log_date);

                                // Check if log is within schedule (e.g. 2PM-5PM)
                                $is_present = false;
                                if ($sched_for_log) {
                                    $s_start = strtotime($log_date . " " . $sched_for_log['time_in']);
                                    $s_end = strtotime($log_date . " " . $sched_for_log['time_out']);
                                    if ($log_time >= $s_start && $log_time <= $s_end) {
                                        $is_present = true;
                                    }
                                }
                                $badge = $is_present ? "<span class='badge badge-green'>Present</span>" : "<span class='badge badge-red'>No Classes</span>";
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($r['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($name); ?></td>
                                    <td><?php echo date('M d, Y h:i A', $log_time); ?></td>
                                    <td style="text-align:center"><?php echo $badge; ?></td>
                                    <td><a href="?delete=<?php echo $r['id']; ?>" class="btn-del"
                                            onclick="return confirm('Delete this record?')"><i class="fa-solid fa-trash"></i>
                                            Delete</a></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:30px;color:#999">No attendance records yet
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>