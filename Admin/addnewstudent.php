<?php
if (!isset($_SESSION)) { 
  session_start(); 
}

define('TITLE', 'Add New Student');
define('PAGE', 'addnewstudent');

include('./header.php'); 
include('../dbconnection.php');

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

$msg = ''; // Initialize message variable

if (isset($_POST['newStuSubmitBtn'])) {
  // Check for Empty Fields
  if (empty($_POST['stu_name']) || empty($_POST['stu_email']) || empty($_POST['stu_pass']) || empty($_POST['stu_dob']) || empty($_POST['stu_dept']) || empty($_POST['college']) || empty($_POST['passing_year'])) {
    // Display warning if required fields are empty
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    // Sanitize inputs to prevent SQL injection
    $stu_name = mysqli_real_escape_string($conn, $_POST['stu_name']);
    $stu_email = mysqli_real_escape_string($conn, $_POST['stu_email']);
    $stu_pass = mysqli_real_escape_string($conn, $_POST['stu_pass']);
    $stu_dob = mysqli_real_escape_string($conn, $_POST['stu_dob']);
    $stu_dept = mysqli_real_escape_string($conn, $_POST['stu_dept']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $passing_year = mysqli_real_escape_string($conn, $_POST['passing_year']);

    // Insert data into database
    $sql = "INSERT INTO student (name, email, dob, college, department, passing_year, password) VALUES ('$stu_name', '$stu_email', '$stu_dob', '$college', '$stu_dept', '$passing_year', '$stu_pass')";

    if ($conn->query($sql) === TRUE) {
      // Display success message on successful insertion
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Student Added Successfully </div>';
    } else {
      // Display error message if insertion fails
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Student </div>';
    }
  }
}
?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Student</h3>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="stu_name">Name</label>
      <input type="text" class="form-control" id="stu_name" name="stu_name">
    </div>
    <div class="form-group">
      <label for="stu_email">Email</label>
      <input type="text" class="form-control" id="stu_email" name="stu_email">
    </div>
    <div class="form-group">
      <label for="stu_pass">Password</label>
      <input type="text" class="form-control" id="stu_pass" name="stu_pass">
    </div>
    <div class="form-group">
      <label for="stu_dob">DOB</label>
      <input type="text" class="form-control" id="stu_dob" name="stu_dob">
    </div>
    <div class="form-group">
      <label for="stu_dept">Department</label>
      <input type="text" class="form-control" id="stu_dept" name="stu_dept">
    </div>
    <div class="form-group">
      <label for="college">College</label>
      <input type="text" class="form-control" id="college" name="college">
    </div>
    <div class="form-group">
      <label for="passing_year">Passing Year</label>
      <input type="text" class="form-control" id="passing_year" name="passing_year">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="newStuSubmitBtn" name="newStuSubmitBtn">Submit</button>
      <a href="students.php" class="btn btn-secondary">Close</a>
    </div>
    <?php echo $msg; ?> <!-- Display message -->
  </form>
</div>
<?php include('./footer.php'); ?>
