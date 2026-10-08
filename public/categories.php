<?php
session_start();
include '../includes/db.php';

$message = "";


// ADD NEW CATEGORY - IMPORTANT
// Checks for duplicate before inserting

if (isset($_POST['add_cat'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description'] ?? '');

    // Check duplicate
    $check = $conn->query("SELECT * FROM categories WHERE name='$name' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $message = "<div style='background:#fef3c7;color:#92400e;padding:10px;border-radius:4px;margin-bottom:10px'>Category $name already exists!</div>";
    } else {
        // Check if description column exists - IMPORTANT FOR COMPATIBILITY
        $col_check = $conn->query("SHOW COLUMNS FROM categories LIKE 'description'");
        if ($col_check && $col_check->num_rows > 0) {
            $conn->query("INSERT INTO categories (name, description) VALUES ('$name', '$desc')");
        } else {
            $conn->query("INSERT INTO categories (name) VALUES ('$name')");
        }
        $message = "<div style='background:#dcfce7;color:#166534;padding:10px;border-radius:4px;margin-bottom:10px'>Added: $name</div>";
    }
}


// DELETE CATEGORY - IMPORTANT

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Using intval for safety
    $conn->query("DELETE FROM categories WHERE id='$id'");
    header("Location: categories.php");
    exit;
}


// FETCH ALL CATEGORIES

$cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Student Attendance System</title>
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
            background: #ecf0f5;
            min-height: 100vh
        }

        .sidebar {
            width: 230px;
            background: #222d32;
            min-height: 100vh;
            color: #b8c7ce;
            position: fixed
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

        .box {
            background: white;
            border-radius: 3px;
            border-top: 3px solid #3c8dbc;
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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d2d6de;
            border-radius: 3px;
            font-size: 13px;
            height: 38px
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 3px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 600
        }

        .btn-blue {
            background: #3c8dbc;
            color: white
        }

        .btn-red {
            background: #dd4b39;
            color: white
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .table th {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 2px solid #f4f4f4;
            color: #666;
            background: #fafafa
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #f4f4f4
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="admin-box">
            <div
                style="width:40px;height:40px;background:#d2d6de;border-radius:50%;display:flex;justify-content:center;align-items:center">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <div style="color:white;font-size:13px;font-weight:600">admin</div>
                <div style="font-size:11px">Super Administrator</div>
            </div>
        </div>
        <ul>
            <li><a class="link" href="dashboard.php"><i class="fa-solid fa-table-columns"></i> Dashboard</a></li>
            <li><a class="link" href="scanner.php"><i class="fa-solid fa-qrcode"></i> QR Scanner</a></li>
            <div class="label">Attendance</div>
            <li><a class="link" href="attendance_logs.php"><i class="fa-solid fa-clipboard-check"></i> Attendance
                    Logs</a></li>
            <li><a class="link" href="reports.php"><i class="fa-solid fa-chart-bar"></i> Reports & Export</a></li>
            <div class="label">People & Rules</div>
            <li><a class="link" href="students.php"><i class="fa-solid fa-users"></i> Students</a></li>
            <li class="active"><a class="link" href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a>
            </li>
            <li><a class="link" href="departments.php"><i class="fa-solid fa-building"></i> Departments / Groups</a>
            </li>
            <li><a class="link" href="schedules.php"><i class="fa-solid fa-calendar"></i> Schedules</a></li>
            <li><a class="link" href="holidays.php"><i class="fa-solid fa-umbrella-beach"></i> Holidays</a></li>
            <li><a class="link" href="announcements.php"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="content">
            <h2 style="font-weight:400;margin-bottom:15px;font-size:22px">Categories - BSCS Year & Section <span
                    style="float:right;font-size:12px;color:#777;margin-top:8px"><a href="dashboard.php"
                        style="color:#3c8dbc;text-decoration:none">Home</a> / Categories</span></h2>
            <?php echo $message; ?>
            <div class="box">
                <div class="box-head">Add Category</div>
                <div class="box-body">
                    <form method="POST">
                        <div class="form-grid">
                            <div>
                                <label style="font-size:12px">Category Name</label>
                                <select name="name" class="form-control" required>
                                    <option value="">-- Select BSCS Section --</option>
                                    <option value="BSCS 1A">BSCS 1A</option>
                                    <option value="BSCS 1B">BSCS 1B</option>
                                    <option value="BSCS 2A">BSCS 2A</option>
                                    <option value="BSCS 2B">BSCS 2B</option>
                                    <option value="BSCS 3A">BSCS 3A</option>
                                    <option value="BSCS 3B">BSCS 3B</option>
                                    <option value="BSCS 4A">BSCS 4A</option>
                                    <option value="BSCS 4B">BSCS 4B</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:12px">Description (Optional)</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="e.g. First Year Section A">
                            </div>
                        </div>
                        <button type="submit" name="add_cat" class="btn btn-blue" style="margin-top:12px;width:100%"><i
                                class="fa-solid fa-plus"></i> Add Category</button>
                    </form>
                </div>
            </div>

            <div class="box">
                <div class="box-head">All Categories (<?php echo $cats ? $cats->num_rows : 0; ?>)</div>
                <div class="box-body" style="padding:0">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <?php if ($cats && $cats->num_rows > 0):
                            while ($c = $cats->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $c['id']; ?></td>
                                    <td><b><?php echo htmlspecialchars($c['name']); ?></b></td>
                                    <td><?php echo htmlspecialchars($c['description'] ?? ''); ?></td>
                                    <td><a href="?delete=<?php echo $c['id']; ?>" onclick="return confirm('Delete?')"
                                            class="btn btn-red" style="padding:4px 8px;font-size:11px"><i
                                                class="fa-solid fa-trash"></i> Delete</a></td>
                                </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center;padding:20px;color:#999">No categories yet</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>