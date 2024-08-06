<?php
if (!isset($_SESSION)) {
    session_start();
}
define('TITLE', 'Courses');
define('PAGE', 'courses');
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
        <h5 class=" bg-dark text-white p-2">List of Courses</h5>
        <a href="./addCourse.php" class="btn btn-danger"><i class="fas fa-plus"></i> Add Course</a>
    </div>
    <?php
    $sql = "SELECT * FROM course";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table class="table">
       <thead>
        <tr>
         <th scope="col">Course ID</th>
         <th scope="col">Name</th>
         <th scope="col">Author</th>
         <th scope="col">Action</th>
        </tr>
       </thead>
       <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<th scope="row">' . $row["course_id"] . '</th>';
            echo '<td>' . $row["course_name"] . '</td>';
            echo '<td>' . $row["course_author"] . '</td>';
            echo '<td><form action="editcourse.php" method="POST" class="d-inline">
                    <input type="hidden" name="id" value=' . $row["course_id"] . '>
                    <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button>
                  </form>  
                  <form action="" method="POST" class="d-inline">
                    <input type="hidden" name="id" value=' . $row["course_id"] . '>
                    <button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button>
                  </form></td>
                 </tr>';
        }

        echo '</tbody>
        </table>';
    } else {
        echo "<p class='mt-4'>0 Result</p>";
    }

    if (isset($_REQUEST['delete'])) {
        $sql = "DELETE FROM course WHERE course_id = {$_REQUEST['id']}";
        if ($conn->query($sql) === TRUE) {
            echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
        } else {
            echo "Unable to Delete Data";
        }
    }
    ?>
</div>
</div> <!-- div Row close from header -->

<?php include('./footer.php'); ?>
