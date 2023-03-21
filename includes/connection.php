<?php 

// * PREPARO I PARAMETRI DI CONNESSIONE
const DB_SERVERNAME = "localhost";
const DB_PORT = "3306";
const DB_USERNAME = "root";
const DB_PASSWORD = "root";
const DB_NAME = "85_university_login";

// * PROVO AD ESEGUIRE LA CONNESSIONE NEL TRY
try {
  $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
} catch(Exception $e) {
  // * SE INCONTRO UN ERRORE 
  
  // * PREPARO DUE VARIABILI DA STAMPARE
  $error = "Connessione fallita:<br>" . $e->getMessage();
  $description ="Ricorda di importare il database e controlla i parametri di connessione di MAMP!";

  // * INCLUDO UNA PAGINA DI ERRORE CUSTOMIZZATA
  include(__DIR__ . "/pages/error_page.php");

  // * INTERROMPO L'ESECUZIONE DEL CODICE
  exit;
}