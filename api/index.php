<?php

// dependencies
require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/api_response.php');
require_once(dirname(__FILE__) . '/inc/api_logic.php');

// =================================================
// instanciate the api_class
$api_response = new api_response();

// =================================================
// check if method is valid
if(!$api_response->check_method($_SERVER['REQUEST_METHOD'])){
    $api_response->api_request_error('Invalid request method.');
}

// =================================================
// set request method
$api_response->set_method($_SERVER['REQUEST_METHOD']);

$params = null;


if($api_response->get_method() == 'GET'){
    $api_response->set_endpoint($_GET['endpoint']);
    $params = $_GET;

} else if($api_response->get_method() == 'POST'){
    $api_response->set_endpoint($_POST['endpoint']);
    $params = $_POST;

}

// =================================================
// prepare the api logic
$api_logic = new api_logic($api_response->get_endpoint(), $params);


// =================================================
// check if endpoint exist
if(!$api_logic->endpoint_exists())
{
    $api_response->api_request_error('Inexistente endpoint: ', $api_response->get_endpoint());
}

// request to the api_logic










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