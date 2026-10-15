<?php
session_start();
include '../includes/db.php';

// ============================
// SAVE OR UPDATE ANNOUNCEMENT - IMPORTANT
// This handles both creating new and updating existing announcement
// ============================
if (isset($_POST['save'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $message = $conn->real_escape_string($_POST['message']);
    $status = $conn->real_escape_string($_POST['status']);
    $id = $_POST['edit_id'];

    // Handle datetime - convert empty to NULL to avoid SQL error
    $starts = !empty($_POST['starts']) ? "'" . $conn->real_escape_string($_POST['starts']) . "'" : "NULL";
    $ends = !empty($_POST['ends']) ? "'" . $conn->real_escape_string($_POST['ends']) . "'" : "NULL";

    if ($id != "") {
        // UPDATE EXISTING RECORD
        $conn->query("UPDATE announcements SET title='$title', message='$message', starts_at=$starts, ends_at=$ends, status='$status' WHERE id='$id'");
    } else {
        // INSERT NEW RECORD
        $conn->query("INSERT INTO announcements (title, message, starts_at, ends_at, status) VALUES ('$title','$message',$starts,$ends,'$status')");
    }
    header("Location: announcements.php");
    exit;
}


// DELETE ANNOUNCEMENT - IMPORTANT

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM announcements WHERE id='$id'");
    header("Location: announcements.php");
    exit;
}


// FETCH DATA FOR EDIT FORM

$edit_data = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_data = $conn->query("SELECT * FROM announcements WHERE id='$id'")->fetch_assoc();
}


// FETCH ALL ANNOUNCEMENTS FOR LISTING

$announcements = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Announcements | Student Attendance System</title>
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

        .sidebar.logo {
            padding: 15px;
            color: white;
            font-size: 16px;
            border-bottom: 1px solid #334155;
            display: flex;
            gap: 8px;
            align-items: center;
            font-weight: 600
        }

        .sidebar.profile {
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
            cursor: pointer;
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

        .sidebar.label {
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

        textarea.form-control {
            height: 120px;
            resize: vertical
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px
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
            font-size: 13px;
            text-align: left
        }

        .ann-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9
        }

        .ann-item:last-child {
            border-bottom: none
        }

        .action-del {
            background: #ef4444;
            color: white;
            padding: 3px 7px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 11px;
            margin-left: 6px;
            text-decoration: none
        }

        .action-edit {
            background: #f59e0b;
            color: white;
            padding: 3px 7px;
            border-radius: 3px;
            cursor: pointer;
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
                <i class="fa-solid fa-user" style="font-size:12px"></i>
            </div>
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
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li class="active"><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i>
                    Announcements</a></li>
            <div class="label">Administration</div>
            <li><a class="link" href="users.php"><i class="fa-solid fa-users-gear"></i> System Users</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;gap:18px;align-items:center">
                <span><i class="fa-solid fa-bars"></i></span>
                <span><i class="fa-solid fa-qrcode"></i> Scanner</span>
                <span><i class="fa-solid fa-tv"></i> Public Kiosk</span>
            </div>
            <div style="display:flex;gap:15px;align-items:center"><i class="fa-regular fa-bell"></i><span><i
                        class="fa-regular fa-user"></i> Yarcia John Paul</span></div>
        </div>

        <div class="content">
            <div class="header">
                <h2>System Announcements</h2>
                <div style="font-size:13px;color:#64748b"><a href="dashboard.php"
                        style="color:#3b82f6;text-decoration:none">Home</a> / System Announcements</div>
            </div>

            <div class="grid">
                
                <div class="card">
                    <div class="card-head">New Announcement</div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">
                            <div class="form-group"><label>Title <span>*</span></label><input type="text" name="title"
                                    class="form-control" value="<?php echo $edit_data['title'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group"><label>Message <span>*</span></label><textarea name="message"
                                    class="form-control" required><?php echo $edit_data['message'] ?? ''; ?></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group"><label>Starts At</label><input type="datetime-local"
                                        name="starts" class="form-control"
                                        value="<?php echo isset($edit_data['starts_at']) ? date('Y-m-d\TH:i', strtotime($edit_data['starts_at'])) : ''; ?>">
                                </div>
                                <div class="form-group"><label>Ends At</label><input type="datetime-local" name="ends"
                                        class="form-control"
                                        value="<?php echo isset($edit_data['ends_at']) ? date('Y-m-d\TH:i', strtotime($edit_data['ends_at'])) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group"><label>Status</label>
                                <select name="status" class="form-control">
                                    <option <?php if (($edit_data['status'] ?? '') == 'Active')
                                        echo 'selected'; ?>>Active
                                    </option>
                                    <option <?php if (($edit_data['status'] ?? '') == 'Inactive')
                                        echo 'selected'; ?>>
                                        Inactive</option>
                                </select>
                            </div>
                            <div style="margin-top:15px">
                                <button class="btn btn-primary"
                                    name="save"><?php echo $edit_data ? 'Update Announcement' : 'Save Announcement'; ?></button>
                                <a href="announcements.php" class="btn btn-default">Clear</a>
                            </div>
                        </form>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-head" style="border-top:3px solid #fff">System Announcements</div>
                    <div id="annList">
                        <?php if ($announcements->num_rows == 0) {
                            echo '<div class="empty">No announcements.</div>';
                        }
                        while ($a = $announcements->fetch_assoc()) {
                            $start = $a['starts_at'] ? date('M d, Y h:i A', strtotime($a['starts_at'])) : 'Now';
                            $end = $a['ends_at'] ? date('M d, Y h:i A', strtotime($a['ends_at'])) : 'No end'; ?>
                            <div class="ann-item">
                                <div style="display:flex;justify-content:space-between">
                                    <div><b style="font-size:13px"><?php echo htmlspecialchars($a['title']); ?></b>
                                        <div style="font-size:11px;color:#64748b"><?php echo $start; ?> →
                                            <?php echo $end; ?></div>
                                    </div>
                                    <div>
                                        <a class="action-edit" href="announcements.php?edit=<?php echo $a['id']; ?>"><i
                                                class="fa-solid fa-pen"></i></a>
                                        <a class="action-del" href="announcements.php?delete=<?php echo $a['id']; ?>"
                                            onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </div>
                                <div style="font-size:13px;color:#334155;margin-top:8px">
                                    <?php echo nl2br(htmlspecialchars($a['message'])); ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div style="margin-top:30px;font-size:11px;color:#94a3b8;text-align:right">© 2026 Student Attendance System by Yarcia John Paul</div>
            </div>
        </div>
    </div>
</body>

</html>