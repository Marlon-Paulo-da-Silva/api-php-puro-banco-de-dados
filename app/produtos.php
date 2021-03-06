<?php

// dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');


// // ------------------------------------------------------
// echo '<h3>CLIENTES TODOS</h3>';
// $results = api_request('get_all_clients', 'GET');
// foreach($results['data']['results'] as $client){
//   echo $client['nome'].' - '.$client['email'].'<br />';
// }
// echo '<hr>';

// Logica e regras de negocio
$results = api_request('get_all_products', 'GET');

// Analisar a informação obtida
if($results['data']['status'] == 'SUCCESS'){
  $produtos = $results['data']['results'];
} else {
  $produtos = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor - Produtos</title>
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
                    <h1>Produtos</h1>
                  </div>
                  <div class="col text-end align-self-center">
                    <a href="produto_novo.php" class="btn btn-primary btn-sm">Adicionar Produtos</a>
                  </div>
                </div>

            </div>
          </div>

        <?php if(count($produtos) == 0){?>
          <p class="text-center">Não existem clientes registrados</p>
        <?php } else { ?>
          <table class="table">
            <thead class="table-dark">
              <tr>
                <th width="50%" class="">Nome</th>
                <th width="50%" class="text-end">Quantidade (estoque)</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($produtos as $pr){ ?>
                <tr>
                  <td><?= $pr['produto'] ?></td>
                  <td class="text-end"><?= $pr['quantidade'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <p class="text-end">Total de produtos: <strong><?= count($produtos) ?></strong></p>
        <?php } ?>

      </div>
    </div>
  </section>
<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
