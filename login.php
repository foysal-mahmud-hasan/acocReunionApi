<?php

require_once 'db_function.php';
$db = new DB_FUNCTIONS();

$response = array("error"=>FALSE);

if(isset($_POST['userName']) && isset($_POST['password'])){

    //receiving the post
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    $user = $db->login($userName, $password);

    if($user){
        $response['error'] = FALSE;
        $response['user']['id'] = $user['Id'];

    }else{

        $response['error'] = TRUE;
        $response['error_msg'] = "Login Credentials are wrong, pls try again";

    }
    echo json_encode($response);

}
else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Required parameters (UserName, Password) is missing";
    echo json_encode($response);
}
