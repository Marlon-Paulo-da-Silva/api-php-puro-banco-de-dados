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

$error_message = "";
$success_message = "";

// Logica e regras de negocio
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $produto = $_POST['text_produto'];
  $quantidade = $_POST['text_qtde'];

  $results = api_request('create_new_product', 'POST',[
    'produto' => $produto,
    'quantidade' => $quantidade
  ]);


  // apresenta o resultado da operação na API


  if($results['data']['status'] == 'ERROR'){
    $error_message = $results['data']['message'];
  } elseif($results['data']['status'] == 'SUCCESS') {
    $success_message = $results['data']['message'];
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor -  Novo Produto</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
  <?php include('inc/nav.php') ?>

  <section class="container">
    <div class="row my-5">
      <div class="col-sm-7 offset-sm-2 card bg-light p-4">

        <form action="produto_novo.php" method="POST">
          <div class="mb-3">
            <label>Nome do produto: </label>
            <input type="text" name="text_produto" class="form-control" id="">
          </div>
          <div class="mb-3">
            <label>Quantidade: </label>
            <input type="number" name="text_qtde" class="form-control" id="">
          </div>
          <div class="mb-3 text-center">
            <a href="produtos.php" class="btn btn-secondary btn-sm">Cancelar</a>
            <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
          </div>

          <?php if(!empty($error_message)){ ?>
            <div class="alert alert-danger p-2 text-center">
              <?= $error_message ?>
            </div>
          <?php } elseif (!empty($success_message)){ ?>
            <div class="alert alert-success p-2 text-center">
              <?= $success_message ?>
            </div>
          <?php } ?>


        </form>

      </div>
    </div>
  </section>

<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
