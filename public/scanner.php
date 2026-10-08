<?php
session_start();
date_default_timezone_set('Asia/Manila');
include '../includes/db.php';

// AUTH CHECK - redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$message = "";

// SCHEDULE CHECK - validate current time against schedules table
function checkSchedule($conn)
{
    $today = date('l');
    $today_lower = strtolower($today);
    $today_short = strtolower(date('D'));
    $now = date('H:i:s');
    $now_ts = strtotime($now);

    $q = $conn->query("SELECT * FROM schedules");
    $matched = [];

    if ($q) {
        while ($row = $q->fetch_assoc()) {
            $title = strtolower($row['title'] ?? $row['day'] ?? '');
            $day_col = strtolower($row['day'] ?? $title);

            if (strpos($title, $today_lower) !== false || strpos($day_col, $today_lower) !== false || strpos($title, $today_short) !== false) {
                $tin = $row['time_in'] ?? $row['start_time'] ?? '08:00:00';
                $tout = $row['time_out'] ?? $row['end_time'] ?? '17:00:00';
                $matched[] = ['title' => $row['title'] ?? $today, 'in' => $tin, 'out' => $tout];
            }
        }
    }

    if (empty($matched)) {
        return ['allowed' => false, 'reason' => "No classes today. Today is $today.", 'sched' => null];
    }

    foreach ($matched as $s) {
        $start = strtotime($s['in']) - 3600; // 1 hour early allowed
        $end = strtotime($s['out']);
        if ($now_ts >= $start && $now_ts <= $end) {
            return ['allowed' => true, 'reason' => "", 'sched' => $s];
        }
    }

    $first = $matched[0];
    if ($now_ts > strtotime($first['out'])) {
        return ['allowed' => false, 'reason' => "Class ended at " . date('h:i A', strtotime($first['out'])) . ". Current time " . date('h:i A') . ".", 'sched' => $first];
    }
    return ['allowed' => false, 'reason' => "Outside class hours. {$first['title']} is " . date('h:i A', strtotime($first['in'])) . " - " . date('h:i A', strtotime($first['out'])) . ". Current time " . date('h:i A') . ".", 'sched' => $first];
}

$sched_status = checkSchedule($conn);

// MANUAL SCAN 
if (isset($_POST['manual_scan'])) {
    $sid = $conn->real_escape_string(trim($_POST['student_id']));
    $check = $conn->query("SELECT * FROM students WHERE student_id='$sid' LIMIT 1");

    if ($check && $check->num_rows > 0) {
        $today_check = $conn->query("SELECT * FROM attendance_logs WHERE student_id='$sid' AND DATE(time_in)=CURDATE() LIMIT 1");
        if ($today_check && $today_check->num_rows > 0) {
            $message = "<div style='background:#fef3c7;color:#92400e;padding:10px;border-radius:4px;margin-bottom:10px'>Student <b>$sid</b> already marked present today.</div>";
        } else {
            $conn->query("INSERT INTO attendance_logs (student_id, time_in, status) VALUES ('$sid', NOW(), 'Present')");
            $message = "<div style='background:#dcfce7;color:#166534;padding:10px;border-radius:4px;margin-bottom:10px'>Attendance recorded for: <b>$sid</b> - " . date('h:i A') . "</div>";
        }
    } else {
        $message = "<div style='background:#fee2e2;color:#991b1b;padding:10px;border-radius:4px;margin-bottom:10px'>Student ID not found: $sid</div>";
    }
}

// QR SCAN ENDPOINT ajax request
if (isset($_GET['qr'])) {
    $sid = $conn->real_escape_string(trim($_GET['qr']));
    $check = $conn->query("SELECT * FROM students WHERE student_id='$sid' LIMIT 1");

    if ($check && $check->num_rows > 0) {
        $today_check = $conn->query("SELECT * FROM attendance_logs WHERE student_id='$sid' AND DATE(time_in)=CURDATE() LIMIT 1");
        if ($today_check && $today_check->num_rows > 0) {
            echo "ALREADY_PRESENT";
            exit;
        } else {
            $conn->query("INSERT INTO attendance_logs (student_id, time_in, status) VALUES ('$sid', NOW(), 'Present')");
            echo "SUCCESS:$sid";
            exit;
        }
    } else {
        echo "NOT_FOUND";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner | QR A S</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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
            font-size: 13px;
            color: #334155
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
            font-weight: 500
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 18px
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
            padding: 15px
        }

        .btn {
            padding: 9px 16px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 600
        }

        .btn-green {
            background: #22c55e;
            color: white
        }

        .btn-red {
            background: #ef4444;
            color: white
        }

        .btn-blue {
            background: #3b82f6;
            color: white
        }

        .btn-gray {
            background: #e2e8f0;
            color: #334155
        }

        #reader {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            min-height: 350px;
            background: #000
        }

        .controls {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap
        }

        .form-control {
            width: 100%;
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 13px;
            height: 40px
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
            <li class="active"><a class="link" href="scanner.php"><i class="fa-solid fa-camera"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments /
                    Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
            <li><a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div>QR Scanner - <?php echo date('l, M d Y h:i A'); ?> |
                <?php if ($sched_status['allowed']) {
                    echo "Class: {$sched_status['sched']['title']} " . date('h:i A', strtotime($sched_status['sched']['in'])) . " - " . date('h:i A', strtotime($sched_status['sched']['out']));
                } else {
                    echo $sched_status['reason'];
                } ?>
            </div>
            <div><i class="fa-solid fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="header">
                <h2>QR Scanner</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / Scanner</div>
            </div>
            <?php echo $message; ?>
            <div class="grid">
                <div class="card">
                    <div class="card-head">Camera Scanner - Start / Stop Supported</div>
                    <div class="card-body">
                        <div class="controls">
                            <button id="startBtn" class="btn btn-green"><i class="fa-solid fa-play"></i> Start
                                Camera</button>
                            <button id="stopBtn" class="btn btn-red" disabled><i class="fa-solid fa-stop"></i> Stop
                                Camera</button>
                            <button id="switchBtn" class="btn btn-gray"><i class="fa-solid fa-camera-rotate"></i>
                                Switch</button>
                        </div>
                        <div id="reader"></div>
                        <div id="result" style="margin-top:12px;font-size:13px;color:#334155"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">Manual Input (Backup)</div>
                    <div class="card-body">
                        <p style="font-size:12px;color:#64748b;margin-bottom:12px">Enter Student ID if camera
                            unavailable:</p>
                        <form method="POST">
                            <input type="text" name="student_id" class="form-control" placeholder="e.g. 71202025"
                                required style="margin-bottom:10px">
                            <button class="btn btn-blue" name="manual_scan" style="width:100%"><i
                                    class="fa-solid fa-check"></i> Submit Attendance</button>
                        </form>
                        <hr style="margin:15px 0;border:none;border-top:1px solid #e2e8f0">
                        <div style="font-size:12px;line-height:18px;color:#475569">
                            <b>Current Status:</b><br>
                            <?php if ($sched_status['allowed']) {
                                echo "Class in session<br>{$sched_status['sched']['title']}: " . date('h:i A', strtotime($sched_status['sched']['in'])) . " - " . date('h:i A', strtotime($sched_status['sched']['out']));
                            } else {
                                echo $sched_status['reason'];
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CAMERA LOGIC start/stop/switch
        let html5QrCode;
        let currentCamera = 0;
        let cameras = [];

        async function getCameras() {
            try { cameras = await Html5Qrcode.getCameras(); } catch (e) { console.log(e); }
        }

        function onScanSuccess(decodedText) {
            document.getElementById('result').innerHTML = `<div style='background:#f1f5f9;padding:8px;border-radius:4px'>Checking: ${decodedText}...</div>`;
            fetch(`?qr=${encodeURIComponent(decodedText)}`).then(r => r.text()).then(res => {
                if (res.startsWith("SUCCESS")) {
                    document.getElementById('result').innerHTML = `<div style='background:#dcfce7;padding:8px;border-radius:4px'>Present: <b>${decodedText}</b> - ${new Date().toLocaleTimeString()}</div>`;
                } else if (res == "ALREADY_PRESENT") {
                    document.getElementById('result').innerHTML = `<div style='background:#fef3c7;color:#92400e;padding:8px;border-radius:4px'>Already present today: ${decodedText}</div>`;
                } else {
                    document.getElementById('result').innerHTML = `<div style='background:#fee2e2;padding:8px;border-radius:4px'>Not found: ${decodedText}</div>`;
                }
            });
        }

        document.getElementById('startBtn').addEventListener('click', async () => {
            await getCameras();
            if (cameras.length == 0) { alert('No camera found.'); return; }
            html5QrCode = new Html5Qrcode("reader");
            let camId = cameras[currentCamera].id;
            html5QrCode.start(camId, { fps: 10, qrbox: { width: 250, height: 250 } }, onScanSuccess).then(() => {
                document.getElementById('startBtn').disabled = true;
                document.getElementById('stopBtn').disabled = false;
                document.getElementById('result').innerHTML = "<span style='color:#475569'>Camera running - Point QR code</span>";
            }).catch(err => {
                document.getElementById('result').innerHTML = `<span style='color:red'>Error: ${err}</span>`;
            });
        });

        document.getElementById('stopBtn').addEventListener('click', () => {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    document.getElementById('startBtn').disabled = false;
                    document.getElementById('stopBtn').disabled = true;
                    document.getElementById('result').innerHTML = "<span style='color:#64748b'>Camera stopped</span>";
                });
            }
        });

        document.getElementById('switchBtn').addEventListener('click', async () => {
            if (cameras.length < 2) { await getCameras(); }
            if (cameras.length > 1) {
                currentCamera = (currentCamera + 1) % cameras.length;
                if (html5QrCode) { await html5QrCode.stop(); document.getElementById('startBtn').click(); }
            } else { alert('Only 1 camera'); }
        });
    </script>

</body>

</html>