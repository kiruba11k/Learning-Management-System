<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Edit Student');
define('PAGE','editstudent');
include('./header.php'); 
include('../dbconnection.php');;

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}
 // Update
 if(isset($_REQUEST['requpdate'])){
  // Checking for Empty Fields
  if(($_REQUEST['stu_id'] == "") || ($_REQUEST['name'] == "") || ($_REQUEST['email'] == "") || ($_REQUEST['password'] == "") ){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
    // Assigning User Values to Variable
    $sid = $_REQUEST['id'];
    $sname = $_REQUEST['name'];
    $semail = $_REQUEST['email'];
    $spass = $_REQUEST['password'];
    
   $sql = "UPDATE student SET id = '$sid', name = '$sname', email = '$semail', password='$spass' WHERE id = '$sid'";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Update Student Details</h3>
  <?php
 if(isset($_REQUEST['view'])){
  $sql = "SELECT * FROM student WHERE id = {$_REQUEST['id']}";
 $result = $conn->query($sql);
 $row = $result->fetch_assoc();
 }
 ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="stu_id">ID</label>
      <input type="text" class="form-control" id="stu_id" name="stu_id" value="<?php if(isset($row['id'])) {echo $row['id']; }?>"readonly>
    </div>
    <div class="form-group">
      <label for="stu_name">Name</label>
      <input type="text" class="form-control" id="stu_name" name="stu_name" value="<?php if(isset($row['name'])) {echo $row['name']; }?>">
    </div>

    <div class="form-group">
      <label for="stu_email">Email</label>
      <input type="text" class="form-control" id="stu_email" name="stu_email" value="<?php if(isset($row['email'])) {echo $row['email']; }?>">
    </div>

    <div class="form-group">
      <label for="stu_pass">Password</label>
      <input type="text" class="form-control" id="stu_pass" name="stu_pass" value="<?php if(isset($row['password'])) {echo $row['password']; }?>">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
      <a href="students.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./footer.php'); 
?>