<?php
ob_start();
session_start();
include '../includes/db.php';
$error = "";

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username='$username' LIMIT 1");

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['admin'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'] ?? 1;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "Account not found. Check your username.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Attendance System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Inter, sans-serif
        }

        body {
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: background 1s
        }

        body.dark {
            background: #05060a
        }

        .wrapper {
            display: grid;
            grid-template-columns: 420px 420px;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            max-width: 840px;
            width: 100%;
            position: relative;
            transition: all 0.9s
        }

        body.dark .wrapper {
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.8);
            filter: brightness(0.28)
        }

        .left {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 40px;
            color: white;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden
        }

        /* LAMP GITNA */
        .lamp-center {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 10;
            transition: 0.4s
        }

        .lamp-center:active {
            transform: translate(-50%, -50%) scale(0.98)
        }

        .shade {
            width: 110px;
            height: 36px;
            background: linear-gradient(to bottom, #2c3a52, #1e293b);
            border-radius: 50% 50% 14% 14% / 70% 70% 30% 30%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), inset 0 2px 2px rgba(255, 255, 255, 0.08);
            position: relative;
            z-index: 2;
            transition: 0.3s
        }

        body:not(.dark) .shade {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), 0 0 30px rgba(255, 222, 80, 0.2)
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
            transition: 0.6s;
            z-index: 1
        }

        body:not(.dark) .bulb {
            background: #ffde50;
            box-shadow: 0 0 15px #ffde50, 0 0 30px rgba(255, 222, 80, 0.6)
        }

        .stick {
            width: 6px;
            height: 180px;
            background: linear-gradient(to right, #1a2538, #33465f 35%, #1e293b 70%, #0f172a);
            margin-top: -1px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);
            position: relative
        }

        .stick::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(to bottom, rgba(255, 222, 80, 0.12), transparent);
            opacity: 0;
            transition: 1s
        }

        body:not(.dark) .stick::before {
            opacity: 1
        }

        .base {
            width: 80px;
            height: 12px;
            background: linear-gradient(to bottom, #2c3a52, #1a2538);
            border-radius: 6px;
            margin-top: -1px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.6)
        }

        .cone {
            position: absolute;
            top: 34px;
            left: 50%;
            transform: translateX(-50%);
            width: 380px;
            height: 400px;
            background: linear-gradient(to bottom, rgba(255, 222, 80, 0) 0%, transparent 100%);
            clip-path: polygon(42% 0, 58% 0, 100% 100%, 0% 100%);
            opacity: 0;
            transition: 1.2s;
            pointer-events: none;
            z-index: 1
        }

        body:not(.dark) .cone {
            opacity: 1;
            background: linear-gradient(to bottom, rgba(255, 222, 80, 0.20) 0%, rgba(255, 222, 80, 0.06) 40%, transparent 100%)
        }

        /* PULL - MAS MALAKI CLICK AREA */
        .pull {
            position: absolute;
            left: calc(50% + 24px);
            top: 32px;
            width: 24px;
            height: 100px;
            cursor: pointer;
            z-index: 20;
            display: flex;
            justify-content: center;
            transition: transform 0.15s
        }

        .pull-line {
            width: 1.5px;
            height: 90px;
            background: linear-gradient(to bottom, #4a5a75, #2a3447);
            transition: 0.15s
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
            border: 1px solid #6a7a95;
            transition: 0.15s
        }

        .pull:hover .pull-line {
            background: #5a6a85
        }

        .pull:hover::after {
            background: #6a7a95;
            transform: translateX(-50%) scale(1.1)
        }

        .pull.pulling {
            transform: translateY(12px)
        }

        /* FIREFLIES YELLOW MARAMI */
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

        .brand {
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(15px);
            transition: 0.7s
        }

        body:not(.dark) .brand {
            opacity: 1;
            transform: translateY(0)
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: #3b82f6;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .brand h1 {
            font-size: 26px;
            font-weight: 700;
        }

        .brand p {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 8px;
            line-height: 1.5;
        }

        .features {
            margin-top: 30px;
            opacity: 0;
            transform: translateY(15px);
            transition: 0.7s 0.1s
        }

        body:not(.dark) .features {
            opacity: 1;
            transform: translateY(0)
        }

        .feat {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 16px;
            font-size: 13px;
            color: #cbd5e1;
        }

        .feat i {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #60a5fa;
            font-size: 14px;
        }

        .bottom-text {
            font-size: 11px;
            color: #64748b;
            margin-top: auto;
            opacity: 0;
            transition: 0.7s 0.2s
        }

        body:not(.dark) .bottom-text {
            opacity: 1
        }

        .right {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: 0;
            transform: translateX(20px);
            transition: 0.9s;
            pointer-events: none
        }

        body:not(.dark) .right {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto
        }

        .right-head h2 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
        }

        .right-head p {
            font-size: 13px;
            color: #64748b;
            margin-top: 6px;
            margin-bottom: 26px
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            height: 46px;
            background: #f8fafc;
            outline: none;
        }

        .form-control:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 10px;
            background: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            background: #2563eb;
        }

        .alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 14px;
            font-size: 13px;
            border-radius: 10px;
            margin-bottom: 18px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .hint {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 12px;
            border-radius: 10px;
            font-size: 11px;
            color: #64748b;
            text-align: center;
        }

        .dark-hint {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #aaa;
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

        @media (max-width: 860px) {
            .wrapper {
                grid-template-columns: 1fr;
                max-width: 420px;
            }

            .left {
                display: none;
            }

            .dark-hint {
                display: none
            }

            body.dark {
                background: #f1f5f9
            }

            body.dark .wrapper {
                filter: none
            }

            body.dark .right {
                opacity: 1;
                transform: none;
                pointer-events: auto
            }
        }
    </style>
</head>

<body class="dark" id="body">

    <div class="dark-hint" id="darkHint">
        <i class="fa-regular fa-lightbulb"></i>
        <div style="font-size:14px;font-weight:600;letter-spacing:1px"></div>
        <div style="font-size:11px;opacity:0.6;margin-top:6px"></div>
    </div>

    <div class="wrapper">
        <div class="left">
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
            <div class="firefly" style="left:18%;top:68%;animation-delay:0s"></div>
            <div class="firefly" style="left:30%;top:72%;animation-delay:0.4s;width:4px;height:4px"></div>
            <div class="firefly" style="left:45%;top:65%;animation-delay:0.8s"></div>
            <div class="firefly" style="left:60%;top:70%;animation-delay:1.2s;width:2px;height:2px"></div>
            <div class="firefly" style="left:25%;top:58%;animation-delay:0.2s"></div>
            <div class="firefly" style="left:55%;top:60%;animation-delay:0.6s;width:4px;height:4px"></div>
            <div class="firefly" style="left:70%;top:62%;animation-delay:1s"></div>
            <div class="firefly" style="left:20%;top:60%;animation-delay:1.4s"></div>
            <div class="firefly" style="left:38%;top:55%;animation-delay:1.8s"></div>
            <div class="firefly" style="left:65%;top:55%;animation-delay:0.1s;width:3px;height:3px"></div>
            <div class="firefly" style="left:32%;top:50%;animation-delay:0.5s"></div>
            <div class="firefly" style="left:50%;top:52%;animation-delay:0.9s;width:5px;height:5px"></div>

            <div class="brand">
                <div class="brand-icon"><i class="fa-solid fa-qrcode"></i></div>
                <h1>Student<br>Attendance System</h1>
                <p>Secure, fast, and reliable QR-based attendance tracking for modern schools.</p>
                <div class="features">
                    <div class="feat"><i class="fa-solid fa-bolt"></i> Fast QR Scanning</div>
                    <div class="feat"><i class="fa-solid fa-shield-halved"></i> Secure & Accurate</div>
                    <div class="feat"><i class="fa-solid fa-chart-line"></i> Real-time Reports</div>
                </div>
            </div>
            <div class="bottom-text">© 2026 SAS • Developed by Yarcia John Paul</div>
        </div>

        <div class="right">
            <div class="right-head">
                <h2>Welcome back</h2>
                <p>Please sign in to your account to continue.</p>
            </div>
            <?php if ($error != ""): ?>
                <div class="alert"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div><?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap"><i class="fa-regular fa-user"></i><input type="text" name="username"
                            class="form-control" placeholder="Enter your username" required></div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap"><i class="fa-solid fa-lock"></i><input type="password" name="password"
                            class="form-control" placeholder="Enter your password" required></div>
                </div>
                <button class="btn" name="login"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
            </form>
            <div style="margin-top:18px"></div>
            <div class="hint"><b>Username:</b> admin | <b>Password:</b> admin123</div>
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

            if (isOn) {
                body.classList.remove('dark');
            } else {
                body.classList.add('dark');
            }

            if (navigator.vibrate) navigator.vibrate(30);
        }

        pull.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleLamp();
        });

        darkHint.addEventListener('click', toggleLamp);


        <?php if ($error != ""): ?>
            body.classList.remove('dark');
            isOn = true;
        <?php endif; ?>
    </script>

</body>

</html>
<?php ob_end_flush(); ?>