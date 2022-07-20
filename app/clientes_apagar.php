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

// verificar se foi informado um ID
if(!isset($_GET['id']) || $_GET['id'] == ""){
  header("Location: clientes.php");
  exit;
}


$id_cliente = $_GET['id'];

// verifica se é para eliminar o cliente
if(isset($_GET['confirm']) && $_GET['confirm'] == "true"){
  api_request('delete_client', 'GET', ['id' => $id_cliente]);
  header("Location: clientes.php");
  exit;
}

$results = api_request('get_client', 'GET', ['id' => $id_cliente]);

// verificar se foi encontrado o cliente que prentedemos apagar
if(count($results['data']['results']) == 0){
  header("Location: clientes.php");
  exit;
}


// printData($results);

// Analisar a informação obtida
if($results['data']['status'] == 'SUCCESS'){
  $cliente = $results['data']['results'][0];
} else {
  $cliente = [];
}

if(empty($cliente)){
  header("Location: clientes.php");
  exit;
}

// printData($cliente);

// $clientes = api_request('get_all_clients', 'GET'); //['data']['results'];

// printData($clientes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor - Clientes</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
  <?php include('inc/nav.php') ?>

  <section class="container">
    <div class="row">
      <div class="col p-5">
         <h5 class="text-center">
          Deseja eliminar o cliente <strong><?= $cliente['nome'] ?></strong> ?
          <div class="text-center mt-3">
            <a href="clientes.php" class="btn btn-secondary">Não</a>
            <a href="clientes_apagar.php?id=<?= $cliente['id_cliente'] ?>&confirm=true" class="btn btn-primary">Sim</a>
          </div>
         </h5>
      </div>
    </div>
  </section>

<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
