<?php
include 'config.php';

/* Legacy MySQL `$conn` queries removed (Supabase + Node.js migration). */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Campus Facilities</title>
    <link rel="stylesheet" href="../style/facilities.css">
    <link rel="stylesheet" href="../style/index.css">
    <style>
        /* ---------- Facilities grid ---------- */
        .facility-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ---------- Clickable card wrapper ---------- */
        .facility-card-link {
            text-decoration: none;
            color: inherit;
        }

        .facility-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .facility-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .facility-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .facility-card h3 {
            margin: 15px;
            color: #002e6d;
        }

        .facility-card p {
            margin: 0 15px 15px 15px;
            font-size: 14px;
            color: #333;
        }

        .view-details {
            display: inline-block;
            margin: 0 15px 15px 15px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .view-details:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<header class="navbar">
  <div class="container nav-content">
    <a href="../homepage/index.php" class="logo-link">
      <img src="../images/mckl-logo.png" alt="MCKL Logo" class="logo">
    </a>

    <nav class="nav-links" id="navMenu">
      <a href="../homepage/index.php">HOME</a>
      <a href="facilities.php">FACILITIES</a>
      <a href="../HuiJia/clubs.php">CLUBS</a>
      <a href="../events/events.php">EVENTS</a>
      <a href="../homepage/store.php">MERCHANDISE</a>
    </nav>

<div class="header-right">
    <a href="../farah_folder/contact.html" class="contact-btn">CONTACT US</a>

    <?php
    session_start();
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

<body>

<h2 style="text-align:center; color:#002e6d; margin-top: 30px;">Campus Facilities</h2>

<div class="facility-grid">
<!--
  Legacy PHP/MySQL `$conn` block disabled (Supabase + Node.js migration).
  Previously rendered facilities list from MySQL.
-->
</div>

</body>
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

</html>

