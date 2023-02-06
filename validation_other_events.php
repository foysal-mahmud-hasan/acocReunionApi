<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['barcode'])){

    $barcode = $_POST['barcode'];

    $registrationIdForOE = $db->validate_other_event($barcode);

    if($registrationIdForOE){
        $response['error'] = FALSE;
        $response['registrationIdForOE']['registrationId'] = $registrationIdForOE['ID'];
    }else{
        $response['error'] = TRUE;
        $response['error_msg'] = "This is not a paid registered coupon";
    }
    echo json_encode($response);
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Error";
    echo json_encode($response);
}
