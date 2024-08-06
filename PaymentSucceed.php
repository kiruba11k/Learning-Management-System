
<?php
if (!isset($_SESSION)) { 
  session_start(); 
}

if (!isset($_POST["ORDER_ID"]) || !isset($_SESSION['email'])) {
  echo "<script> location.href='./register.html'; </script>";
  exit;
}

include('./dbconnection.php');

$ORDER_ID = $_POST["ORDER_ID"];
$STUDENT_MAIL = $_SESSION['email'];
$COURSE_NAME = $_POST['COURSE_NAME'];
$TXN_AMOUNT = $_POST["TXN_AMOUNT"];
$AUTHOR = $_POST["AUTHOR"];
$STUDENT_NAME = $_POST['STUDENT_NAME'];

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
  'redirect_url' => 'http://localhost/LMS1/PaymentSucceed.php',
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

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON Decode Error: ' . json_last_error_msg();
    echo 'Response: ' . $response;
    exit;
}

$success = $decode->success;
if ($success == true) {
    $paymentURL = $decode->payment_request->longurl;
    header("Location: $paymentURL");
    exit;
} else {
    echo "API Response: " . $response;
    echo "Contact the Help Support through Contact Form with screenshot for technical support.";
    exit;
}

// After redirection and successful payment, this part will execute
if (isset($_GET['payment_id']) && isset($_GET['payment_request_id'])) {
    // Verify the payment status
    $payment_id = $_GET['payment_id'];
    $payment_request_id = $_GET['payment_request_id'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://test.instamojo.com/api/1.1/payments/$payment_id/");
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:$key",
                      "X-Auth-Token:$token"));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $decode = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON Decode Error: ' . json_last_error_msg();
        echo 'Response: ' . $response;
        exit;
    }

    if ($decode->success == true && $decode->payment->status == "Credit") {
        $order_date = date("Y-m-d");

        // Insert payment details into the database
        $sql = "INSERT INTO courseorder (course_id, student_email, amount, order_date) VALUES ('$course_id', '$STUDENT_MAIL', '$TXN_AMOUNT', '$order_date')";
        if ($conn->query($sql) === TRUE) {
            $insert_success = true;
        } else {
            $insert_success = false;
            $error = $conn->error;
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Payment Succeeded</title>
          <!-- Bootstrap CSS -->
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
          <!-- Font Awesome CSS -->
          <link rel="stylesheet" type="text/css" href="css/all.min.css">
          <!-- Google Font -->
          <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
          <!-- Custom Style CSS -->
          <link rel="stylesheet" type="text/css" href="css/style.css" />
        </head>
        <body>
          <div class="container mt-5">
            <div class="row">
              <div class="col-sm-8 offset-sm-2 jumbotron text-center">
                <?php if ($insert_success): ?>
                  <h1 class="display-4">Payment Successful!</h1>
                  <p class="lead">Thank you, <?php echo htmlspecialchars($STUDENT_NAME); ?>. Your payment was successfully processed.</p>
                  <hr class="my-4">
                  <h3 class="mb-4">Order Details</h3>
                  <p><strong>Order ID:</strong> <?php echo htmlspecialchars($ORDER_ID); ?></p>
                  <p><strong>Course Name:</strong> <?php echo htmlspecialchars($COURSE_NAME); ?></p>
                  <p><strong>Author:</strong> <?php echo htmlspecialchars($AUTHOR); ?></p>
                  <p><strong>Amount Paid:</strong> ₹<?php echo htmlspecialchars($TXN_AMOUNT); ?></p>
                  <p><strong>Date:</strong> <?php echo htmlspecialchars($order_date); ?></p>
                  <a href="./courses.php" class="btn btn-success mt-3">Go to My Courses</a>
                <?php else: ?>
                  <h1 class="display-4">Payment Failed!</h1>
                  <p class="lead">Unfortunately, there was an issue with your payment. Please try again later.</p>
                  <hr class="my-4">
                  <p class="text-danger">Error: <?php echo htmlspecialchars($error); ?></p>
                  <a href="./index.php" class="btn btn-danger mt-3">Return Home</a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Jquery and Boostrap JavaScript -->
          <script type="text/javascript" src="js/jquery.min.js"></script>
          <script type="text/javascript" src="js/popper.min.js"></script>
          <script type="text/javascript" src="js/bootstrap.min.js"></script>
          <!-- Font Awesome JS -->
          <script type="text/javascript" src="js/all.min.js"></script>
          <!-- Custom JavaScript -->
          <script type="text/javascript" src="js/custom.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Payment verification failed. Please contact support.";
    }
}
?>
