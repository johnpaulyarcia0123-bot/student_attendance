<?php
session_start();
date_default_timezone_set('Asia/Manila');
include '../includes/db.php';


// FUNCTION: GET SCHEDULE FOR DATE - IMPORTANT
// Returns schedule for given date based on day name

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




$total_students = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'] ?? 0;
$present_today = $conn->query("SELECT COUNT(*) as c FROM attendance_logs WHERE DATE(time_in)=CURDATE()")->fetch_assoc()['c'] ?? 0;
$late_today = $conn->query("SELECT COUNT(*) as c FROM attendance_logs WHERE DATE(time_in)=CURDATE() AND TIME(time_in) > '08:00:00'")->fetch_assoc()['c'] ?? 0; // NOTE: Currently hardcoded 8AM
$absent_today = $total_students - $present_today;
if ($absent_today < 0)
    $absent_today = 0;

$time_in_today = $present_today;
$time_out_today = 0;

$recent_q = $conn->query("SELECT * FROM attendance_logs ORDER BY time_in DESC LIMIT 10");

// 7-day chart data
$days = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $label = date('M d', strtotime($date));
    $cnt = $conn->query("SELECT COUNT(*) as c FROM attendance_logs WHERE DATE(time_in)='$date'")->fetch_assoc()['c'] ?? 0;
    $days[] = ['label' => $label, 'count' => $cnt];
}
$max_count = max(array_column($days, 'count'));
if ($max_count == 0)
    $max_count = 1;


// FUNCTION GET STUDENT NAME - IMPORTANT

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

// Today's schedule banner
$today_sched = getScheduleForDate($conn, date('Y-m-d'));
$sched_banner = "";
if ($today_sched) {
    $s_start = strtotime($today_sched['time_in']);
    $s_end = strtotime($today_sched['time_out']);
    $now = time();
    if ($now >= ($s_start - 3600) && $now <= $s_end) {
        $sched_banner = "Class in session: " . date('h:i A', $s_start) . " - " . date('h:i A', $s_end);
    } else {
        if ($now > $s_end)
            $sched_banner = "No classes - Class ended at " . date('h:i A', $s_end);
        else
            $sched_banner = "No classes at this time. Next: " . date('h:i A', $s_start) . " - " . date('h:i A', $s_end);
    }
} else {
    $sched_banner = "No classes today. Today is " . date('l');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Student Attendance System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styles unchanged - for layout only */
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
            position: fixed;
            overflow-y: auto
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

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 15px
        }

        .card-stat {
            border-radius: 3px;
            color: white;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block
        }

        .card-stat .inner {
            padding: 15px 15px 10px 15px;
            position: relative;
            z-index: 2
        }

        .card-stat .num {
            font-size: 38px;
            font-weight: 700;
            line-height: 1
        }

        .card-stat .txt {
            font-size: 15px;
            margin-top: 2px
        }

        .card-stat .icon {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 70px;
            opacity: 0.2
        }

        .card-stat .footer {
            background: rgba(0, 0, 0, 0.1);
            padding: 6px 0;
            text-align: center;
            font-size: 12px;
            display: flex;
            justify-content: center;
            gap: 5px;
            align-items: center
        }

        .bg-aqua {
            background: #00c0ef
        }

        .bg-green {
            background: #00a65a
        }

        .bg-yellow {
            background: #f39c12
        }

        .bg-red {
            background: #dd4b39
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 15px;
            margin-bottom: 15px
        }

        .box {
            background: white;
            border-radius: 3px;
            border-top: 3px solid #d2d6de;
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

        .btn-blue {
            background: #3c8dbc;
            color: white;
            padding: 6px 12px;
            border-radius: 3px;
            font-size: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .table th {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 2px solid #f4f4f4;
            color: #666;
            font-size: 12px
        }

        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f4f4f4;
            vertical-align: middle
        }

        .bar {
            height: 20px;
            background: #00c0ef;
            border-radius: 2px
        }

        .no-data {
            padding: 40px;
            text-align: center;
            color: #999;
            font-size: 13px
        }

        .small-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-bottom: 1px solid #f4f4f4
        }

        .small-box .ico {
            width: 40px;
            height: 40px;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            min-width: 85px;
            text-align: center;
            white-space: nowrap
        }

        .badge-green {
            background: #00a65a;
            color: white
        }

        .badge-red {
            background: #dd4b39;
            color: white
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
            <li class="active"><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i>
                    Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-qrcode"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
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
            <h2 style="font-weight:400;margin-bottom:15px;font-size:22px">Dashboard <span
                    style="float:right;font-size:12px;color:#777;margin-top:8px"><?php echo $sched_banner; ?> |
                    <?php echo date('h:i A'); ?></span></h2>
            
            <div class="cards">
                <a href="students.php" class="card-stat bg-aqua">
                    <div class="inner">
                        <div class="num"><?php echo $total_students; ?></div>
                        <div class="txt">Registered Students</div>
                        <div class="icon"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="footer">Manage people <i class="fa-solid fa-circle-arrow-right"></i></div>
                </a>
                <a href="attendance_logs.php" class="card-stat bg-green">
                    <div class="inner">
                        <div class="num"><?php echo $present_today; ?></div>
                        <div class="txt">Today's Present</div>
                        <div class="icon"><i class="fa-solid fa-user-check"></i></div>
                    </div>
                    <div class="footer">View logs <i class="fa-solid fa-circle-arrow-right"></i></div>
                </a>
                <a href="attendance_logs.php?filter=late" class="card-stat bg-yellow">
                    <div class="inner">
                        <div class="num" style="color:white"><?php echo $late_today; ?></div>
                        <div class="txt" style="color:white">Today's Late</div>
                        <div class="icon" style="color:white"><i class="fa-solid fa-clock"></i></div>
                    </div>
                    <div class="footer" style="color:white">View late records <i
                            class="fa-solid fa-circle-arrow-right"></i></div>
                </a>
                <a href="reports.php" class="card-stat bg-red">
                    <div class="inner">
                        <div class="num"><?php echo $absent_today; ?></div>
                        <div class="txt">Today's Absent</div>
                        <div class="icon"><i class="fa-solid fa-user-xmark"></i></div>
                    </div>
                    <div class="footer">View absences <i class="fa-solid fa-circle-arrow-right"></i></div>
                </a>
            </div>
            
            <div class="row">
                <div class="box">
                    <div class="box-head">7-Day Attendance Overview <a href="scanner.php" class="btn-blue"><i
                                class="fa-solid fa-qrcode"></i> Open Scanner</a></div>
                    <div class="box-body"><?php if (array_sum(array_column($days, 'count')) == 0): ?>
                            <div class="no-data">No data yet</div>
                        <?php else:
                        foreach ($days as $d):
                            $w = ($d['count'] / $max_count) * 100;
                            if ($w < 5 && $d['count'] > 0)
                                $w = 5; ?>
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;font-size:12px">
                                    <div style="width:50px"><?php echo $d['label']; ?></div>
                                    <div style="flex:1;background:#ecf0f5;height:20px;border-radius:2px;overflow:hidden">
                                        <div class="bar" style="width:<?php echo $w; ?>%"></div>
                                    </div>
                                    <div style="width:25px;text-align:right"><?php echo $d['count']; ?></div>
                                </div><?php endforeach; endif; ?>
                    </div>
                </div>
                <div>
                    <div class="box">
                        <div class="box-head">Time In / Time Out</div>
                        <div class="box-body" style="padding:0">
                            <div class="small-box">
                                <div class="ico" style="background:#3c8dbc"><i class="fa-solid fa-right-to-bracket"></i>
                                </div>
                                <div>
                                    <div style="font-size:12px;color:#666">Time In Recorded</div>
                                    <div style="font-size:18px;font-weight:700"><?php echo $time_in_today; ?></div>
                                </div>
                            </div>
                            <div class="small-box">
                                <div class="ico" style="background:#6c757d"><i
                                        class="fa-solid fa-right-from-bracket"></i></div>
                                <div>
                                    <div style="font-size:12px;color:#666">Time Out Recorded</div>
                                    <div style="font-size:18px;font-weight:700"><?php echo $time_out_today; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-head">System Announcements</div>
                        <div class="box-body">
                            <div style="font-size:12px;color:#333"><b><?php echo $sched_banner; ?></b><br><span
                                    style="color:#999">Schedule: Tuesday & Thursday 2:00 PM - 5:00 PM</span></div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="box">
                <div class="box-head">Recent Attendance <a href="attendance_logs.php"
                        style="font-size:11px;color:#3c8dbc;text-decoration:none">View all</a></div>
                <div class="box-body" style="padding:0">
                    <table class="table">
                        <tr>
                            <th style="width:25%">Person</th>
                            <th style="width:15%">Category</th>
                            <th style="width:15%">Time In</th>
                            <th style="width:15%">Time Out</th>
                            <th style="width:20%;text-align:center">Status</th>
                        </tr>
                        <?php if ($recent_q && $recent_q->num_rows > 0):
                            while ($r = $recent_q->fetch_assoc()):
                                $nm = getName($conn, $r['student_id']);
                                $log_time = strtotime($r['time_in']);
                                $log_date = date('Y-m-d', $log_time);
                                $sched_for_log = getScheduleForDate($conn, $log_date);
                                if ($sched_for_log) {
                                    $s_start = strtotime($log_date . " " . $sched_for_log['time_in']);
                                    $s_end = strtotime($log_date . " " . $sched_for_log['time_out']);
                                    if ($log_time >= $s_start && $log_time <= $s_end)
                                        $badge = "<span class='badge badge-green'>Present</span>";
                                    else
                                        $badge = "<span class='badge badge-red'>No Classes</span>";
                                } else {
                                    $badge = "<span class='badge badge-red'>No Classes</span>";
                                } ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($nm); ?></td>
                                    <td>BSCS</td>
                                    <td><?php echo date('h:i A', $log_time); ?></td>
                                    <td style="text-align:center">-</td>
                                    <td style="text-align:center"><?php echo $badge; ?></td>
                                </tr><?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:20px;color:#999">No recent attendance</td>
                            </tr><?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>