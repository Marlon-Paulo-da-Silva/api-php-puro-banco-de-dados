<?php

// dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');

// $results = api_request('status', 'POST', $variables);
// $results = api_request('status', 'GET');
// print_r($results);

// $results = api_request('statusx', 'GET');
// print_r($results);

// $results = api_request('get_all_clients', 'GET');
// print_r($results);

// $results = api_request('get_all_products', 'GET');
// print_r($results);

// echo '<pre>';
// print_r($results);

$results = api_request('get_all_clients', 'GET');
// ------------------------------------------------------
foreach($results['data']['results'] as $client){
  echo $client['nome'].' - '.$client['email'].'<br />';
}

$results = api_request('get_all_products', 'GET');
// ------------------------------------------------------
foreach($results['data']['results'] as $prod){
  echo $prod['produto'].' - '.$prod['quantidade'].'<br />';
}
