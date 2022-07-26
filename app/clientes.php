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
$results = api_request('get_all_active_clients', 'GET');

// Analisar a informação obtida
if($results['data']['status'] == 'SUCCESS'){
  $clientes = $results['data']['results'];
} else {
  $clientes = [];
}


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
      <div class="col">

        <div class="row">
          <div class="col">
              <div class="row">
                <div class="col">
                  <h1>Clientes</h1>
                </div>
                <div class="col text-end align-self-center">
                  <a href="cliente_novo.php" class="btn btn-primary btn-sm">Adicionar Cliente</a>
                </div>
              </div>

          </div>
        </div>

      

        <?php if(count($clientes) == 0){?>
          <p class="text-center">Não existem clientes registrados</p>
        <?php } else { ?>
          <table class="table">
            <thead class="table-dark">
              <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th class="text-end">Ação</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($clientes as $cl){ ?>
                <tr>
                  <td><?= $cl['nome'] ?></td>
                  <td><?= $cl['email'] ?></td>
                  <td><?= $cl['telefone'] ?></td>
                  <td class="text-end">
                    <a href="clientes_editar.php?id=<?= $cl['id_cliente'] ?>"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
                    <a href="clientes_apagar.php?id=<?= $cl['id_cliente'] ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <p class="text-end">Total: <strong><?= count($clientes) ?></strong></p>
        <?php } ?>

      </div>
    </div>
  </section>

<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
