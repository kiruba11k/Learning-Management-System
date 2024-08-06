<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LMS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 2s ease-in-out;
        }

        @keyframes slideIn {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>

<!-- Header -->
<?php
include_once('./header.php');

?>

<!-- About Section -->
<section class="container mb-5 fade-in" style="margin-top:150px">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <h2 class="fw-light">Our Mission</h2>
            <p>Our mission is to provide a comprehensive learning management system that caters to the needs of educators and students alike. We aim to make online learning engaging, accessible, and effective.</p>
        </div>
        <div class="col-lg-6 mb-4">
            <h2 class="fw-light">Our Vision</h2>
            <p>We envision a world where technology and education go hand in hand, providing opportunities for everyone to learn and grow. Our platform is designed to support this vision by offering tools and resources that enhance the learning experience.</p>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="container text-center mb-5">
    <h2 class="fw-light slide-in">Meet Our Team</h2>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6 mb-4" >
            <div class="card h-100">
                <img src="ceo5.jpg" class="card-img-top" alt="Team Member 1" >
                <div class="card-body">
                    <h5 class="card-title">John Doe</h5>
                    <p class="card-text">CEO</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <img src="ceo2.jpg" class="card-img-top" alt="Team Member 2">
                <div class="card-body">
                    <h5 class="card-title">Jane Smith</h5>
                    <p class="card-text">CTO</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <img src="ceo3.jpg" class="card-img-top" alt="Team Member 3">
                <div class="card-body">
                    <h5 class="card-title">Michael Brown</h5>
                    <p class="card-text">Lead Developer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <img src="ceo4.jpg" class="card-img-top" alt="Team Member 4">
                <div class="card-body">
                    <h5 class="card-title">Emily White</h5>
                    <p class="card-text">Designer</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php
include_once('./footer.php');

?>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
