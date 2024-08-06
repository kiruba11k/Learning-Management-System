<<<<<<< HEAD
<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "lms1";

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($conn->connect_error) {
 die("connection failed");
} 
// else {
//  echo"connected";
// }
=======
<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "lms1";

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($conn->connect_error) {
 die("connection failed");
} 
// else {
//  echo"connected";
// }
>>>>>>> 109f3f8e230fc89dc7569212f5a58ec112f08ca9
?>