<?php
define('TITLE', 'Payment Status');
define('PAGE', 'paymentstatus');

include('./header.php');
include('../dbconnection.php'); // Make sure this path is correct

$ORDER_ID = '';
$responseParamList = array(); // Initialize response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ORDER_ID = $_POST['ORDER_ID']; // Capture ORDER_ID from form submission
    
    // Retrieve payment details from database
    $sql = "SELECT * FROM courseorder WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ORDER_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Prepare $responseParamList to display payment details
        $responseParamList = array(
            "EMAIL" => $row["email"],
            "ORDERID" => $row['order_id'],
            "AMOUNT" => $row['amount'],
            "DATE" => $row["order_date"],
            // Adjust column names according to your database schema
            // Add other payment details as needed
        );
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center my-4">View Payment Status</h2>
            <form method="post" action="">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Order ID: </label>
                    <div class="col-sm-9">
                        <input class="form-control" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo htmlspecialchars($ORDER_ID); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-block" value="View" type="submit">View Payment Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($responseParamList)) { ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <h2 class="card-header text-center">Payment Receipt</h2>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($responseParamList as $paramName => $paramValue) { ?>
                                <tr>
                                    <td><label><?php echo htmlspecialchars($paramName); ?></label></td>
                                    <td><?php echo htmlspecialchars($paramValue); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <td><button class="btn btn-primary btn-block" onclick="javascript:window.print();">Print Receipt</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if (empty($responseParamList) && $_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="alert alert-info text-center" role="alert">
                No payment details found for Order ID: <?php echo htmlspecialchars($ORDER_ID); ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php include('./footer.php'); ?>
