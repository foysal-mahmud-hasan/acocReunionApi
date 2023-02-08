<?php


require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error" => FALSE);

if (isset($_POST['barcode']) && isset($_POST['eventDetId'])) {

    $barcode = $_POST['barcode'];
    $eventDetId = $_POST['eventDetId'];

    $eventattendance_trs = $db->check_barcode($barcode, $eventDetId);

    if ($eventattendance_trs) {
        $response['error'] = FALSE;
        $response['event']['eventId'] = $eventattendance_trs['ID'];
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Not scanned in Registration Event";
    }
    echo json_encode($response);
} else {
    $response['error'] = TRUE;
    $response['error_msg'] = "Submit all fields i.e. barcode and eventId";
    echo json_encode($response);
}
