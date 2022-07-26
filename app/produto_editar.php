<?php

// dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');


$error_message = "";
$success_message = "";

// Logica e regras de negocio - Step 1
if($_SERVER['REQUEST_METHOD'] != 'POST'){

  // verifica se existe o id do produto indicado na querystring
  if(!isset($_GET['id'])){
    header('Location: index.php');
    exit;
  }
  
  // chamar a API para buscar os dados do produto
  $produtoRs = api_request('get_product', 'POST', ['id' => $_GET['id']])['data']['results'][0];

}


// Logica e regras de negocio - Step 2
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $id_produto = $_POST['id_produto'];
  $produto = $_POST['text_produto'];
  $quantidade = $_POST['text_qtde'];

  
  $results = api_request('update_product', 'POST', [
    'id_produto' => $id_produto,
    'produto' => $produto,
    'quantidade' => $quantidade,
  ]);
  
  
  // printData($results);
  
  // apresenta o resultado da operação na API
  if($results['data']['status'] == 'ERROR'){
    $error_message = $results['data']['message'];
  } elseif($results['data']['status'] == 'SUCCESS') {
    $success_message = $results['data']['message'];
  }
  
  // recarregar os dados do produto atualizado
  $produtoRs = api_request('get_product', 'POST', ['id' => $id_produto])['data']['results'][0];  

  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor - Editar Produto</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
  <?php include('inc/nav.php') ?>

  <section class="container">
    <div class="row my-5">
      <div class="col-sm-7 offset-sm-2 card bg-light p-4">

        <form action="produto_editar.php" method="POST">
          <input type="hidden" name="id_produto" value="<?= $produtoRs['id_produto'] ?>">

          <div class="mb-3">
            <label>Nome do produto: </label>
            <input type="text" name="text_produto" class="form-control" id="" value="<?= $produtoRs['produto'] ?>">
          </div>
          <div class="mb-3">
            <label>Quantidade: </label>
            <input type="number" name="text_qtde" class="form-control" id="" value="<?= $produtoRs['quantidade'] ?>">
          </div>
          <div class="mb-3 text-center">
            <a href="produtos.php" class="btn btn-secondary btn-sm">Cancelar</a>
            <input type="submit" value="Atualizar" class="btn btn-primary btn-sm">
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
