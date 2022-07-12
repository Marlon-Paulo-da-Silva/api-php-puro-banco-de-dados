<?php

// dependencies
require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/api_response.php');

// =================================================
// instanciate the api_class
$api = new api_response();

// =================================================
// check if method is valid
if(!$api->check_method($_SERVER['REQUEST_METHOD'])){
    $api->api_request_error('Invalid request method.');
}

// =================================================
// set request method
$api->set_method($_SERVER['REQUEST_METHOD']);
$params = null;


if($api->get_method() == 'GET'){
    $api->set_endpoint($_GET['endpoint']);
    $params = $_GET;

} else if($api->get_method() == 'POST'){
    $api->set_endpoint($_POST['endpoint']);
    $params = $_GET;

}


// routes


$api->send_api_status();

// //check the method
// if(!$api->check_method($_SERVER['REQUEST_METHOD'])){
    // $api->api_request_error('Aconteceu um erro na API !!');
    // }
    



// // resposta temporaria
// header("Content-Type:application/json");

// $data['status'] = 'SUCCESS';
// $data['method'] = $_SERVER['REQUEST_METHOD'];

// // apresentar as variáveis que vieram no pedido (get ou post)

// if($data['method'] == 'GET'){
//     $data['data'] = $_GET;

// } else if($data['method'] == 'POST'){
//     $data['data'] = $_POST;
    
// }

// echo json_encode($data);