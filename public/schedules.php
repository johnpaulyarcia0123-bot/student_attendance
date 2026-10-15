<?php
session_start();
include '../includes/db.php';

// AUTH CHECK redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// SAVE LOGIC insert or update schedule
if (isset($_POST['save'])) {
    $title = $conn->real_escape_string(trim($_POST['title']));
    $time_in = $_POST['time_in'] ?: '08:00:00';
    $time_out = $_POST['time_out'] ?: '17:00:00';
    $id = $_POST['edit_id'];

    if ($id != "") {
        // UPDATE EXISTING edit mode
        $id = $conn->real_escape_string($id);
        $conn->query("UPDATE schedules SET title='$title', time_in='$time_in', time_out='$time_out' WHERE id='$id'");
    } else {
        // INSERT NEW create mode
        $conn->query("INSERT INTO schedules (title, time_in, time_out) VALUES ('$title','$time_in','$time_out')");
    }
    header("Location: schedules.php");
    exit;
}

// DELETE LOGIC remove schedule by id
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM schedules WHERE id='$id'");
    header("Location: schedules.php");
    exit;
}

// EDIT FETCH get data for editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $conn->real_escape_string($_GET['edit']);
    $result = $conn->query("SELECT * FROM schedules WHERE id='$id' LIMIT 1");
    if ($result)
        $edit_data = $result->fetch_assoc();
}

// LIST FETCH get all schedules
$schedules = $conn->query("SELECT * FROM schedules ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules | QR A S</title>
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
            background: #1e293b;
            min-height: 100vh;
            color: #94a3b8;
            position: fixed;
            overflow-y: auto
        }

        .logo {
            padding: 15px;
            color: white;
            font-size: 16px;
            border-bottom: 1px solid #334155;
            display: flex;
            gap: 8px;
            align-items: center;
            font-weight: 600
        }

        .profile {
            padding: 12px 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            border-bottom: 1px solid #334155
        }

        .sidebar ul {
            list-style: none;
            padding-bottom: 20px
        }

        .sidebar li {
            padding: 10px 15px;
            font-size: 13px;
            display: flex;
            gap: 10px;
            align-items: center;
            color: #94a3b8
        }

        .sidebar li:hover {
            background: #334155;
            color: white
        }

        .sidebar li.active {
            background: #3b82f6;
            color: white;
            border-radius: 5px;
            margin: 5px 8px
        }

        .label {
            padding: 14px 15px 5px 15px;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px
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
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            font-size: 13px;
            color: #666
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
            font-weight: 500;
            color: #1e293b
        }

        .grid {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 18px;
            align-items: start
        }

        .card {
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            overflow: hidden
        }

        .card-head {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            background: white;
            border-top: 3px solid #3b82f6
        }

        .card-body {
            padding: 15px
        }

        .form-group {
            margin-bottom: 14px
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #1e293b
        }

        .form-group label span {
            color: #ef4444
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 13px;
            height: 36px;
            background: white;
            outline: none
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1)
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

        .btn-primary:hover {
            background: #2563eb
        }

        .btn-default {
            background: #e2e8f0;
            color: #334155;
            margin-left: 6px;
            text-decoration: none;
            display: inline-block
        }

        .empty {
            padding: 25px 15px;
            color: #94a3b8;
            font-size: 13px;
            text-align: center
        }

        .ann-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .ann-item:hover {
            background: #f8fafc
        }

        .action-del {
            background: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            text-decoration: none;
            margin-left: 6px
        }

        .action-edit {
            background: #f59e0b;
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            text-decoration: none
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-qrcode"></i> QR A S</div>
        <div class="profile">
            <div
                style="width:32px;height:32px;background:#334155;border-radius:50%;display:flex;justify-content:center;align-items:center;color:white">
                <i class="fa-solid fa-user" style="font-size:12px"></i></div>
            <div>
                <div style="color:white;font-size:12px;font-weight:600">Yarcia John Paul</div>
                <div style="font-size:10px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
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
            <li class="active"><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a>
            </li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:18px"><span><i class="fa-solid fa-bars"></i></span><span>Schedules</span></div>
            <div><i class="fa-regular fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="header">
                <h2>Schedules</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / Schedules</div>
            </div>

            <div class="grid">
                
                <div class="card">
                    <div class="card-head"><?php echo $edit_data ? 'Edit Schedule' : 'New Schedule'; ?></div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">
                            <div class="form-group"><label>Schedule Title <span>*</span></label><input type="text"
                                    name="title" class="form-control"
                                    value="<?php echo htmlspecialchars($edit_data['title'] ?? ''); ?>"
                                    placeholder="e.g. Monday - Morning Shift" required></div>
                            <div class="form-group"><label>Time In</label><input type="time" name="time_in"
                                    class="form-control" value="<?php echo $edit_data['time_in'] ?? ''; ?>"></div>
                            <div class="form-group"><label>Time Out</label><input type="time" name="time_out"
                                    class="form-control" value="<?php echo $edit_data['time_out'] ?? ''; ?>"></div>
                            <div style="margin-top:15px"><button class="btn btn-primary"
                                    name="save"><?php echo $edit_data ? 'Update Schedule' : 'Save Schedule'; ?></button><a
                                    href="schedules.php" class="btn btn-default">Clear</a></div>
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">Schedules List</div>
                    <div>
                        <?php
                        // LIST LOOP  render all schedules
                        if (!$schedules || $schedules->num_rows == 0) {
                            echo '<div class="empty">No schedules found.</div>';
                        } else {
                            while ($s = $schedules->fetch_assoc()) {
                                $title = $s['title'] ?? $s['name'] ?? 'Untitled Schedule';
                                $t_in = $s['time_in'] ?? '08:00:00';
                                $t_out = $s['time_out'] ?? '17:00:00';
                                $in_fmt = $t_in ? date('h:i A', strtotime($t_in)) : 'N/A';
                                $out_fmt = $t_out ? date('h:i A', strtotime($t_out)) : 'N/A';
                                ?>
                                <div class="ann-item">
                                    <div><b style="font-size:13px"><?php echo htmlspecialchars($title); ?></b>
                                        <div style="font-size:11px;color:#64748b"><?php echo $in_fmt; ?> -
                                            <?php echo $out_fmt; ?></div>
                                    </div>
                                    <div>
                                        <a class="action-edit" href="schedules.php?edit=<?php echo $s['id']; ?>"><i
                                                class="fa-solid fa-pen"></i></a>
                                        <a class="action-del" href="schedules.php?delete=<?php echo $s['id']; ?>"
                                            onclick="return confirm('Delete this schedule?')"><i
                                                class="fa-solid fa-trash"></i></a>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>