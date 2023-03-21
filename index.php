<?php 

// # HO RICEVUTO UN FORM DI LOGIN
if(isset($_POST["username"]) && isset($_POST["password"])) {
  // * INCLUDO I FILE PARZIALI
  require_once __DIR__ . "/includes/connection.php";
  require_once __DIR__ . "/includes/functions.php";

  // * RECUPERO I DATI INVIATI DALL'UTENTE
  $username = $_POST["username"];
  $password = md5($_POST["password"]);

  // * INVOCO LA FUNZIONE LOGIN E NE SALVO IL RISULTATO
  $attemped_login_result = login($conn, $username, $password);
}

// # HO RICEVUTO UN FORM DI LOGOUT
if(isset($_POST["logout"])) {
  // * INCLUDO I FILE PARZIALI
  require_once __DIR__ . "/includes/functions.php";
  
  // * INVOCO LA FUNZIONE LOGOUT
  logout();
}

// # PREPARATIVI PER VISUALIZZARE LA PAGINA

// * INIZIALIZZO LA SESSIONE
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

// * CREO UNA VARIABILE BOOLEANA PER SAPERE VELOCEMENTE SE L'UTENTE E' LOGGATO 
$user_logged = isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0;

// * CHIUDO LA SESSIONE
session_write_close();

// # SE L'UTENTE E' LOGGATO HO BISOGNO DELLA LISTA DEI DIPARTIMENTI
if($user_logged) {
  // * INCLUDO I FILE PARZIALI
  require_once __DIR__ . "/includes/connection.php";
  require_once __DIR__ . "/includes/functions.php";
  
  // * INVOCO LA FUNZIONE GET TABLE LIST E SALVO IL RISULTATO IN UNA VARIABILE
  $departments = get_table_list($conn, "departments");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
  <div class="container d-flex align-items-center py-5" style="min-height: 100vh">
    <div class="card <?= !$user_logged ? "w-50" : "" ?> mx-auto">
      <div class="card-header">

        <?php if(!$user_logged) : ?>
        Login form
        <?php else : ?>
        <form method="POST">
          <button class="btn btn-link" name="logout" value="1">
            Logout
          </button>
        </form>
        <?php endif; ?>

      </div>
      <div class="card-body">
        <?php if(!$user_logged) : ?>

        <?php if(isset($attemped_login_result) && $attemped_login_result == false) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Accesso fallito.</strong> Controlla le credenziali e riprova.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text bg-white">
                <i class="bi bi-person-circle"></i>
              </span>
              <input type="text" class="form-control" id="username" name="username"
                value="<?= isset($username) ? $username : ""?>">
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text bg-white">
                <i class="bi bi-key"></i>
              </span>
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <hr>
          <small>username:</small> <code>mario</code><br>
          <small>password</small>: <code>password</code>
          <hr>
          <small><strong>Ricorda di importare il database!</strong></small>
        </form>
        <?php else : ?>
        <h1 class="my-4">Area riservata</h1>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Indirizzo</th>
              <th scope="col">Responsabile</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($departments as $department) : ?>
            <tr>
              <th scope="row"><?= $department["id"] ?></th>
              <td><?= $department["name"] ?></td>
              <td><?= $department["address"] ?></td>
              <td><?= $department["head_of_department"] ?></td>
              <td>
                <a href="mailto:<?= $department["email"] ?>"><i class="bi bi-envelope mx-2"></i></a>
                <a href="tel:<?= $department["phone"] ?>"><i class="bi bi-telephone mx-2"></i></a>
                <a href="<?= $department["website"] ?>"><i class="bi bi-box-arrow-up-right mx-2"></i></a>

              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
</body>

</html>