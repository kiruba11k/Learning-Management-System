<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>LMS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
    .student-name {
        margin-left: 5px;
        background-color: #0E46A3; /* Set the background color */
        color: white; /* Set the text color */
        border: none; /* Remove default button border */
        padding: 8px 12px; /* Adjust padding as needed */
        border-radius: 5px; /* Add border radius for rounded corners */
    }

    /* Style the dropdown menu */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Show the dropdown menu when the button is hovered over */
    .dropdown:hover .dropdown-content {
        display: block;
    }
    </style>
</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span>LMS</span>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
                <li><a class="nav-link scrollto" href="about.php">About</a></li>
                <li><a class="nav-link scrollto" href="courses.php">Courses</a></li>
                <li><a class="nav-link scrollto" href="contact.php">Contact</a></li>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo '<li class="dropdown"><button class="nav-link student-name">' . htmlspecialchars($_SESSION['name']) . '</button>';
                    echo '<ul class="dropdown-content">';
                    echo '<li><a href="Student/StudentProfile.php">Profile</a></li>';
                    echo '<li><a href="Student/myCourse.php">My Courses</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                    echo '</ul></li>';
                } else {
                    echo '<li><a class="getstarted scrollto" href="register.php">Get Started</a></li>';
                }
                ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->
</body>
</html>
