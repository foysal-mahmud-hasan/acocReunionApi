<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['barcode'])){

    $barcode = $_POST['barcode'];

    $registrationdetails = $db->validate($barcode);

    if($registrationdetails){
        $response['error'] = FALSE;
        $response['registrationdetails']['registrationId'] = $registrationdetails['Id'];
        $response['registrationdetails']['isCadet'] = $registrationdetails['IsCadet'];
    }else{
        $response['error'] = TRUE;
        $response['error_msg'] = "This is not a paid registered coupon";
    }
    echo json_encode($response);
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Submit all fields i.e. barcode";
    echo json_encode($response);
}
