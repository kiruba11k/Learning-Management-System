<?php
if (!isset($_SESSION)) { 
    session_start(); 
}
define('TITLE', 'Student Profile');
define('PAGE', 'profile');
 
include_once('../dbConnection.php');

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}

$sql = "SELECT * FROM student WHERE email='$user_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row["id"];
    $stuName = $row["name"]; 
    $stuDob = $row["dob"];
    $stuImg = $row["stu_img"];
    $stuClg = $row["college"];
    $stuDept = $row["department"];
    $stuPassing = $row["passing_year"];
}

if (isset($_REQUEST['updateStuNameBtn'])) {
    if (empty($_REQUEST['stuName'])) {
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
    } else {
        $stuName = $_REQUEST["stuName"];
        $stu_image = $_FILES['stuImg']['name']; 
        $stu_image_temp = $_FILES['stuImg']['tmp_name'];
        $img_folder = '../Student/profile/'. $stu_image; 
        
        // Directory path
        $img_directory = '../Student/profile/';

        // Check if the directory doesn't exist
        if (!file_exists($img_directory)) {
            // Create the directory with write permissions (0777)
            if (!mkdir($img_directory, 0777, true)) {
                die('Failed to create directory');
            }
        }

        // Check if the file has been uploaded successfully
        if (move_uploaded_file($stu_image_temp, $img_folder)) {
            // File uploaded successfully
            $sql = "UPDATE student SET name = '$stuName', stu_img = '$img_folder' WHERE email = '$user_email'";
            if ($conn->query($sql) === TRUE) {
                $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
            } else {
                $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
            }
        } else {
            // Failed to move the uploaded file
            $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update: Failed to move uploaded file </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
        }
        .profile-section {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        /* Animation and Background for Right Column */
        .right-section {
            background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
                                                animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0px);
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5">
                <!-- Left Side - Profile Menu -->
                <div class="profile-section">
                    <div class="text-center"> <!-- Center the profile picture -->
                        <img src="<?php echo $stuImg; ?>" alt="Profile Picture" class="profile-pic img-fluid">
                        <h2>Student Information</h2>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?php echo $stuName; ?></p>
                            <p><strong>ID:</strong> <?php echo $stuId; ?></p>
                            <p><strong>Email:</strong> <?php echo $user_email; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date of Birth:</strong> <?php echo $stuDob; ?></p>
                            <p><strong>College:</strong> <?php echo $stuClg; ?></p>
                            <p><strong>Department:</strong> <?php echo $stuDept; ?></p>
                        </div>
                    </div>
                    <a href="../courses.php" class="btn btn-secondary btn-block mb-2">All Courses</a>
                    <a href="myCourse.php" class="btn btn-danger btn-block mb-2">My Courses</a>
                    <a href="stufeedback.php" class="btn btn-primary btn-block mb-2">Feedback</a>

                    <a href="../index.php" class="btn btn-success btn-block mb-2">Home</a>
                </div>
            </div>
            <div class="col-md-7">
                <!-- Right Side - Student Details -->
                <div class="profile-section right-section">
                    <form class="row" method="POST" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stuId">Student ID</label>
                                <input type="text" class="form-control" id="stuId" name="stuId" value="<?php echo $stuId; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="stuEmail">Email</label>
                                <input type="email" class="form-control" id="stuEmail" value="<?php echo $user_email; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="stuName">Name</label>
                                <input type="text" class="form-control" id="stuName" name="stuName" value="<?php echo $stuName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="stuDob">Dob</label>
                                <input type="text" class="form-control" id="stuDob" name="stuDob" value="<?php echo $stuDob; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stuDept">Department</label>
                                <input type="text" class="form-control" id="stuDept" name="stuDept" value="<?php echo $stuDept; ?>">
                            </div>
                            <div class="form-group">
                                <label for="stuClg">College</label>
                                <input type="text" class="form-control" id="stuClg" name="stuClg" value="<?php echo $stuClg; ?>">
                            </div>
                            <div class="form-group">
                                <label for="stuPassing">Passing Year</label>
                                <input type="text" class="form-control" id="stuPassing" name="stuPassing" value="<?php echo $stuPassing; ?>">
                            </div>
                            <div class="form-group">
                                <label for="stuImg">Upload Image</label>
                                <input type="file" class="form-control-file" id="stuImg" name="stuImg">
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" name="updateStuNameBtn">Update</button>
                            <?php if(isset($passmsg)) { echo $passmsg; } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
