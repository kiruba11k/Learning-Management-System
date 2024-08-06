<?php
if (!isset($_SESSION)) { 
  session_start(); 
}
define('TITLE', 'My Course');
define('PAGE', 'mycourse');
include_once('../dbconnection.php');

if (isset($_SESSION['email'])) {
  $user_email = $_SESSION['email'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo TITLE; ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-image: url('https://source.unsplash.com/1600x900/?education');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      height: 100%;
    }
    .navbar {
      background-color: rgba(0, 0, 0, 0.7);
    }
    .navbar-brand,
    .navbar-nav .nav-link {
      color: #fff;
    }
    .card {
      transition: transform 0.3s, box-shadow 0.3s;
      perspective: 1000px;
      max-height: 450px; /* Adjust this value as needed */
    }
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
    }
    .card-img-top {
      height: 150px; /* Adjust this value as needed */
      object-fit: cover;
    }
    .card-body {
      overflow: hidden;
    }
    .progress-bar {
      height: 15px;
      font-size: 14px;
      border-radius: 10px;
    }
    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="../index.php">LMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">My Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <h4 class="text-center text-Blue">My Enrolled Courses</h4>
      </div>
    </div>
    <div class="row">
      <?php 
      if (isset($user_email)) {
        $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, c.course_author, c.course_original_price, c.course_price FROM courseorder AS co JOIN course AS c ON c.course_id = co.course_id WHERE co.email = '$user_email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Calculate overall progress
            $course_id = $row['course_id'];
            $totalLessonsSql = "SELECT COUNT(*) AS total FROM lesson WHERE course_id = '$course_id'";
            $completedLessonsSql = "SELECT COUNT(*) AS completed FROM lesson_completion WHERE course_id = '$course_id' AND completed = 1 AND email = '$user_email'";
            $totalLessonsResult = $conn->query($totalLessonsSql);
            $completedLessonsResult = $conn->query($completedLessonsSql);
            $totalLessons = $totalLessonsResult->fetch_assoc()['total'];
            $completedLessons = $completedLessonsResult->fetch_assoc()['completed'];
            $progressPercentage = round(($completedLessons / $totalLessons) * 100);
            $completedClass = ($progressPercentage == 100) ? 'completed' : '';
      ?>
            <div class="col-md-4 mb-5">
              <div class="card">
                <img src="<?php echo $row['course_img']; ?>" class="card-img-top" alt="pic" style="border-radius: 10px 10px 0 0; height: 200px; object-fit: cover;">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
                  <p class="card-text"><small>Instructor: <?php echo $row['course_author']; ?></small></p>
                  <p class="card-text"><small>Duration: <?php echo $row['course_duration']; ?></small></p>
                  <div class="progress">
                    <div class="progress-bar bg-success <?php echo $completedClass; ?>" role="progressbar" style="width: <?php echo $progressPercentage; ?>%;" aria-valuenow="<?php echo $progressPercentage; ?>" aria-valuemin="0" aria-valuemax="100">
                      <?php echo $progressPercentage; ?>%
                    </div>
                  </div>
                  <?php if ($progressPercentage == 100): ?>
                    <button class="btn btn-success mt-2 completed-btn" disabled>Completed</button>
                    <a href="watchcourse.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary mt-2">Watch Again</a>
                  <?php else: ?>
                    <a href="watchcourse.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary mt-2">Watch Course</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
      <?php
          }
        } else {
          echo '<div class="col-12"><p class="text-center text-white">No courses found.</p></div>';
        }
      }
      ?>
    </div>
  </div>
  <footer class="py-4 text-center">
    <div class="container">
      <p>&copy; 2024 LMS. All rights reserved.</p>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
