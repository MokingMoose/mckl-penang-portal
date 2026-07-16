<?php
session_start();
include 'config.php';

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user authentication/login.php?message=Please+log+in+to+book+a+facility");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Get facility ID from URL
$facility_id = $_GET['id'] ?? null;
if (!$facility_id) {
    header("Location: facilities.php");
    exit;
}

// 3. Fetch facility details (legacy MySQL disabled)
$facility = [
    'id' => (int)$facility_id,
    'facility_name' => 'Facility',
    'image' => '',
    'full_description' => '',
];

// 4. Handle booking form submission
$feedback = '';
$feedback_type = ''; // 'success' or 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_date = $_POST['date'];
    $booking_time = $_POST['time'];
    $booking_datetime = strtotime("$booking_date $booking_time");

    if ($booking_datetime < time()) {
        $feedback = "You cannot book a facility in the past.";
        $feedback_type = "error";
    } else {
        /* Legacy MySQL `$conn` booking check/insert disabled (Supabase + Node.js migration). */
        $feedback = "Booking is handled by the new backend (Supabase + Node.js).";
        $feedback_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book <?= htmlspecialchars($facility['facility_name']) ?></title>
    <link rel="stylesheet" href="../style/facilities.css">
    <link rel="stylesheet" href="../style/index.css">
    <style>
        /* Simple internal styles for the booking form */
        .booking-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background-color: #002D72; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; border-radius: 4px; width: 100%; }
        .btn-submit:hover { background-color: #001f52; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .facility-preview img { max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px; }
    </style>
</head>
<body>

<header class="navbar">
    <div class="container nav-content">
        <a href="../homepage/index.php" class="logo-link"><img src="../images/mckl-logo.png" alt="Logo" class="logo"></a>
        <nav class="nav-links">
            <a href="facilities.php">BACK TO FACILITIES</a>
        </nav>
    </div>
</header>

<div class="booking-container">
    
    <h2>Book <?= htmlspecialchars($facility['facility_name']) ?></h2>

    <div class="facility-preview">
        <?php if (!empty($facility['image'])): ?>
            <img src="../images/facilities/<?= htmlspecialchars($facility['image']) ?>" alt="Facility Image">
        <?php endif; ?>
    </div>

    <?php if ($feedback): ?>
        <div class="message <?= $feedback_type ?>">
            <?= htmlspecialchars($feedback) ?>
            <?php if ($feedback_type == 'success'): ?>
                <br><a href="../user authentication/profile.php">View My Bookings</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="date">Select Date:</label>
            <input type="date" name="date" required min="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label for="time">Select Time:</label>
            <input type="time" name="time" required>
        </div>

        <button type="submit" class="btn-submit">Confirm Booking</button>
    </form>

    <br>
    <a href="facilities.php" style="text-decoration: none; color: #555;">&larr; Cancel and go back</a>

</div>

<footer class="footer">
    <p class="copyright">© 2025 MCKL College Penang. All rights reserved.</p>
</footer>

</body>
</html>
