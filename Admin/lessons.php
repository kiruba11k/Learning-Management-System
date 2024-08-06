<?php
if (!isset($_SESSION)) {
    session_start();
}
define('TITLE', 'Lessons');
define('PAGE', 'lessons');
include('./header.php');
include('../dbConnection.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $adminEmail = $_SESSION['email'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}
?>

<div class="col-sm-9 mt-5 mx-3">
    <form action="" class="mt-3 form-inline d-print-none" method="GET">
        <div class="form-group mr-3">
            <label for="checkid">Enter Course ID: </label>
            <input type="text" class="form-control ml-3" id="checkid" name="checkid" onkeypress="isInputNumber(event)">
        </div>
        <button type="submit" class="btn btn-danger">Search</button>
    </form>

    <?php
    if (isset($_GET['checkid'])) {
        $checkid = $_GET['checkid'];
        $sql = "SELECT * FROM course WHERE course_id = $checkid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['course_id'] = $row['course_id'];
            $_SESSION['course_name'] = $row['course_name'];
            ?>

<h3 class="mt-5 bg-dark text-white p-2 d-flex justify-content-between align-items-center">
    <span>
        Course ID: <?php echo $row['course_id']; ?>, Course Name: <?php echo $row['course_name']; ?>
    </span>
    <a href="./addLesson.php" class="btn btn-danger"><i class="fas fa-plus"></i> Add Lesson</a>
</h3>


            <?php
            $sql = "SELECT * FROM lesson WHERE course_id = $checkid";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Lesson ID</th>
                            <th scope="col">Lesson Name</th>
                            <th scope="col">Lesson Link</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <th scope="row">' . $row["lesson_id"] . '</th>
                        <td>' . $row["lesson_name"] . '</td>
                        <td>' . $row["lesson_link"] . '</td>
                        <td>
                            <form action="editlesson.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="' . $row["lesson_id"] . '">
                                <button type="submit" class="btn btn-info mr-3" name="view" value="View">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </form>  
                            <form action="" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="' . $row["lesson_id"] . '">
                                <button type="submit" class="btn btn-secondary" name="delete" value="Delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>';
                }

                echo '</tbody></table>';
            } else {
                echo '<div class="alert alert-dark mt-4" role="alert">No lessons found for this course.</div>';
            }
        } else {
            echo '<div class="alert alert-dark mt-4" role="alert">Course not found!</div>';
        }
    }
    ?>
</div>

<!-- Only Number for input fields -->
<script>
    function isInputNumber(evt) {
        var ch = String.fromCharCode(evt.which);
        if (!(/[0-9]/.test(ch))) {
            evt.preventDefault();
        }
    }
</script>

<?php include('./footer.php'); ?>
