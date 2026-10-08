<?php
session_start();
include '../includes/db.php';

// AUTH CHECK  redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// SAVE LOGIC insert or update user
if (isset($_POST['save'])) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $_POST['password'];
    $role = $conn->real_escape_string($_POST['role'] ?? 'admin');
    $edit_id = $conn->real_escape_string($_POST['edit_id']);

    if ($edit_id != "") {
        // UPDATE EXISTING
        if ($password != "") {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET username='$username', password='$hashed', role='$role' WHERE id='$edit_id'");
        } else {
            $conn->query("UPDATE users SET username='$username', role='$role' WHERE id='$edit_id'");
        }
    } else {
        // INSERT NEW
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (username, password, role) VALUES ('$username','$hashed','$role')");
    }
    header("Location: users.php");
    exit;
}

// DELETE LOGIC prevent deleting main admin
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $check = $conn->query("SELECT username FROM users WHERE id='$id' LIMIT 1")->fetch_assoc();
    if ($check && $check['username'] != 'admin') {
        $conn->query("DELETE FROM users WHERE id='$id'");
    }
    header("Location: users.php");
    exit;
}

// EDIT FETCH
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $conn->real_escape_string($_GET['edit']);
    $res = $conn->query("SELECT * FROM users WHERE id='$id' LIMIT 1");
    if ($res)
        $edit_data = $res->fetch_assoc();
}

// LIST FETCH
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Users | QR A S</title>
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
            grid-template-columns: 380px 1fr;
            gap: 18px;
            align-items: start
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

        .form-group {
            margin-bottom: 12px
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            display: block;
            margin-bottom: 5px
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

        .btn-light {
            background: #e2e8f0;
            color: #333;
            text-decoration: none;
            margin-left: 6px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        th {
            background: #f8fafc;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9
        }

        .action {
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 11px;
            text-decoration: none;
            color: white;
            margin-right: 3px;
            display: inline-block
        }

        .edit {
            background: #f59e0b
        }

        .del {
            background: #ef4444
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
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> People</a></li>
            <li><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a></li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-diagram-project"></i> Departments /
                    Groups</a></li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li class="active"><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a>
            </li>
            <li><a class="link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div>System Users - <?php echo $users ? $users->num_rows : 0; ?> accounts</div>
            <div><i class="fa-solid fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="header">
                <h2>System Users</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / Users</div>
            </div>

            <div class="grid">
                // FORM SECTION
                <div class="card">
                    <div class="card-head"><?php echo $edit_data ? 'Edit User' : 'Add New User'; ?></div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">
                            <div class="form-group"><label>Username *</label><input type="text" name="username"
                                    class="form-control"
                                    value="<?php echo htmlspecialchars($edit_data['username'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group"><label>Password
                                    <?php echo $edit_data ? '(leave blank if no change)' : '*'; ?></label><input
                                    type="password" name="password" class="form-control" value=""
                                    placeholder="<?php echo $edit_data ? '••••••' : 'password'; ?>" <?php echo $edit_data ? '' : 'required'; ?>></div>
                            <div class="form-group"><label>Role</label><select name="role" class="form-control">
                                    <option value="admin" <?php if (($edit_data['role'] ?? '') == 'admin')
                                        echo 'selected'; ?>>Admin</option>
                                    <option value="teacher" <?php if (($edit_data['role'] ?? '') == 'teacher')
                                        echo 'selected'; ?>>Teacher</option>
                                    <option value="staff" <?php if (($edit_data['role'] ?? '') == 'staff')
                                        echo 'selected'; ?>>Staff</option>
                                </select></div>
                            <div style="margin-top:15px"><button class="btn btn-primary"
                                    name="save"><?php echo $edit_data ? 'Update User' : 'Save User'; ?></button><a
                                    href="users.php" class="btn btn-light">Clear</a></div>
                        </form>
                    </div>
                </div>

                // LIST SECTION
                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">Users List</div>
                    <div style="overflow-x:auto">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            // LIST LOOP
                            if ($users) {
                                while ($u = $users->fetch_assoc()) {
                                    $role_display = $u['role'] ?? 'admin';
                                    ?>
                                    <tr>
                                        <td><?php echo $u['id']; ?></td>
                                        <td><i class="fa-solid fa-user" style="color:#94a3b8"></i>
                                            <?php echo htmlspecialchars($u['username']); ?></td>
                                        <td><span
                                                style="background:#3b82f6;color:white;padding:2px 8px;border-radius:10px;font-size:11px"><?php echo htmlspecialchars($role_display); ?></span>
                                        </td>
                                        <td>
                                            <a class="action edit" href="users.php?edit=<?php echo $u['id']; ?>"><i
                                                    class="fa-solid fa-pen"></i></a>
                                            <?php if ($u['username'] != 'admin') { ?><a class="action del"
                                                    href="users.php?delete=<?php echo $u['id']; ?>"
                                                    onclick="return confirm('Delete this user?')"><i
                                                        class="fa-solid fa-trash"></i></a><?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>