<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error" => FALSE);

if (isset($_POST['submit'])) {
    $eventsList = $db->load_events();

    if ($eventsList) {
        $response['error'] = FALSE;
        $response['eventDetId'] = array();
        foreach ($eventsList as $event) {
            $temp = array();
            $temp['eventId'] = $event['Id'];
            $temp['SubEventTitle'] = $event['SubEventTitle'];
            $response['eventDetId'][] = $temp;
        }
    } else {
        $response['error'] = TRUE;
        $response['error_msg'] = "No events found";
    }
    echo json_encode($response);
} else {
    $response['error'] = TRUE;
    $response['error_msg'] = "Data not submitted";
    echo json_encode($response);
}
