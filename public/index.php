<?php
session_start();
if (isset($_SESSION['bscs_admin'])) {
    header("Location: dashboard.php");
    exit;
}
if (isset($_GET['login']) && $_GET['login'] === 'success') {
    $_SESSION['bscs_admin'] = $_GET['user'] ?? 'Yarcia John Paul';
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student QR Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: #2c3e50; min-height: 100vh; display:flex; flex-direction:column; justify-content:center; align-items:center; }
        .login-title { color: #ecf0f1; font-size: 34px; font-weight: 300; margin-bottom: 28px; letter-spacing: 0.2px; text-shadow: 0 1px 2px rgba(0,0,0,0.2); }
        .login-title b { font-weight: 700; color: white; }
        .login-card { background: white; width: 360px; padding: 20px 25px 18px 25px; border-radius: 3px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
        .login-subtitle { text-align:center; color: #666; font-size: 14px; margin-bottom: 18px; font-weight: 400; }
        .form-group { position: relative; margin-bottom: 15px; }
        .form-control { width: 100%; padding: 9px 35px 9px 12px; border: 1px solid #d2d6de; border-radius: 0px; font-size: 14px; outline:none; height: 36px; color: #555; }
        .form-control:focus { border-color: #3c8dbc; }
        .form-group i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #777; font-size: 14px; }
        .btn-signin { width: 100%; background: #0b7af5; color: white; border: none; padding: 7px; border-radius: 3px; font-size: 14px; cursor: pointer; font-weight: 400; height: 36px; margin-top: 2px; }
        .btn-signin:hover { background: #0b6ddb; }
        .forgot-link { color: #3c8dbc; font-size: 13px; text-decoration: none; display: inline-block; margin-top: 14px; }
        .forgot-link:hover { text-decoration: underline; }
        .divider { border-top: 1px solid #eee; margin: 18px 0 16px 0; }
        .btn-kiosk { width: 100%; background: white; color: #00a65a; border: 1px solid #7ac99a; padding: 7px; border-radius: 3px; font-size: 13px; cursor: pointer; display:flex; justify-content:center; align-items:center; gap:6px; height: 34px; font-weight: 400; }
        .btn-kiosk:hover { background: #eafff3; }
        .footer-note { color: #8aa0b8; font-size: 12px; margin-top: 20px; letter-spacing: 0.1px; }
    </style>
</head>
<body>
    <h1 class="login-title">Student <b>QR</b> Attendance</h1>
    <div class="login-card">
        <p class="login-subtitle">Sign in to manage attendance</p>
        <form onsubmit="return doLogin(event)">
            <div class="form-group">
                <input type="text" class="form-control" id="username" placeholder="Email or username" required value="admin">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password" required value="admin">
                <i class="fa-solid fa-lock"></i>
            </div>
            <button type="submit" class="btn-signin">Sign In</button>
        </form>
        <a href="#" class="forgot-link">Forgot password?</a>
        <div class="divider"></div>
        <button class="btn-kiosk" type="button" onclick="window.location.href='kiosk.php'">
            <i class="fa-solid fa-table-cells"></i> Open Attendance Kiosk
        </button>
    </div>
    <p class="footer-note">Secure role-based attendance management</p>

<script>
function doLogin(e){
    e.preventDefault();
    const user = document.getElementById('username').value.trim();
    const pass = document.getElementById('password').value.trim();
    if(user && pass){
        localStorage.setItem('bscs_is_logged_in', 'true');
        localStorage.setItem('bscs_current_user', user);
        window.location.href = 'index.php?login=success&user=' + encodeURIComponent(user);
        return false;
    }
    alert('Lagay mo username at password pre!');
    return false;
}
</script>
</body>
</html>