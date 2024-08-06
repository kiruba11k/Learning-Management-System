<<<<<<< HEAD
<?php
session_start();
include 'dbconnection.php';
$msg = "";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $query = "SELECT * FROM student WHERE activation_code = '$code'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $query = "UPDATE student SET is_active = 1, activation_code = '' WHERE activation_code = '$code'";
        if (mysqli_query($conn, $query)) {
            $msg = "<div class='alert alert-success'>Your account has been verified. You can now <a href='login.php'>login</a>.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid verification code.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?= $msg; ?>
    </div>
</body>
</html>
=======
<?php
session_start();
include 'dbconnection.php';
$msg = "";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $query = "SELECT * FROM student WHERE activation_code = '$code'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $query = "UPDATE student SET is_active = 1, activation_code = '' WHERE activation_code = '$code'";
        if (mysqli_query($conn, $query)) {
            $msg = "<div class='alert alert-success'>Your account has been verified. You can now <a href='login.php'>login</a>.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid verification code.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?= $msg; ?>
    </div>
</body>
</html>
>>>>>>> 109f3f8e230fc89dc7569212f5a58ec112f08ca9
