<?php
session_start();
include 'dbconnection.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin login check
    $admin_email = "admin@gmail.com";
    $admin_password = "123";

    if ($email == $admin_email && $password == $admin_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $admin_email;
        $_SESSION['name'] = "Admin";
        header("Location: Admin/adminDashboard.php");
        exit;
    }

    // Student login check
    $query = "SELECT * FROM student WHERE email = '$email' AND is_active = 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            header("Location: index.php");
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>Invalid password.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email or account not verified.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #a4d3e3;
            font-family: 'Arial', sans-serif;
        }
        .mb-4 {
            color: #0056b3;
        }
        .card {
            border-radius: 15px;
        }
        .card-body {
            position: relative;
            padding: 2rem;
        }
        .card-body h2 {
            font-weight: bold;
            color: #cdddef;
        }
        .btn-primary {
            background: #cdddef;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .rounded-3d {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15), 0 6px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .rounded-3d:hover {
            transform: translateY(-5px);
        }
        .form-control {
            border-radius: 10px;
            padding: 10px;
        }
        .form-group label i {
            margin-right: 10px;
        }
        .text-primary {
            color: #b4d2f4;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }
        .mt-5 {
            margin-top: 3rem;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .text-center {
            text-align: center;
        }
        .text-danger {
            display: none;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="bg1.gif" alt="Login Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow-lg rounded-3d mt-4" id="login-form">
                    <div class="card-body">
                        <h2 class="text-center mb-4" style="color: #0056b3;">Login</h2>
                        <div id="login-general-error" class="text-danger"></div>
                        <?= $msg; ?>
                        <form id="login-form-element" action="login.php" method="post">
                            <div class="form-group">
                                <label for="login-email"><i class="fas fa-envelope text-primary"></i> <span class="text-primary">Email</span></label>
                                <input type="email" class="form-control" id="login-email" name="email" required>
                                <div id="login-email-warning" class="text-danger">Email is required</div>
                            </div>
                            <div class="form-group">
                                <label for="login-password"><i class="fas fa-lock text-primary"></i> <span class="text-primary">Password</span></label>
                                <input type="password" class="form-control" id="login-password" name="password" required>
                                <div id="login-password-warning" class="text-danger">Password is required</div>
                            </div>
                            <button type="submit" name="login" id="login-button" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php" id="toggle-register">Don't have an account? Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginButton = document.getElementById('login-button');
            loginButton.addEventListener('click', function(event) {
                if (!validateLoginForm()) {
                    event.preventDefault();
                }
            });
        });

        function validateLoginForm() {
            var loginEmail = document.getElementById('login-email').value.trim();
            var loginPassword = document.getElementById('login-password').value.trim();
            var errorMessages = document.getElementsByClassName('text-danger');
            for (var i = 0; i < errorMessages.length; i++) {
                errorMessages[i].style.display = 'none';
            }
            var isValid = true;

            // Validate Login Email
            if (loginEmail === '') {
                document.getElementById('login-email-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Login Password
            if (loginPassword === '') {
                document.getElementById('login-password-warning').style.display = 'block';
                isValid = false;
            }

            // Display general error message if form is invalid
            if (!isValid) {
                document.getElementById('login-general-error').textContent = 'Please fill in all required fields.';
                document.getElementById('login-general-error').style.display = 'block';
            }

            return isValid;
        }
    </script>
</body>
</html>
