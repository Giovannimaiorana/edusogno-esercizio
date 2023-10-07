<?php
session_start();

// De-registra l'utente (rimuove la variabile di sessione che indica se l'utente è autenticato)
unset($_SESSION['logged']);

// Reindirizza l'utente alla pagina di accesso
header("location: index.php");
exit;
?>