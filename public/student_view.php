<?php
session_start();
include '../includes/db.php';

// AUTH CHECK redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// ID VALIDATION check if id provided
$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: students.php");
    exit;
}
$id = $conn->real_escape_string($id);

// FETCH STUDENT get student data
$student_query = $conn->query("SELECT * FROM students WHERE id='$id' OR student_id='$id' LIMIT 1");
if (!$student_query || $student_query->num_rows == 0) {
    die("Student not found");
}
$student = $student_query->fetch_assoc();

// FETCH ATTENDANCE get history logs
$student_id_safe = $conn->real_escape_string($student['student_id']);
$logs = $conn->query("SELECT * FROM attendance_logs WHERE student_id='$student_id_safe' ORDER BY time_in DESC LIMIT 20");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student View | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
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
            font-size: 13px
        }

        .content {
            padding: 20px;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 20px
        }

        .card {
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04)
        }

        .card-head {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            border-top: 3px solid #3b82f6
        }

        .card-body {
            padding: 18px
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block
        }

        .btn-primary {
            background: #3b82f6;
            color: white
        }

        .btn-primary:hover {
            background: #2563eb
        }

        .btn-light {
            background: #e2e8f0;
            color: #333
        }

        @media (max-width: 900px) {
            .content {
                grid-template-columns: 1fr
            }
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
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li class="active"><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
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
            <div><a href="students.php" style="color:#3b82f6;text-decoration:none"><i
                        class="fa-solid fa-arrow-left"></i> Back to Students</a> /
                <?php echo htmlspecialchars($student['name']); ?></div>
            <div><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($student['student_id']); ?></div>
        </div>

        <div class="content">
            <div>
                // QR CODE SECTION - generate and print QR
                <div class="card">
                    <div class="card-head">QR Code - <?php echo htmlspecialchars($student['student_id']); ?></div>
                    <div class="card-body" style="text-align:center">
                        <div id="qrcode" style="display:flex;justify-content:center;margin:15px 0"></div>
                        <div style="font-size:12px;color:#64748b">Scan this QR for attendance</div>
                        <div style="margin-top:12px"><button class="btn btn-primary" onclick="window.print()"><i
                                    class="fa-solid fa-print"></i> Print QR</button></div>
                    </div>
                </div>

                // STUDENT INFO SECTION - display details 
                <div class="card" style="margin-top:15px">
                    <div class="card-head">Student Info</div>
                    <div class="card-body">
                        <div class="info-row"><span style="color:#64748b">Student
                                ID</span><b><?php echo htmlspecialchars($student['student_id']); ?></b></div>
                        <div class="info-row"><span style="color:#64748b">Full
                                Name</span><b><?php echo htmlspecialchars($student['name']); ?></b></div>
                        <div class="info-row"><span
                                style="color:#64748b">Course</span><span><?php echo htmlspecialchars($student['course']); ?></span>
                        </div>
                        <div class="info-row"><span
                                style="color:#64748b">Year</span><span><?php echo htmlspecialchars($student['year']); ?></span>
                        </div>
                        <div class="info-row"><span
                                style="color:#64748b">Email</span><span><?php echo htmlspecialchars($student['email'] ?? 'N/A'); ?></span>
                        </div>
                        <div style="margin-top:15px"><a href="students.php?edit=<?php echo $student['id']; ?>"
                                class="btn btn-primary"><i class="fa-solid fa-pen"></i> Edit</a> <a href="students.php"
                                class="btn btn-light">Back</a></div>
                    </div>
                </div>
            </div>

           // ATTENDANCE HISTORY SECTION  list logs 
            <div class="card">
                <div class="card-head">Attendance History (<?php echo $logs ? $logs->num_rows : 0; ?>)</div>
                <div class="card-body" style="padding:0">
                    <table style="width:100%;border-collapse:collapse;font-size:13px">
                        <tr style="background:#f8fafc">
                            <th style="padding:10px;text-align:left">Date</th>
                            <th style="padding:10px;text-align:left">Time In</th>
                            <th style="padding:10px;text-align:left">Status</th>
                        </tr>
                        <?php
                        // HISTORY LOOP render attendance records
                        if (!$logs || $logs->num_rows == 0) {
                            echo "<tr><td colspan='3' style='padding:20px;text-align:center;color:#94a3b8'>No attendance yet</td></tr>";
                        } else {
                            while ($l = $logs->fetch_assoc()) {
                                ?>
                                <tr style="border-bottom:1px solid #f1f5f9">
                                    <td style="padding:10px"><?php echo date('M d, Y', strtotime($l['time_in'])); ?></td>
                                    <td style="padding:10px"><?php echo date('h:i A', strtotime($l['time_in'])); ?></td>
                                    <td style="padding:10px"><span
                                            style="background:#22c55e;color:white;padding:2px 8px;border-radius:10px;font-size:11px"><?php echo htmlspecialchars($l['status']); ?></span>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // QR GENERATE create QR code from student_id
        new QRCode(document.getElementById("qrcode"), {
            text: "<?php echo addslashes($student['student_id']); ?>",
            width: 220,
            height: 220,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>

</body>

</html>