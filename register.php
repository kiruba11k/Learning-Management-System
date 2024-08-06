<<<<<<< HEAD
<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'dbconnection.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $passingYear = $_POST['passing_year'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        $sql = "INSERT INTO student (name, email, dob, college, department, passing_year, password, activation_code, is_active) 
                VALUES ('{$name}', '{$email}', '{$dob}', '{$college}', '{$department}', '{$passingYear}', '{$password}', '{$code}', 0)";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<div style='display: none;'>";
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'kirubakiruba11112002@gmail.com';       // SMTP username
                $mail->Password   = 'uqcr cjrq gfdf vpxe';                  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                $mail->Port       = 465;                                    // TCP port to connect to

                // Recipients
                $mail->setFrom('kiruba11geo@gmail.com');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Account Verification';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/LMS1/verify.php?code='.$code.'"> Click here to Verify </a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";
            $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login</title>
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
                <img src="bg1.gif" alt="Registration Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow-lg rounded-3d" id="register-form">
                    <div class="card-body">
                        <h2 class="text-center mb-4" style="color: #0056b3;">Register</h2>
                        <?php if ($msg) echo $msg; ?>
                        <div id="general-error" class="text-danger"></div>
                        <form action="register.php" method="post" onsubmit="return validateForm()">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name"><i class="fas fa-user text-primary"></i> <span class="text-primary">Name</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div id="name-warning" class="text-danger">Name is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email"><i class="fas fa-envelope text-primary"></i> <span class="text-primary">Email</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div id="email-warning" class="text-danger">Email is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="dob"><i class="fas fa-calendar-alt text-primary"></i> <span class="text-primary">Date of Birth</span></label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                    <div id="dob-warning" class="text-danger">Date of Birth is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="college"><i class="fas fa-school text-primary"></i> <span class="text-primary">College</span></label>
                                    <input type="text" class="form-control" id="college" name="college" required>
                                    <div id="college-warning" class="text-danger">College is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="department"><i class="fas fa-building text-primary"></i> <span class="text-primary">Department</span></label>
                                    <input type="text" class="form-control" id="department" name="department" required>
                                    <div id="department-warning" class="text-danger">Department is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="passing-year"><i class="fas fa-graduation-cap text-primary"></i> <span class="text-primary">Passing Year</span></label>
                                    <input type="number" class="form-control" id="passing-year" name="passing_year" required>
                                    <div id="passing-year-warning" class="text-danger">Passing Year is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password"><i class="
                                    fas fa-lock text-primary"></i> <span class="text-primary">Password</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div id="password-warning" class="text-danger">Password is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password"><i class="fas fa-lock text-primary"></i> <span class="text-primary">Confirm Password</span></label>
                                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                                    <div id="confirm-password-warning" class="text-danger">Confirm Password is required</div>
                                    <div id="password-match-warning" class="text-danger">Passwords do not match</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="terms.html">Terms and Policy</a>
                                    </label>
                                    <div id="terms-warning" class="text-danger">You must agree to the terms and policy</div>
                                </div>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-block" id="register-button">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" id="toggle-login">Already have an account? Login</a>
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
            var registerButton = document.getElementById('register-button');
            registerButton.addEventListener('click', function(event) {
                if (validateForm()) {
                    document.querySelector('form').submit(); // Submit the form if validation passes
                }
            });
        });

        function validateForm() {
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var dob = document.getElementById('dob').value.trim();
            var college = document.getElementById('college').value.trim();
            var department = document.getElementById('department').value.trim();
            var passingYear = document.getElementById('passing-year').value.trim();
            var password = document.getElementById('password').value.trim();
            var confirmPassword = document.getElementById('confirm-password').value.trim();
            var termsChecked = document.getElementById('terms').checked;

            // Reset all previous error messages
            var errorMessages = document.getElementsByClassName('text-danger');
            for (var i = 0; i < errorMessages.length; i++) {
                errorMessages[i].style.display = 'none';
            }

            var isValid = true;

            // Validate Name
            if (name === '') {
                document.getElementById('name-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Email
            if (email === '') {
                document.getElementById('email-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Date of Birth
            if (dob === '') {
                document.getElementById('dob-warning').style.display = 'block';
                isValid = false;
            }

            // Validate College
            if (college === '') {
                document.getElementById('college-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Department
            if (department === '') {
                document.getElementById('department-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Passing Year
            if (passingYear === '') {
                document.getElementById('passing-year-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Password
            if (password === '') {
                document.getElementById('password-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Confirm Password
            if (confirmPassword === '') {
                document.getElementById('confirm-password-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Password Match
            if (password !== confirmPassword) {
                document.getElementById('password-match-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Terms and Policy Agreement
            if (!termsChecked) {
                document.getElementById('terms-warning').style.display = 'block';
                isValid = false;
            }

            // Display general error message if form is invalid
            if (!isValid) {
                document.getElementById('general-error').textContent = 'Please fill in all required fields.';
                document.getElementById('general-error').style.display = 'block';
            } else {
                document.getElementById('general-error').style.display = 'none';
            }

            return isValid;
        }
    </script>
</body>
</html>
=======
<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'dbconnection.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $passingYear = $_POST['passing_year'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        $sql = "INSERT INTO student (name, email, dob, college, department, passing_year, password, activation_code, is_active) 
                VALUES ('{$name}', '{$email}', '{$dob}', '{$college}', '{$department}', '{$passingYear}', '{$password}', '{$code}', 0)";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<div style='display: none;'>";
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'kirubakiruba11112002@gmail.com';       // SMTP username
                $mail->Password   = 'uqcr cjrq gfdf vpxe';                  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                $mail->Port       = 465;                                    // TCP port to connect to

                // Recipients
                $mail->setFrom('kiruba11geo@gmail.com');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Account Verification';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/LMS1/verify.php?code='.$code.'"> Click here to Verify </a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";
            $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login</title>
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
                <img src="bg1.gif" alt="Registration Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow-lg rounded-3d" id="register-form">
                    <div class="card-body">
                        <h2 class="text-center mb-4" style="color: #0056b3;">Register</h2>
                        <?php if ($msg) echo $msg; ?>
                        <div id="general-error" class="text-danger"></div>
                        <form action="register.php" method="post" onsubmit="return validateForm()">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name"><i class="fas fa-user text-primary"></i> <span class="text-primary">Name</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div id="name-warning" class="text-danger">Name is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email"><i class="fas fa-envelope text-primary"></i> <span class="text-primary">Email</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div id="email-warning" class="text-danger">Email is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="dob"><i class="fas fa-calendar-alt text-primary"></i> <span class="text-primary">Date of Birth</span></label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                    <div id="dob-warning" class="text-danger">Date of Birth is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="college"><i class="fas fa-school text-primary"></i> <span class="text-primary">College</span></label>
                                    <input type="text" class="form-control" id="college" name="college" required>
                                    <div id="college-warning" class="text-danger">College is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="department"><i class="fas fa-building text-primary"></i> <span class="text-primary">Department</span></label>
                                    <input type="text" class="form-control" id="department" name="department" required>
                                    <div id="department-warning" class="text-danger">Department is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="passing-year"><i class="fas fa-graduation-cap text-primary"></i> <span class="text-primary">Passing Year</span></label>
                                    <input type="number" class="form-control" id="passing-year" name="passing_year" required>
                                    <div id="passing-year-warning" class="text-danger">Passing Year is required</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password"><i class="
                                    fas fa-lock text-primary"></i> <span class="text-primary">Password</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div id="password-warning" class="text-danger">Password is required</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password"><i class="fas fa-lock text-primary"></i> <span class="text-primary">Confirm Password</span></label>
                                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                                    <div id="confirm-password-warning" class="text-danger">Confirm Password is required</div>
                                    <div id="password-match-warning" class="text-danger">Passwords do not match</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="terms.html">Terms and Policy</a>
                                    </label>
                                    <div id="terms-warning" class="text-danger">You must agree to the terms and policy</div>
                                </div>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-block" id="register-button">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" id="toggle-login">Already have an account? Login</a>
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
            var registerButton = document.getElementById('register-button');
            registerButton.addEventListener('click', function(event) {
                if (validateForm()) {
                    document.querySelector('form').submit(); // Submit the form if validation passes
                }
            });
        });

        function validateForm() {
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var dob = document.getElementById('dob').value.trim();
            var college = document.getElementById('college').value.trim();
            var department = document.getElementById('department').value.trim();
            var passingYear = document.getElementById('passing-year').value.trim();
            var password = document.getElementById('password').value.trim();
            var confirmPassword = document.getElementById('confirm-password').value.trim();
            var termsChecked = document.getElementById('terms').checked;

            // Reset all previous error messages
            var errorMessages = document.getElementsByClassName('text-danger');
            for (var i = 0; i < errorMessages.length; i++) {
                errorMessages[i].style.display = 'none';
            }

            var isValid = true;

            // Validate Name
            if (name === '') {
                document.getElementById('name-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Email
            if (email === '') {
                document.getElementById('email-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Date of Birth
            if (dob === '') {
                document.getElementById('dob-warning').style.display = 'block';
                isValid = false;
            }

            // Validate College
            if (college === '') {
                document.getElementById('college-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Department
            if (department === '') {
                document.getElementById('department-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Passing Year
            if (passingYear === '') {
                document.getElementById('passing-year-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Password
            if (password === '') {
                document.getElementById('password-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Confirm Password
            if (confirmPassword === '') {
                document.getElementById('confirm-password-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Password Match
            if (password !== confirmPassword) {
                document.getElementById('password-match-warning').style.display = 'block';
                isValid = false;
            }

            // Validate Terms and Policy Agreement
            if (!termsChecked) {
                document.getElementById('terms-warning').style.display = 'block';
                isValid = false;
            }

            // Display general error message if form is invalid
            if (!isValid) {
                document.getElementById('general-error').textContent = 'Please fill in all required fields.';
                document.getElementById('general-error').style.display = 'block';
            } else {
                document.getElementById('general-error').style.display = 'none';
            }

            return isValid;
        }
    </script>
</body>
</html>
>>>>>>> 109f3f8e230fc89dc7569212f5a58ec112f08ca9
