<?php
// Start session if not already started
session_start();

// Define page title and include header
define('TITLE', 'Dashboard');
define('PAGE', 'dashboard');
include('./header.php'); 
include('../dbConnection.php');

// Check if admin is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $adminEmail = $_SESSION['email'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}

// Fetch total number of courses
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
$totalcourse = ($result->num_rows > 0) ? $result->num_rows : 0;

// Fetch total number of students
$sql = "SELECT * FROM student";
$result = $conn->query($sql);
$totalstu = ($result->num_rows > 0) ? $result->num_rows : 0;

// Fetch total number of course orders
$sql = "SELECT * FROM courseorder";
$result = $conn->query($sql);
$totalsold = ($result->num_rows > 0) ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <link rel="stylesheet" href="..css/adminstyle.css">

    <style>
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            perspective: 1000px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
        }
        .chart-container {
    position: relative;
    height: 300px; /* Adjust this value as needed */
    margin-bottom: 3rem;
}
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row text-center mt-5">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">Courses</div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="courseChart"></canvas>
                    </div>
                    <a class="btn btn-light" href="courses.php">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">Students</div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="studentChart"></canvas>
                    </div>
                    <a class="btn btn-light" href="students.php">View</a>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
    <div class="mx-5 mt-5 text-center">
      <!--Table-->
      <p class=" bg-dark text-white p-2">Course Ordered</p>
      <?php
      $sql = "SELECT * FROM courseorder";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
  echo '<table class="table">
    <thead>
    <tr>
      <th scope="col">Order ID</th>
      <th scope="col">Course ID</th>
      <th scope="col">Student Email</th>
      <th scope="col">Order Date</th>
      <th scope="col">Amount</th>
      <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>';
    while($row = $result->fetch_assoc()){
    echo '<tr>';
      echo '<th scope="row">'.$row["order_id"].'</th>';
      echo '<td>'. $row["course_id"].'</td>';
      echo '<td>'.$row["email"].'</td>';
      echo '<td>'.$row["order_date"].'</td>';
      echo '<td>'.$row["amount"].'</td>';
      echo '<td><form action="" method="POST" class="d-inline"><input type="hidden" name="id" value='. $row["co_id"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form></td>';
      echo '</tr>';
    }
  echo '</tbody>
  </table>';
  } else {
    echo "0 Result";
  }
  if(isset($_REQUEST['delete'])){
    $sql = "DELETE FROM courseorder WHERE co_id = {$_REQUEST['id']}";
    if($conn->query($sql) === TRUE){
      // echo "Record Deleted Successfully";
      // below code will refresh the page after deleting the record
      echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
      } else {
        echo "Unable to Delete Data";
      }
   }
  ?>
    </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
<script>
    var chartHeight = 300; // Adjust this value as needed

var courseCtx = document.getElementById('courseChart').getContext('2d');
var courseChart = new Chart(courseCtx, {
    type: 'bar',
    data: {
        labels: ['Courses'],
        datasets: [{
            label: ' Courses enrolled',
            data: [<?php echo $totalcourse; ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false, // Ensure the chart respects the specified height
        responsive: true,
        height: chartHeight, // Set the height of the chart
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        animation: {
            duration: 2000,
            easing: 'easeInOutCubic'
        }
    }
});
    var studentCtx = document.getElementById('studentChart').getContext('2d');
    var studentChart = new Chart(studentCtx, {
        type: 'bar',
        data: {
            labels: ['Students'],
            datasets: [{
                label: 'Total Students',
                data: [<?php echo $totalstu; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false, // Ensure the chart respects the specified height
        responsive: true,
        height: chartHeight, // Set the height of the chart
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutCubic'
            }
        }
    });

    
        
</script>
<?php
include('./footer.php'); 
?>
</body>
</html>
