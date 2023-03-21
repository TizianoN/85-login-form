<?php 

// # FUNZIONE LOGIN
function login($conn, $username, $password) {

  // * PROVO AD ESEGUIRE IL SEGUENTE CODICE NEL TRY
  try {
    // * PREPARO LA QUERY IN SICUREZZA CON I PARAMETRI INVIATI DALL'UTENTE E LA ESEGUO
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
    $stmt->bind_param("ss", $username, $password);	
    $stmt->execute();
    
    // * SALVO IL RISULTATO
    $result = $stmt->get_result();
  } catch(Exception $e) {
    // * SE INCONTRO UN ERRORE 

    // * PREPARO DUE VARIABILI DA STAMPARE
    $error = "Errore nella query di login:<br>" . $e->getMessage();
    $description ="Controlla su phpMyAdmin che la tabella sia importata correttamente!";

    // * INCLUDO UNA PAGINA DI ERRORE CUSTOMIZZATA
    include(__DIR__ . "/pages/error_page.php");

    // * INTERROMPO L'ESECUZIONE DEL CODICE
    exit;
  }

  // * SE E' PRESENTE ALMENO UNA RIGA L'UTENTE ESISTE
  if($result->num_rows) {

    // * INIZIALIZZO LA SESSIONE, CI SALVO L'UTENTE, LA CHIUDO
    if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }

    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['ID'];

    session_write_close();

    // * RITORNO TRUE PERCHE' IL LOGIN E' ANDATO A BUON FINE
    return true;
  }
  // * ALTRIMENTI NON C'E' CORRISPONDENZA

  // * RITORNO FALSE PERCHE' IL LOGIN E' FALLITO
  return false;
}

// # FUNZIONE LOGOUT
function logout() {
  // * INIZIALIZZO LA SESSIONE E LA DISTRUGGO
  if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
  }

  session_destroy();
}

// # FUNZIONE GET TABLE LIST
function get_table_list($conn, $table_name) {

  // * PROVO AD ESEGUIRE IL SEGUENTE CODICE NEL TRY
  try {
    // * SELEZIONO TUTTO DALLA TABELLA INTERESSATA ED ESEGUO LA QUERY 
    // * LA QUERY E' SICURA PERCHE' I PARAMETRI NON ARRIVANO DALL'UTENTE 
    $sql = "SELECT * FROM `$table_name`";
    $result = $conn->query($sql);
  } catch(Exception $e) {
    // * SE INCONTRO UN ERRORE 

    // * PREPARO DUE VARIABILI DA STAMPARE
    $error = "Errore nella query di recupero della tabella $table_name:<br>" . $e->getMessage();
    $description ="Controlla su phpMyAdmin che la tabella sia importata correttamente!";

    // * INCLUDO UNA PAGINA DI ERRORE CUSTOMIZZATA
    include(__DIR__ . "/pages/error_page.php");

    // * INTERROMPO L'ESECUZIONE DEL CODICE
    exit;
  }

  // * SALVO OGNI RIGA DEI RISULTATI DELLA QUERY IN UN ARRAY 
  $list = [];
  while($row = $result->fetch_assoc()) {
    $list[] = $row;
  }

  // * RITORNO L'ARRAY GENERATO
  return $list;
}