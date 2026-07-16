<?php
session_start();
include 'config.php';

// Check if user is logged in
$user_logged_in = isset($_SESSION['user_id']);

// Get facility ID from URL
$facility_id = $_GET['id'] ?? null;
if (!$facility_id) {
    header("Location: facilities.php");
    exit;
}

// Fetch facility details (include id!)
/* Legacy MySQL `$conn` lookup disabled (Supabase + Node.js migration). */
$facility = [
    'id' => (int)$facility_id,
    'facility_name' => 'Facility',
    'image' => '',
    'image2' => '',
    'full_description' => '',
    'environment' => '',
    'key_features' => '',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($facility['facility_name']) ?></title>
    <link rel="stylesheet" href="../style/facilities.css">
    <link rel="stylesheet" href="../style/index.css">
</head>
<body>

<header class="navbar">
  <div class="container nav-content">
    <a href="../homepage/index.php" class="logo-link">
      <img src="../images/mckl-logo.png" alt="MCKL Logo" class="logo">
    </a>

    <nav class="nav-links" id="navMenu">
    <a href="../homepage/index.php">HOME</a>
    <a href="facilities.php">FACILITIES</a>
    <a href="../Huijia/clubs.php">CLUBS</a>
    <a href="../events/events.php">EVENTS</a>
    <a href="../homepage/store.php">MERCHANDISE</a>

    </nav>

<div class="header-right">
    <a href="../farah_folder/contact.html" class="contact-btn">CONTACT US</a>

    <?php
    if(!isset($_SESSION['user_id'])) {
        echo '<a href="../user authentication/login.html" class="login-btn">LOGIN</a>';
        echo '<a href="../user authentication/signup.html" class="signup-btn">SIGN UP</a>';
    } else {
        echo '<a href="../user authentication/profile.php" class="profile-link">
                <img src="../images/profile.png" alt="Profile" class="profile-icon">
              </a>';
        echo '<a href="../user authentication/logout.php" class="logout-btn">LOGOUT</a>';
    }
    ?>

    <a href="cart.php" class="cart-link">
        <img src="../images/cart.png" alt="Cart" class="cart-icon">
    </a>

    <div class="menu-toggle" id="menuToggle">☰</div>
</div>
</header>

<div class="facility-details">

    <a class="back-btn" href="facilities.php" style="margin-top: 50px; display: inline-block;">← Back to Facilities</a>

    <h1><?= htmlspecialchars($facility['facility_name']) ?></h1>

    <div class="image-gallery">
        <?php
        $images = [$facility['image'], $facility['image2']];
        foreach ($images as $img) {
            if (!empty($img)) {
                // FIXED: Image path correctly uses ../
                echo '<img src="../images/facilities/' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($facility['facility_name']) . '">';
            }
        }
        ?>
    </div>

    <div class="facility-info">
        <p><?= nl2br(htmlspecialchars($facility['full_description'])) ?></p>
        <p><strong>Environment:</strong> <?= htmlspecialchars($facility['environment']) ?></p>
    </div>

    <div class="features-section">
        <h2>Key Features</h2>
        <div class="features-list">
            <?php 
            $features = explode("\n", $facility['key_features']); 
            foreach($features as $feature): ?>
                <div class="feature-item"><?= htmlspecialchars($feature) ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="booking-info">
        <?php if (strtolower($facility['facility_name']) === 'cafeteria'): ?>
            <p>This facility does not require reservation.</p>
        <?php else: ?>
            <p>
                Students can reserve here:
                <?php if ($user_logged_in): ?>
                    <a href="book.php?id=<?= $facility['id'] ?>" class="book-btn">Book Now!</a>
                <?php else: ?>
                    <a href="../user authentication/login.php?message=Please+log+in+to+book+this+facility">Book Now</a>
                <?php endif; ?>
            </p>
        <?php endif; ?> </div>

</div>

<footer class="footer" id="contact">
  <div class="container footer-content">

    <div class="footer-logo-container">
      <img src="../images/MCKL-logo 2.png" alt="MCKL Logo Footer" class="footer-logo">
    </div>

    <div class="footer-links">
      <div class="footer-contact">
        <h4>Contact Us</h4>
        <ul>
          <li><a href="mailto:admission.pg@mckl.edu.my">Email: admission.pg@mckl.edu.my</a></li>
          <li><a href="tel:+6042175088">Phone: +604 217 5088 (General line)</a></li>
          <li><a href="tel:+6046888327">Phone: +604 688 8327 (Course enquiry and registration)</a></li>
          <li><a href="https://maps.app.goo.gl/cgDzUFLMhm3RTrkD8" target="_blank">
            Address: Lebuhraya Pykett, 10400 George Town, Pulau Pinang</a></li>
        </ul>
      </div>

      <div class="footer-social">
        <h4>Follow Us</h4>
        <ul>
          <li><a href="https://www.facebook.com/MethodistCollegeKL/" target="_blank">Facebook</a></li>
          <li><a href="https://www.youtube.com/channel/UCnICekQMcPBPo24KylfP1AQ/featured" target="_blank">YouTube</a></li>
          <li><a href="https://www.instagram.com/methodistcollegekl/" target="_blank">Instagram</a></li>
          <li><a href="https://www.linkedin.com/school/methodist-college-kuala-lumpur/" target="_blank">LinkedIn</a></li>
        </ul>
      </div>
    </div>
  </div>

  <p class="copyright">© 2025 MCKL College Penang. All rights reserved.</p>
</footer>

</body>
</html>
