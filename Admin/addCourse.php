<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Define page title and include header
define('TITLE', 'Add Course');
define('PAGE', 'addCourse'); // Define the PAGE constant

include('./header.php');
include('../dbConnection.php');

// Check if admin is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $adminEmail = $_SESSION['email'];
} else {
    echo "<script> location.href='../register.php'; </script>"; // Redirect to the login page
    exit();
}

// Handle form submission
if (isset($_REQUEST['courseSubmitBtn'])) {
    // Check for empty fields
    if (empty($_REQUEST['course_name']) || empty($_REQUEST['course_desc']) || empty($_REQUEST['course_author']) || empty($_REQUEST['course_duration']) || empty($_REQUEST['course_price']) || empty($_REQUEST['course_original_price'])) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
    } else {
        // Assign user values to variables
        $course_name = $_REQUEST['course_name'];
        $course_desc = $_REQUEST['course_desc'];
        $course_author = $_REQUEST['course_author'];
        $course_duration = $_REQUEST['course_duration'];
        $course_price = $_REQUEST['course_price'];
        $course_original_price = $_REQUEST['course_original_price'];
        $course_image = $_FILES['course_img']['name'];
        $course_image_temp = $_FILES['course_img']['tmp_name'];
        $img_folder = '../image/courseimg/' . $course_image;

        // Move uploaded file
        move_uploaded_file($course_image_temp, $img_folder);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO course (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $course_name, $course_desc, $course_author, $img_folder, $course_duration, $course_price, $course_original_price);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Course Added Successfully </div>';
        } else {
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Course </div>';
        }

        // Close the statement
        $stmt->close();
    }
}
?>
<div class="col-sm-6 mt-5 mx-3 jumbotron">
    <h3 class="text-center">Add New Course</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name">
        </div>
        <div class="form-group">
            <label for="course_desc">Course Description</label>
            <textarea class="form-control" id="course_desc" name="course_desc" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label for="course_author">Author</label>
            <input type="text" class="form-control" id="course_author" name="course_author">
        </div>
        <div class="form-group">
            <label for="course_duration">Course Duration</label>
            <input type="text" class="form-control" id="course_duration" name="course_duration">
        </div>
        <div class="form-group">
            <label for="course_original_price">Course Original Price</label>
            <input type="text" class="form-control" id="course_original_price" name="course_original_price" onkeypress="isInputNumber(event)">
        </div>
        <div class="form-group">
            <label for="course_price">Course Selling Price</label>
            <input type="text" class="form-control" id="course_price" name="course_price" onkeypress="isInputNumber(event)">
        </div>
        <div class="form-group">
            <label for="course_img">Course Image</label>
            <input type="file" class="form-control-file" id="course_img" name="course_img">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-danger" id="courseSubmitBtn" name="courseSubmitBtn">Submit</button>
            <a href="courses.php" class="btn btn-secondary">Close</a>
        </div>
        <?php if (isset($msg)) { echo $msg; } ?>
    </form>
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

<?php
include('./footer.php'); 
?>
