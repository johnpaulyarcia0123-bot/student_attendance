<?php
session_start();
include '../includes/db.php';


// SAVE / UPDATE HOLIDAY - IMPORTANT

if (isset($_POST['save'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $date = $conn->real_escape_string($_POST['date']);
    $type = $conn->real_escape_string($_POST['type']);
    $id = $_POST['edit_id'] ?? '';

    if ($id != "" && is_numeric($id)) {
        // Update existing holiday
        $id = intval($id);
        $conn->query("UPDATE holidays SET name='$name', date='$date', type='$type' WHERE id=$id");
    } else {
        // Insert new holiday
        $conn->query("INSERT INTO holidays (name, date, type) VALUES ('$name','$date','$type')");
    }
    header("Location: holidays.php");
    exit;
}


// DELETE HOLIDAY - IMPORTANT - SECURED WITH INTVAL

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Security fix: prevent SQL injection
    $conn->query("DELETE FROM holidays WHERE id=$id");
    header("Location: holidays.php");
    exit;
}


// FETCH FOR EDIT

$edit_data = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']); // Security fix
    $edit_data = $conn->query("SELECT * FROM holidays WHERE id=$id")->fetch_assoc();
}

$holidays = $conn->query("SELECT * FROM holidays ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays | Student Attendance System</title>
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
            background: #2a3a4f;
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
            border-radius: 4px;
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
            background: white
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
            font-size: 13px
        }

        .ann-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .action-del {
            background: #ef4444;
            color: white;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 11px;
            text-decoration: none;
            margin-left: 6px
        }

        .action-edit {
            background: #f59e0b;
            color: white;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 11px;
            text-decoration: none
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-graduation-cap"></i> SAS</div>
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
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li class="active"><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i>
                    Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            <div class="label">Administration</div>
            <li><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:18px"><span><i class="fa-solid fa-bars"></i></span><span>Holidays</span></div>
            <div><i class="fa-regular fa-user"></i> Yarcia John Paul</div>
        </div>
        <div class="content">
            <div class="header">
                <h2>Holidays</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / Holidays</div>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-head">New Holiday</div>
                    <div class="card-body">
                        <form method="POST"><input type="hidden" name="edit_id"
                                value="<?php echo $edit_data['id'] ?? ''; ?>">
                            <div class="form-group"><label>Holiday Name <span>*</span></label><input type="text"
                                    name="name" class="form-control" value="<?php echo $edit_data['name'] ?? ''; ?>"
                                    required></div>
                            <div class="form-group"><label>Date <span>*</span></label><input type="date" name="date"
                                    class="form-control" value="<?php echo $edit_data['date'] ?? ''; ?>" required></div>
                            <div class="form-group"><label>Type</label><select name="type" class="form-control">
                                    <option value="Regular" <?php if (($edit_data['type'] ?? '') == 'Regular')
                                        echo 'selected'; ?>>Regular</option>
                                    <option value="Special" <?php if (($edit_data['type'] ?? '') == 'Special')
                                        echo 'selected'; ?>>Special</option>
                                </select></div>
                            <div style="margin-top:15px"><button class="btn btn-primary"
                                    name="save"><?php echo $edit_data ? 'Update Holiday' : 'Save Holiday'; ?></button><a
                                    href="holidays.php" class="btn btn-default">Clear</a></div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">Holidays List</div>
                    <div>
                        <?php if ($holidays->num_rows == 0) {
                            echo '<div class="empty">No holidays.</div>';
                        }
                        while ($h = $holidays->fetch_assoc()) { ?>
                            <div class="ann-item">
                                <div><b style="font-size:13px"><?php echo htmlspecialchars($h['name']); ?></b>
                                    <div style="font-size:11px;color:#64748b">
                                        <?php echo date('M d, Y', strtotime($h['date'])); ?> -
                                        <?php echo htmlspecialchars($h['type']); ?></div>
                                </div>
                                <div><a class="action-edit" href="holidays.php?edit=<?php echo $h['id']; ?>"><i
                                            class="fa-solid fa-pen"></i></a><a class="action-del"
                                        href="holidays.php?delete=<?php echo $h['id']; ?>"
                                        onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></a></div>
                            </div><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>