<?php
if (!isset($_SESSION)) { 
   session_start(); 
}
include('../dbConnection.php');

if (isset($_SESSION['email'])) {
   $user_email = $_SESSION['email'];
} else {
   echo "<script> location.href='../index.php'; </script>";
}

// Fetching total lessons and completed lessons
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $totalLessonsSql = "SELECT COUNT(*) AS total FROM lesson WHERE course_id = '$course_id'";
    $completedLessonsSql = "SELECT COUNT(*) AS completed FROM lesson_completion WHERE course_id = '$course_id' AND completed = 1 AND email = '$user_email'";
    
    $totalLessonsResult = $conn->query($totalLessonsSql);
    $completedLessonsResult = $conn->query($completedLessonsSql);
    
    $totalLessons = $totalLessonsResult->fetch_assoc()['total'];
    $completedLessons = $completedLessonsResult->fetch_assoc()['completed'];
} else {
    $totalLessons = 0;
    $completedLessons = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Watch Course</title>
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <!-- Font Awesome CSS -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 <!-- Google Font -->
 <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
 <!-- Custom CSS -->
 <style>
   .navbar {
      background: linear-gradient(to right, #0F4C75, #3282B8); /* Smart color palette */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   }

   .footer {
      background-color: #0F4C75; /* Same color as navbar for consistency */
      color: #fff;
      padding: 20px 0;
      text-align: center;
   }

   .card {
      transition: transform 0.3s, box-shadow 0.3s;
      perspective: 1000px;
      background-color: #FFF; /* White background for cards */
      border-radius: 10px; /* Rounded corners */
   }

   .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
   }

   .video-container {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 500px;
   }

   .progress {
      height: 30px;
   }

   .progress-bar {
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
   }

   .lesson-completed {
      color: green;
      font-weight: bold;
   }
 </style>
</head>
<body>

<!-- Navbar -->
<div class="container-fluid p-0">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="../index.php">LMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./myCourse.php">My Courses</a>
        </li>
      </ul>
    </div>
  </nav>
</div>

<!-- Content -->
<div class="container mt-3">
  <div class="row">
    <div class="col-12">
      <h4 class="text-center">Overall Course Progress</h4>
      <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($completedLessons / $totalLessons) * 100; ?>%;" id="overall-progress" aria-valuenow="<?php echo ($completedLessons / $totalLessons) * 100; ?>" aria-valuemin="0" aria-valuemax="100">
          <?php echo round(($completedLessons / $totalLessons) * 100); ?>%
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-sm-3 border-right">
      <h4 class="text-center">Lessons</h4>
      <ul id="playlist" class="nav flex-column">
        <?php
          if (isset($_GET['course_id'])) {
            $sql = "SELECT l.*, lc.completed FROM lesson l LEFT JOIN lesson_completion lc ON l.lesson_id = lc.lesson_id AND lc.email = '$user_email' WHERE l.course_id = '$course_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $completedClass = $row['completed'] ? 'lesson-completed' : '';
                $completedIcon = $row['completed'] ? '<i class="fas fa-check-circle"></i>' : '';
                echo '<li class="nav-item border-bottom py-2 ' . $completedClass . '" data-lesson-id="'.$row['lesson_id'].'" movieurl="'.$row['lesson_link'].'" style="cursor: pointer;">'. $row['lesson_name'] .' '. $completedIcon .'</li>';
              }
            }
          }
        ?>
      </ul>
    </div>
    <div class="col-sm-9">
      <div class="video-container mt-3">
        <video id="videoarea" src="" class="w-75" controls></video>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <p>&copy; <?php echo date("Y"); ?> LMS. All rights reserved.</p>
  </div>
</footer>

<!-- Jquery and Bootstrap JavaScript -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<!-- Custom JavaScript -->
<script>
  $(document).ready(function(){
    $('#playlist li').on('click', function(){
      var movieurl = $(this).attr('movieurl');
      $('#videoarea').attr('src', movieurl);
      $('#videoarea')[0].play();
      $('#playlist li').removeClass('active');
      $(this).addClass('active');
    });

    var video = document.getElementById('videoarea');
    var overallProgressBar = document.getElementById('overall-progress');
    var totalLessons = <?php echo $totalLessons; ?>;
    var completedLessons = <?php echo $completedLessons; ?>;

    function updateOverallProgress() {
      var overallPercentage = (completedLessons / totalLessons) * 100;
      overallProgressBar.style.width = overallPercentage + '%';
      overallProgressBar.setAttribute('aria-valuenow', overallPercentage);
      overallProgressBar.innerHTML = Math.round(overallPercentage) + '%';
    }

    video.addEventListener('ended', function() {
      var activeLesson = $('#playlist .active');
      if (!activeLesson.hasClass('lesson-completed')) {
        var lessonId = activeLesson.attr('data-lesson-id');
        $.ajax({
          url: 'complete_lesson.php',
          type: 'POST',
          data: {
            user_email: '<?php echo $user_email; ?>',
            lesson_id: lessonId,
            course_id: '<?php echo $course_id; ?>'
          },
          success: function(response) {
            if (response == 'success') {
              activeLesson.addClass('lesson-completed').append(' <i class="fas fa-check-circle"></i>');
              completedLessons += 1;
              updateOverallProgress();
            }
          }
        });
      }
    });

    updateOverallProgress();
  });
</script>
</body>
</html>
