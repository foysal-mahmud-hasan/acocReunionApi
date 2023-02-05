<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['barcode']) && $_POST['eventDetId'] && $_POST['registrationId'] && $_POST['entryBy']){

    $barcode = $_POST['barcode'];
    $eventDetId = $_POST['eventDetId'];
    $registrationId = $_POST['registrationId'];
    $entryBy = $_POST['entryBy'];

    $eventattendance_trs = $db->check_barcode($barcode, $eventDetId);

    if($eventattendance_trs){
        $response['error'] = FALSE;
        $response['event']['eventId'] = $eventattendance_trs['ID'];
    }else{
        $registerBarcode = $db->register_barcode($eventDetId, $registrationId, $entryBy);
        if ($registerBarcode) {
            $response['error'] = FALSE;
            $response['message'] = "Successfully Registered";
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Couldn't register barcode";
        }
    }
    echo json_encode($response);
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Submit all fields";
    echo json_encode($response);
}