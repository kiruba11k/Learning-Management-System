<?php
if (!isset($_SESSION)) { 
  session_start(); 
}
define('TITLE', 'Checkout');
define('PAGE', 'checkout');
include_once('./dbconnection.php');

if (isset($_SESSION['email'])) {
  $user_email = $_SESSION['email'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}
$course_name = $_POST['course_name'] ?? '';
$course_author = $_POST['course_author'] ?? '';
$course_price = $_POST['id'] ?? '';
$course_id=$_POST['$course_id'] ?? '';
// Fetch the student's name from the database
$student_name = '';
if (isset($user_email)) {
  $sql = "SELECT name FROM student WHERE email = '$user_email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $student_name = $row['name'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="GENERATOR" content="Evrsoft First Page">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    
    <title>ELearning</title>
   <title>Checkout</title>
</head>
<body>
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-6 offset-sm-3 jumbotron">
      <h3 class="mb-5">LMS Payment Page</h3>
      <form method="post" action="./pay.php">
        <div class="form-group row">
          <label for="ORDER_ID" class="col-sm-4 col-form-label">Order ID</label>
          <div class="col-sm-8">
            <input id="ORDER_ID" class="form-control" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off"
              value="<?php echo  "ORDS" . rand(10000,99999999)?>" readonly>
          </div>
        </div>
        
        <div class="form-group row">
          <label for="STUDENT_MAIL" class="col-sm-4 col-form-label">Student Email</label>
          <div class="col-sm-8">
            <input id="STUDENT_MAIL" class="form-control" tabindex="2" maxlength="12" size="12" name="STUDENT_MAIL" autocomplete="off" value="<?php if(isset($user_email)){echo $user_email; }?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="STUDENT_NAME" class="col-sm-4 col-form-label">Student Name</label>
          <div class="col-sm-8">
            <input id="STUDENT_NAME" class="form-control" tabindex="10" type="text" name="STUDENT_NAME" value="<?php echo $student_name; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="AUTHOR" class="col-sm-4 col-form-label">Author</label>
          <div class="col-sm-8">
            <input title="AUTHOR" class="form-control" tabindex="10" type="text" name="AUTHOR" value="<?php if(isset($_POST['course_author'])){echo $_POST['course_author']; }?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="course_id" class="col-sm-4 col-form-label">Course ID</label>
          <div class="col-sm-8">
            <input title="course_id" class="form-control" tabindex="10" type="text" name="course_id" value="<?php if(isset($_POST['course_id'])){echo $_POST['course_id']; }?>" readonly>
          </div>
        </div>

        <div class="form-group row">
          <label for="COURSE_NAME" class="col-sm-4 col-form-label">Course</label>
          <div class="col-sm-8">
            <input title="COURSE_NAME" class="form-control" tabindex="10" type="text" name="COURSE_NAME" value="<?php if(isset($_POST['course_name'])){echo $_POST['course_name']; }?>" readonly>
          </div>
        </div>

        <div class="form-group row">
          <label for="TXN_AMOUNT" class="col-sm-4 col-form-label">Amount</label>
          <div class="col-sm-8">
            <input title="TXN_AMOUNT" class="form-control" tabindex="10" type="text" name="TXN_AMOUNT" value="<?php if(isset($_POST['id'])){echo $_POST['id']; }?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-8">
            <input type="hidden" id="INDUSTRY_TYPE_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail" readonly>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-8">
            <input type="hidden" id="CHANNEL_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB" readonly>
          </div>
        </div>
        <div class="text-center">
          <input value="Check out" type="submit" class="btn btn-primary" onclick="">
          <a href="./courses.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
      <small class="form-text text-muted">Note: Complete Payment by Clicking Checkout Button</small>
    </div>
  </div>
</div>

<!-- Jquery and Boostrap JavaScript -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- Font Awesome JS -->
<script type="text/javascript" src="js/all.min.js"></script>

<!-- Custom JavaScript -->
<script type="text/javascript" src="js/custom.js"></script>

</body>
</html>
