<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['barcode'])){

    $barcode = $_POST['barcode'];

    $relation = $db->check_relation($barcode);

    if($relation){
        $response['error'] = FALSE;
        $response['relation']['isCadet'] = $relation['IsCadet'];
        $response['relation']['cadetName'] = $relation['CadetName'];
        $response['relation']['cadetNo'] = $relation['CadetNo'];
        $response['relation']['relationWithCadet'] = $relation['RelationWithCadet'];
    }else{
        $response['error'] = TRUE;
        $response['error_msg'] = "Scan registered barcode Only";
    }
    echo json_encode($response);
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Submit all fields i.e. barcode";
    echo json_encode($response);
}
