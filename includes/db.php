<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_attendance";

$conn = @new mysqli($host, $user, $pass, $db);
// if wala pang DB, wag mag error
if ($conn->connect_error) {
    $conn = new mysqli($host, $user, $pass);
}
?>