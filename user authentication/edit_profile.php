<?php
session_start();
/* Legacy MySQL profile update disabled (Supabase + Node.js migration). */

// must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get updated data safely
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$student_staff_id = trim($_POST['student_staff_id']);

if (empty($full_name) || empty($email) || empty($student_staff_id)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: profile.php?edit=1");
    exit();
}

$_SESSION['error'] = "Profile updates are handled by the new backend (Supabase + Node.js).";

header("Location: profile.php");
exit();
?>
