<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'UserContact');
define('PAGE', 'usercontact');
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
    <p class=" bg-dark text-white p-2">List of Contacts</p>
    <?php
      $sql = "SELECT * FROM contacts";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
       echo '<table class="table">
       <thead>
        <tr>
         <th scope="col">ID</th>
         <th scope="col">Fullname</th>
         <th scope="col">Email</th>
         <th scope="col">Phone</th>
         <th scope="col">Subject</th>
         <th scope="col">Message</th>
         <th scope="col">Time</th>


        </tr>
       </thead>
       <tbody>';
        while($row = $result->fetch_assoc()){
          echo '<tr>';
          echo '<th scope="row">'.$row["id"].'</th>';
          echo '<td>'. $row["fullname"].'</td>';
          echo '<td>'.$row["email"].'</td>';
          echo '<td>'. $row["phone"].'</td>';
          echo '<td>'. $row["subject"].'</td>';
          echo '<td>'. $row["message"].'</td>';
          echo '<td>'. $row["created_at"].'</td>';

          
        }

        echo '</tbody>
        </table>';
      } else {
        echo "0 Result";
      }
      
     ?>
  </div>
  <!-- div Conatiner-fluid close from header -->
<?php
include('./footer.php'); 
?>