<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./header.php'); 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses</title>
  <!-- Add the necessary CSS and JS for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
 
    .card {
      transition: transform 0.3s, box-shadow 0.3s;
      height: 250px; /* Adjust the height as needed */
    }
    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .price-footer {
      background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(242,246,255,1) 100%);
      border-radius: 0 0 10px 10px;
      padding: 10px;
      transition: background 0.3s;
    }
    .card:hover .price-footer {
      background: linear-gradient(90deg, rgba(242,246,255,1) 0%, rgba(220,230,255,1) 100%);
    }
    .price {
      font-size: 1rem; /* Adjust the font size as needed */
      color: #ff5733;
      transition: color 0.3s;
    }
    .card:hover .price {
      color: #c70039;
    }
</style>
</head>
<body>
<div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
  <div class="row position-relative">
    <img src="bg7.jpg" alt="courses" class="img-fluid" style="height:300px; width:100%; object-fit:cover; filter: brightness(90%);"/>
    <div class="col text-center text-white position-absolute top-50 start-50 translate-middle">
      <h1 style="color:darkblue;">Explore Our Courses</h1>
      <p style="color:blue;font-family: Gill Sans, sans-serif;">Learn new skills and advance your career</p>
    </div>
  </div> 
</div> <!-- End Course Page Banner -->

<div class="container mt-5"> <!-- Start All Course -->
  <h1 class="text-center mb-4" style="color:darkblue;">All Courses</h1>
  <div class="row mt-4"> <!-- Start All Course Row -->
  <?php
      $sql = "SELECT * FROM course";
      $result = $conn->query($sql);
      if($result->num_rows > 0){ 
        while($row = $result->fetch_assoc()){
          $course_id = $row['course_id'];
          echo ' 
          <div class="col-6 col-md-4 col-lg-3 mb-4">
            <a href="coursedetails.php?course_id='.$course_id.'" class="btn" style="text-align: left; padding:0px;">
              <div class="card h-100 shadow-lg border-0 animate__animated animate__fadeInUp">
                <img src="'.str_replace('..', '.', $row['course_img']).'" class="card-img-top" alt="'.$row['course_name'].'" style="border-radius: 10px 10px 0 0; height: 200px; object-fit: cover;" />
                <div class="card-body">
                  <h5 class="card-title" style="font-size: 1rem;  font-weight: bold;">'.$row['course_name'].'</h5>
                  <p class="card-text" style="font-size: 0.875rem;">'.substr($row['course_desc'], 0, 50).'...</p>
                </div>
                <div class="card-footer bg-transparent border-0 price-footer d-flex justify-content-between align-items-center">
                  <p class="card-text d-inline" style="font-size: 0.875rem;">Price: <small><del>&#8377 '.$row['course_original_price'].'</del></small> <span class="font-weight-bolder price">&#8377 '.$row['course_price'].'</span></p> 
                  <a class="btn btn-primary text-white font-weight-bolder" style="font-size: 0.875rem; margin-right: 15px;" href="coursedetails.php?course_id='.$course_id.'">Enroll</a>
                </div>
              </div>
            </a>
          </div>
        ';
      }
    }
  ?> 
  </div><!-- End All Course Row -->   
</div><!-- End All Course -->

</body>
</html> 


<?php 
  // Footer Include from mainInclude 
  include('./footer.php'); 
?>  


