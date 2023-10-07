<?php
require_once('config.php');
session_start();

$emailError = "";
$passwordError = ""; 
$accountError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql_select = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $connection->query($sql_select);
    
    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['logged'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cognome'] = $row['cognome'];
                
                header('location: personalPage.php');
            } else {
                $passwordError = "La password non è valida";
                $accountError = "";
                $_SESSION['passwordError'] = $passwordError;
                $_SESSION['accountError'] = $accountError;
            }
        } else {
            $accountError = "Email o password non sono corretti o Registrati prima di effettuare l'accesso";
            $passwordError = "";
            $_SESSION['accountError'] = $accountError;
            $_SESSION['passwordError'] = $passwordError;
        }
    } else {
        $emailError = "Errore in fase di login";
        $_SESSION['emailError'] = $emailError;
    }
}
?>
