<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University error page</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

  <div class="container d-flex align-items-center" style="min-height: 100vh">
    <div class="alert alert-danger text-center w-100" role="alert">
      <strong><?= $error ?></strong>
      <hr>
      <h4>Commento di Tiziano:</h4>
      <?= $description ?><br>
      <hr>
      <a href="./">Ricarica la pagina</a>

    </div>
  </div>
</body>

</html>