<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Students');
define('PAGE', 'students');
include('./header.php'); 
include('../dbConnection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
  $adminEmail = $_SESSION['email'];
} else {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}
?>
  <div class="col-sm-9 mt-5">
    <!--Table-->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class=" bg-dark text-white p-2">List of Students</h5>
        <a href="./addnewstudent.php" class="btn btn-danger"><i class="fas fa-plus"></i> Add Student</a>
    </div>
    <?php
      $sql = "SELECT * FROM student";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       echo '<table class="table">
       <thead>
        <tr>
         <th scope="col">Student ID</th>
         <th scope="col">Name</th>
         <th scope="col">Email</th>
         <th scope="col">Action</th>
        </tr>
       </thead>
       <tbody>';
        while($row = $result->fetch_assoc()){
          echo '<tr>';
          echo '<th scope="row">'.$row["id"].'</th>';
          echo '<td>'. $row["name"].'</td>';
          echo '<td>'.$row["email"].'</td>';
          echo '<td><form action="editstudent.php" method="POST" class="d-inline"> <input type="hidden" name="id" value='. $row["id"] .'><button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button></form>  
          <form action="" method="POST" class="d-inline"><input type="hidden" name="id" value='. $row["id"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form></td>
         </tr>';
        }

        echo '</tbody>
        </table>';
      } else {
        echo "0 Result";
      }
      if(isset($_REQUEST['delete'])){
       $sql = "DELETE FROM student WHERE id = {$_REQUEST['id']}";
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
 </div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->
<?php
include('./footer.php'); 
?>