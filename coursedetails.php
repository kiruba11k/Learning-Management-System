<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./header.php'); 

  // Start session if not already started
  if (!isset($_SESSION)) {
    session_start();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
  <div class="row">
    <img src="bg8.jpg" alt="courses" style="height:200px; width:100%; object-fit:cover; box-shadow:10px;"/>
  </div> 
</div> <!-- End Course Page Banner -->

<div class="container mt-5"> <!-- Start All Course -->
  <?php
      if(isset($_GET['course_id'])){
       $course_id = $_GET['course_id'];
       $_SESSION['course_id'] = $course_id;
       $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) { 
           while ($row = $result->fetch_assoc()) {
               echo ' 
                   <div class="row">
                       <div class="col-md-4">
                           <img src="'.str_replace('..', '.', $row['course_img']).'" class="card-img-top" alt="Course Image" />
                       </div>
                       <div class="col-md-8">
                           <div class="card-body">
                               <h5 class="card-title" style="font-weight: bold;">Course Name: '.$row['course_name'].'</h5>
                               <hr>
                               <p class="card-text"><b>Description</b>: '.$row['course_desc'].'</p>
                               <p class="card-text"><b>Author</b>: '.$row['course_author'].'</p>
                               <p class="card-text"><b>Duration</b>: '.$row['course_duration'].'</p>
                               <form id="buyNowForm" action="checkout.php" method="post">
                                   <p class="card-text d-inline">Price: <small><del>&#8377; '.$row['course_original_price'].'</del></small> <span class="font-weight-bolder">&#8377; '.$row['course_price'].'<span></p>
                                   <input type="hidden" name="course_id" value="'.$course_id.'">
                                   <input type="hidden" name="course_name" value="'.$row['course_name'].'">
                                   <input type="hidden" name="id" value="'.$row['course_price'].'">
                                   <input type="hidden" name="course_author" value="'.$row['course_author'].'">
                                   <button type="submit" class="btn btn-primary text-white font-weight-bolder float-right" name="buy">Buy Now</button>
                               </form>
                           </div>
                       </div>
                   </div>
               ';
           }
       }}
       ?>
          
</div><!-- End All Course --> 
<div class="container">
  <div class="row">
  <?php 
    $sql = "SELECT * FROM lesson";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      echo '
       <table class="table table-bordered table-hover">
         <thead>
           <tr>
             <th scope="col">Lesson No.</th>
             <th scope="col">Lesson Name</th>
           </tr>
         </thead>
         <tbody>';
         $num = 0;
         while($row = $result->fetch_assoc()){
          if($row['course_id'] == $course_id) {
           $num++;
          echo ' <tr>
           <th scope="row">'.$num.'</th>
           <td>'. $row["lesson_name"].'</td></tr>';
          }
         }
         echo '</tbody>
       </table>';
    } ?>         
  </div>
</div>  
<?php 
  // Footer Include from mainInclude 
  include('./footer.php'); 
?>  

<script>
document.getElementById('buyNowForm').addEventListener('submit', function(event) {
  <?php
  if (!isset($_SESSION['email'])) {
    echo "window.location.href='./register.html';";
    echo "event.preventDefault();";
  }
  ?>
});
</script>
</body>
</html>
