<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error" => FALSE);

if (isset($_POST['submit'])) {
    $eventsList = $db->load_events();

    if ($eventsList) {
        $response['error'] = FALSE;
        $response['eventList'] = array();
        foreach ($eventsList as $event) {
            $temp = array();
            $temp['eventId'] = $event['Id'];
            $temp['subEventTitle'] = $event['SubEventTitle'];
            $response['eventList'][] = $temp;
        }
    } else {
        $response['error'] = TRUE;
        $response['error_msg'] = "No events found";
    }
    echo json_encode($response);
} else {
    $response['error'] = TRUE;
    $response['error_msg'] = "submit not posted";
    echo json_encode($response);
}
