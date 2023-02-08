<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error" => FALSE);

if(isset($_POST['barcode'])) {

    $barcode = $_POST['barcode'];

    $cadetParking = $db->getCadetParking($barcode);

    if($cadetParking){
        $response['error'] = FALSE;
        $response['parkings'] = array();
        foreach ($cadetParking as $parking){
            $temp = array();
            $temp['ParkingNo'] = $parking['ParkingNo'];
            $response['parkings'][] = $temp;
        }
    }else {
        $response['error'] = TRUE;
        $response['error_msg'] = "No parkings found";
    }
    echo json_encode($response);
} else {
    $response['error'] = TRUE;
    $response['error_msg'] = "Submit all fields i.e. barcode";
    echo json_encode($response);

}
