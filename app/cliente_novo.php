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
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $nome = $_POST['text_nome'];
  $email = $_POST['text_email'];
  $telefone = $_POST['text_telefone'];

  $results = api_request('create_new_client', 'POST',[
    'nome' => $nome,
    'email' => $email,
    'telefone' => $telefone
  ]);

  printData($results);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Consumidor -  Novo Cliente</title>
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
  <?php include('inc/nav.php') ?>

  <section class="container">
    <div class="row my-5">
      <div class="col-sm-7 offset-sm-2 card bg-light p-4">

        <form action="cliente_novo.php" method="POST">
          <div class="mb-3">
            <label>Nome do cliente: </label>
            <input type="text" name="text_nome" class="form-control" id="">
          </div>
          <div class="mb-3">
            <label>Telefone: </label>
            <input type="text" name="text_telefone" class="form-control" id="">
          </div>
          <div class="mb-3">
            <label>E-mail: </label>
            <input type="email" name="text_email" class="form-control" id="">
          </div>
          <div class="mb-3 text-center">
            <a href="clientes.php" class="btn btn-secondary btn-sm">Cancelar</a>
            <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
          </div>
        </form>

      </div>
    </div>
  </section>

<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
