<?php
if (!isset($_SESSION)) { 
  session_start(); 
}

if (!isset($_POST["ORDER_ID"]) || !isset($_SESSION['email'])) {
  echo "<script> location.href='./register.html'; </script>";
  exit;
}

include('./dbconnection.php');

$course_id = $_POST['course_id'] ?? '';
$ORDER_ID = $_POST["ORDER_ID"] ?? '';
$STUDENT_MAIL = $_SESSION['email'] ?? '';
$COURSE_NAME = $_POST['COURSE_NAME'] ?? '';
$TXN_AMOUNT = $_POST["TXN_AMOUNT"] ?? '';
$AUTHOR = $_POST["AUTHOR"] ?? '';
$STUDENT_NAME = $_POST['STUDENT_NAME'] ?? '';

$key = "test_cbddcdb65436dcfa5cb0c11cf5d";
$token = "test_e90f878ca01ce0973911384b95d";
$mojoURL = "test.instamojo.com";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://test.instamojo.com/api/1.1/payment-requests/");
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$key",
                  "X-Auth-Token:$token"));

$payload = Array(
  'purpose' => "$COURSE_NAME",
  'amount' => "$TXN_AMOUNT",
  'buyer_name' => "$STUDENT_NAME",
  'email' => "$STUDENT_MAIL",
  'redirect_url' => 'http://localhost/LMS1/Student/myCourse.php',
  'send_email' => true,
  'webhook' => '',
  'allow_repeated_payments' => false,
);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$decode = json_decode($response);

$success = $decode->success ?? false;
if ($success) {

    $paymentURL = $decode->payment_request->longurl;
    $STATUS = "TXN_SUCCESS";
    $order_date = date("Y-m-d");

    $sql = "INSERT INTO courseorder (order_id, email, course_id, status, respmsg, amount, order_date) VALUES ('$ORDER_ID', '$STUDENT_MAIL', '$course_id', '$STATUS', '$STATUS', '$TXN_AMOUNT', '$order_date')";
    if ($conn->query($sql) === TRUE) {
        $insert_success = true;
    } else {
        $insert_success = false;
        $error = $conn->error;
    }
    header("Location: $paymentURL");
    exit;
} else {
    echo "API Response: " . $response;
    echo "Contact the Help Support through Contact Form with screenshot for technical support.";
    exit;
}
?>

