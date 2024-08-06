<?php
if (!isset($_SESSION)) { 
  session_start(); 
}
define('TITLE', 'Feedback');
define('PAGE', 'feedback');
include_once('../dbConnection.php');

if (isset($_SESSION['email'])) {
  $user_email = $_SESSION['email'];
} else {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

$sql = "SELECT * FROM student WHERE email='$user_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $stuId = $row["id"];
}

if (isset($_REQUEST['submitFeedbackBtn'])) {
  if ($_REQUEST['f_content'] == "") {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    $fcontent = $_REQUEST["f_content"];
    $sql = "INSERT INTO feedback (f_content, id) VALUES ('$fcontent', '$stuId')";
    if ($conn->query($sql) === TRUE) {
      $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Submitted Successfully </div>';
      header("Location: StudentProfile.php");
    } else {
      $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Submit </div>';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .feedback-container {
      background: radial-gradient(592px at 48.2% 50%, rgba(255, 255, 249, 0.6) 0%, rgb(160, 199, 254) 74.6%);      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      padding: 30px;
      animation: fadeInUp 1s;
    }
    .btn-primary {
      background-color: #4facfe;
      border-color: #4facfe;
      transition: transform 0.2s;
    }
    .btn-primary:hover {
      transform: scale(1.1);
      background-color: #00f2fe;
      border-color: #00f2fe;
    }
    @keyframes fadeInUp {
      from {
        transform: translate3d(0, 40px, 0);
        opacity: 0;
      }
      to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-sm-8 feedback-container">
        <h2 class="text-center mb-4">Submit Your Feedback</h2>
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="stuId">Student ID</label>
            <input type="text" class="form-control" id="stuId" name="stuId" value="<?php if(isset($stuId)) {echo $stuId;} ?>" readonly>
          </div>
          <div class="form-group">
            <label for="f_content">Write Feedback:</label>
            <textarea class="form-control" id="f_content" name="f_content" rows="3"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="submitFeedbackBtn">Submit</button>
          </div>
          <?php if(isset($passmsg)) {echo '<div class="mt-3">'.$passmsg.'</div>'; } ?>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

