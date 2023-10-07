<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $connection->real_escape_string($_POST['nome']);
    $cognome = $connection->real_escape_string($_POST['cognome']);
    $email = $connection->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($nome) || empty($cognome) || empty($email) || empty($_POST['password'])) {
        $_SESSION['registration_error'] = "Per favore, compila tutti i campi del modulo.";
    } else {
        $sql_select = "SELECT * FROM utenti WHERE email = '$email'";
        $result = $connection->query($sql_select);

        if ($result) {
            if ($result->num_rows > 0) {
                $_SESSION['registration_error'] = "Questa email è già registrata.";
            } else {
                $sql_insert = "INSERT INTO utenti (nome, cognome, email, password) VALUES ('$nome', '$cognome', '$email', '$password')";

                if ($connection->query($sql_insert) === TRUE) {
                    $_SESSION['registration_success'] = "Registrazione avvenuta con successo.";
                    header('location: index.php');
                    exit;
                } else {
                    $_SESSION['registration_error'] = "Errore durante la registrazione: " . $connection->error;
                }
            }
        } else {
            $_SESSION['registration_error'] = "Errore durante la registrazione";
        }
    }

    $connection->close();
}

if (isset($_SESSION['registration_error'])) {
    header('location: register.php');
} else {
    header('location: index.php');
}

exit;
?>
