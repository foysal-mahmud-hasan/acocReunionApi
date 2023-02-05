<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['barcode'])){

    $barcode = $_POST['barcode'];

    $cadetDetails= $db->cadet_Details($barcode);

    if($cadetDetails){
        $response['error'] = FALSE;
        $response['cadetDetails']['cadetName'] = $cadetDetails['CadetName'];
        $response['cadetDetails']['cadetNo'] = $cadetDetails['CadetNo'];
        $response['cadetDetails']['intake'] = $cadetDetails['Intake'];
        $response['cadetDetails']['shirtSize'] = $cadetDetails['ShirtSize'];
        $response['cadetDetails']['totalAttendance'] = $cadetDetails['Total Attendance'];
        $response['cadetDetails']['accommodationDesc'] = $cadetDetails['AccommodationDesc'];

    }else{
        $response['error'] = TRUE;
        $response['error_msg'] = "Cadet Information Not Available";
    }
    echo json_encode($response);
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Error";
    echo json_encode($response);
}