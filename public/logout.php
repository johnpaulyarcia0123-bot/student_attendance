<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}


if (isset($_GET['confirm']) && $_GET['confirm'] == '1') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | QR A S</title>
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
            min-height: 100vh;
            transition: background 1s
        }

        body.dark {
            background: #05060a
        }

        .sidebar {
            width: 230px;
            background: #222d32;
            min-height: 100vh;
            color: #8aa4af;
            position: fixed;
            z-index: 2;
            transition: 0.8s
        }

        body.dark .sidebar {
            filter: brightness(0.3)
        }

        .sidebar .logo {
            padding: 15px;
            color: white;
            font-size: 18px;
            border-bottom: 1px solid #2c3b41
        }

        .sidebar .profile {
            padding: 12px 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #2c3b41
        }

        .sidebar ul {
            list-style: none
        }

        .sidebar li {
            padding: 10px 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            cursor: pointer
        }

        .sidebar li:hover {
            background: #1e282c;
            color: white
        }

        .sidebar li.active {
            background: #dc3545;
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
            align-items: center;
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
            transition: 0.8s
        }

        body.dark .topbar {
            filter: brightness(0.3)
        }

        .content {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            position: relative;
            overflow: hidden
        }

        /* LAMP - GITNA NG CONTENT */
        .lamp-center {
            position: absolute;
            left: 50%;
            top: 42%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 5
        }

        .shade {
            width: 110px;
            height: 36px;
            background: linear-gradient(to bottom, #2c3a52, #1e293b);
            border-radius: 50% 50% 14% 14% / 70% 70% 30% 30%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 2
        }

        .shade::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 15%;
            right: 15%;
            height: 10px;
            background: radial-gradient(ellipse, rgba(255, 222, 80, 0) 0%, transparent 80%);
            border-radius: 50%;
            transition: 1s
        }

        body:not(.dark) .shade::after {
            background: radial-gradient(ellipse, rgba(255, 222, 80, 0.95) 0%, rgba(255, 222, 80, 0.2) 50%, transparent 80%)
        }

        .bulb {
            width: 10px;
            height: 10px;
            background: #1e293b;
            border-radius: 50%;
            margin-top: -2px;
            transition: 0.6s
        }

        body:not(.dark) .bulb {
            background: #ffde50;
            box-shadow: 0 0 15px #ffde50, 0 0 30px rgba(255, 222, 80, 0.6)
        }

        .stick {
            width: 6px;
            height: 140px;
            background: linear-gradient(to right, #1a2538, #33465f 35%, #1e293b 70%, #0f172a);
            margin-top: -1px
        }

        .base {
            width: 80px;
            height: 12px;
            background: linear-gradient(to bottom, #2c3a52, #1a2538);
            border-radius: 6px;
            margin-top: -1px
        }

        .cone {
            position: absolute;
            top: 34px;
            left: 50%;
            transform: translateX(-50%);
            width: 500px;
            height: 500px;
            background: linear-gradient(to bottom, rgba(255, 222, 80, 0) 0%, transparent 100%);
            clip-path: polygon(42% 0, 58% 0, 100% 100%, 0% 100%);
            opacity: 0;
            transition: 1.2s;
            pointer-events: none;
            z-index: 1
        }

        body:not(.dark) .cone {
            opacity: 1;
            background: linear-gradient(to bottom, rgba(255, 222, 80, 0.18) 0%, rgba(255, 222, 80, 0.05) 40%, transparent 100%)
        }

        .pull {
            position: absolute;
            left: calc(50% + 24px);
            top: 32px;
            width: 24px;
            height: 90px;
            cursor: pointer;
            z-index: 20;
            display: flex;
            justify-content: center
        }

        .pull-line {
            width: 1.5px;
            height: 90px;
            background: linear-gradient(to bottom, #4a5a75, #2a3447)
        }

        .pull::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 10px;
            height: 14px;
            background: linear-gradient(to bottom, #5a6a85, #3a4a65);
            border-radius: 6px;
            border: 1px solid #6a7a95
        }

        .pull.pulling {
            transform: translateY(10px)
        }

        /* FIREFLIES */
        .firefly {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #ffde50;
            border-radius: 50%;
            opacity: 0;
            box-shadow: 0 0 8px #ffde50, 0 0 16px rgba(255, 222, 80, 0.7);
            z-index: 3
        }

        body:not(.dark) .firefly {
            animation: fly 7s infinite ease-in-out
        }

        @keyframes fly {
            0% {
                transform: translate(0, 0);
                opacity: 0
            }

            15% {
                opacity: 1
            }

            50% {
                transform: translate(25px, -50px)
            }

            100% {
                transform: translate(-10px, -110px);
                opacity: 0
            }
        }

        .logout-box {
            background: white;
            width: 420px;
            max-width: 95%;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            padding: 30px 25px;
            position: relative;
            z-index: 6;
            transition: all 0.8s
        }

        body.dark .logout-box {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none
        }

        .logout-icon {
            width: 70px;
            height: 70px;
            background: #f8d7da;
            color: #dc3545;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px auto;
            font-size: 28px
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            gap: 6px;
            align-items: center;
            transition: 0.2s
        }

        .btn-danger {
            background: #dc3545;
            color: white
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px)
        }

        .btn-light {
            background: #f1f1f1;
            border: 1px solid #ddd;
            color: #333;
            margin-right: 8px
        }

        .btn-light:hover {
            background: #e9ecef
        }

        .dark-hint {
            position: fixed;
            top: 50%;
            left: calc(50% + 115px);
            transform: translate(-50%, -50%);
            color: #888;
            text-align: center;
            z-index: 100;
            transition: 0.5s;
            cursor: pointer
        }

        body:not(.dark) .dark-hint {
            opacity: 0;
            pointer-events: none
        }

        .dark-hint i {
            font-size: 36px;
            display: block;
            margin-bottom: 12px;
            animation: blink 2s infinite
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 0.3
            }

            50% {
                opacity: 1
            }
        }
    </style>
</head>

<body class="dark" id="body">

    <div class="dark-hint" id="darkHint">
        <i class="fa-regular fa-lightbulb"></i>
        <div style="font-size:14px;font-weight:600;letter-spacing:1px">PULL THE STRING</div>
        <div style="font-size:11px;opacity:0.6;margin-top:6px">ON / OFF</div>
    </div>

    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div
                style="width:35px;height:35px;background:#ccc;border-radius:50%;display:flex;justify-content:center;align-items:center">
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
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments /
                    Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Account</div>
            <li class="active"><a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                    Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:20px;font-size:14px;color:#555"><span><i
                        class="fa-solid fa-bars"></i></span><span><i class="fa-solid fa-qrcode"></i> Scanner</span>
            </div>
            <div style="display:flex;gap:15px;font-size:14px;color:#555"><i class="fa-solid fa-bell"></i><span><i
                        class="fa-solid fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            
            <div class="lamp-center">
                <div class="shade"></div>
                <div class="bulb"></div>
                <div class="cone"></div>
                <div class="stick"></div>
                <div class="base"></div>
                <div class="pull" id="pull">
                    <div class="pull-line"></div>
                </div>
            </div>
            
            <div class="firefly" style="left:20%;top:65%;animation-delay:0s"></div>
            <div class="firefly" style="left:35%;top:70%;animation-delay:0.5s;width:4px;height:4px"></div>
            <div class="firefly" style="left:55%;top:68%;animation-delay:1s"></div>
            <div class="firefly" style="left:70%;top:60%;animation-delay:1.5s"></div>
            <div class="firefly" style="left:30%;top:55%;animation-delay:0.2s"></div>
            <div class="firefly" style="left:60%;top:55%;animation-delay:0.7s;width:4px;height:4px"></div>
            <div class="firefly" style="left:45%;top:50%;animation-delay:1.2s"></div>
            <div class="firefly" style="left:75%;top:55%;animation-delay:0.4s"></div>

            <div class="logout-box">
                <div class="logout-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                <h3 style="font-weight:600;margin-bottom:8px">Ready to leave?</h3>
                <p style="font-size:13px;color:#777;margin-bottom:20px">Are you sure you want to logout from QR
                    Attendance System?<br>Your BSCS data will remain saved.</p>
                <div>
                    <a href="dashboard.php" class="btn btn-light">Cancel</a>
                    <a href="logout.php?confirm=1" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>
                        Yes, Logout</a>
                </div>
                <div style="margin-top:15px;font-size:11px;color:#aaa">BSCS 2B | Session Ended | Data Safe in MySQL
                </div>
            </div>
        </div>
    </div>

    <script>
        const body = document.getElementById('body');
        const pull = document.getElementById('pull');
        const darkHint = document.getElementById('darkHint');
        let isOn = false;

        function toggleLamp() {
            isOn = !isOn;
            pull.classList.add('pulling');
            setTimeout(() => pull.classList.remove('pulling'), 180);
            if (isOn) { body.classList.remove('dark'); } else { body.classList.add('dark'); }
            if (navigator.vibrate) navigator.vibrate(30);
        }

        pull.addEventListener('click', (e) => { e.stopPropagation(); toggleLamp(); });
        darkHint.addEventListener('click', toggleLamp);
    </script>

</body>

</html>