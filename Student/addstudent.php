<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
include_once('../dbConnection.php');

// setting header type to json, We'll be outputting a Json data
header('Content-type: application/json');

// Checking Email already Registered
if(isset($_POST['email']) && isset($_POST['email'])){
  $stuemail = $_POST['email'];
  $sql = "SELECT email FROM student WHERE email='".$stuemail."'";
  $result = $conn->query($sql);
  $row = $result->num_rows;
  echo json_encode($row);
  }
 
  // Inserting or Adding New Student
  if(isset($_POST['stusignup']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $stuname = $_POST['name'];
    $stuemail = $_POST['email'];
    $stupass = $_POST['password'];
    $sql = "INSERT INTO student(name, email, password) VALUES ('$stuname', '$stuemail', '$stupass')";
    if($conn->query($sql) == TRUE){
      echo json_encode("OK");
    } else {
      echo json_encode("Failed");
    }
  }

  // Student Login Verification
  if(!isset($_SESSION['is_login'])){
    if(isset($_POST['checkLogemail']) && isset($_POST['stuLogEmail']) && isset($_POST['stuLogPass'])){
      $stuLogEmail = $_POST['stuLogEmail'];
      $stuLogPass = $_POST['stuLogPass'];
      $sql = "SELECT email, password FROM student WHERE email='".$stuLogEmail."' AND password='".$stuLogPass."'";
      $result = $conn->query($sql);
      $row = $result->num_rows;
      
      if($row === 1){
        $_SESSION['is_login'] = true;
        $_SESSION['stuLogEmail'] = $stuLogEmail;
        echo json_encode($row);
      } else if($row === 0) {
        echo json_encode($row);
      }
    }
  }

?>