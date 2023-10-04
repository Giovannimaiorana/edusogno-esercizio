<?php

require_once('config.php');
$email = $connection->real_escape_string($_POST['email']);
$password = $connection->real_escape_string($_POST['password']);

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql_select = "SELECT * FROM utenti WHERE email = '$email'";

    if($result = $connection->query($sql_select)){
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if($password == $row['password']){
            session_start();

            $_SESSION['logged'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            header('location: personalPage.php');
       
            } else{
                echo "La password non è valida";
            }

        } else{
        echo "Non ci sono account con questa email";
        }
    }else{
        echo "Errore in fase di login";
    }
    
    $connection->close();
}