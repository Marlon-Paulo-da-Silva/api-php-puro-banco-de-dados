<?php

// dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');


// // ------------------------------------------------------
// echo '<h3>CLIENTES TODOS</h3>';
// $results = api_request('get_all_clients', 'GET');
// foreach($results['data']['results'] as $client){
//   echo $client['nome'].' - '.$client['email'].'<br />';
// }
// echo '<hr>';


// Logica e regras de negocio
$resultados = api_request('get_totals', 'GET')['data'];

// printData($resultados);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
  <?php include('inc/nav.php') ?>

  <div class="container my-5 text-center">
    <div class="row">
      <div class="col-sm-6">
          [total_clientes]
      </div>
      <div class="col-sm-6 text-center">
           [total_produtos]
      </div>
    </div>
  </div>

<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
