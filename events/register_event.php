<?php
session_start();
/* Legacy MySQL registration disabled (Supabase + Node.js migration). */

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user authentication/login.html?warning=1");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get event ID from URL
$event_id = $_GET['event'] ?? 0;

if (!$event_id) {
    $_SESSION['error'] = "Invalid event selection!";
    header("Location: events.php");
    exit();
}

$_SESSION['error'] = "Event registration is handled by the new backend (Supabase + Node.js).";


header("Location: events.php");
exit();
?>
