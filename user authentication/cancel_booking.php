<?php
session_start();
/* Legacy MySQL booking cancel disabled (Supabase + Node.js migration). */

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $_SESSION['error'] = "Booking cancellations are handled by the new backend (Supabase + Node.js).";
}

// 3. Redirect back to profile
header("Location: profile.php");
exit();
?>
