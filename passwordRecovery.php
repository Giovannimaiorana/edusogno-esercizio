<?php

// Includo le librerie di PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Impostazioni per mostrare gli errori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includo il file di configurazione e il layout
require_once('config.php');
include __DIR__ . '/layout.php';

// Inizializzo le variabili per i messaggi di successo e di errore
$message = "";
$error = "";

// Verifico se è stata inviata una richiesta POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Connessione al database (assicurati che il file config.php contenga le credenziali)
    $connection = new mysqli($host, $username, $password, $db, $port);

    // Verifico la connessione al database
    if ($connection->connect_error) {
        die("Errore di connessione al database: " . $connection->connect_error);
    }

    // Eseguo la query per cercare l'utente con l'email specificata nel database
    $sql_select = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $connection->query($sql_select);

    if ($result->num_rows == 1) {
        $message = "Link per il recupero della password inviato.";

        // Genero un token di recupero casuale
        $tokenRecupero = bin2hex(random_bytes(32));

        // Aggiorno il token di recupero nel database (assicurati di avere un campo 'token_recupero_password')
        $updateTokenQuery = "UPDATE utenti SET token_recupero_password = '$tokenRecupero' WHERE email = '$email'";
        $connection->query($updateTokenQuery);

        // Impostazioni di Mailtrap
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '2e4624f3c91b19';
        $mail->Password = '46b13a89716a1c';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 25;

        // Destinatario e mittente
        $emailTo = $email;
        $senderEmail = "example@eduSogno.it";

        $mail->setFrom($senderEmail);
        $mail->addAddress($emailTo);

        // Oggetto e corpo del messaggio
        $subject = "Recupero Password";
        $message = "Per reimpostare la password, inserisci il seguente token: $tokenRecupero";
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            $mail->send();
            $message = "Email di recupero inviata con successo. Controlla la tua casella di posta.";
            header('Location: reset_password.php');
            exit;
        } catch (Exception $e) {
            $error = "Errore nell'invio dell'email di recupero: " . $mail->ErrorInfo;
        }
    } else {
        // Nessun account trovato con l'email specificata
        $error = "Nessun account con l'email $email.";
    }

    // Chiudo la connessione al database
    $connection->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Includi qui il collegamento al tuo foglio di stile CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="./passwordRecovery.php" method="POST">
        <div class="containerMain">
            <button class="backButton" ><a href="./index.php"> Torna indietro</a></button>
            <div class="containerRecovery">
            <span class="error"><?php echo $error; ?></span> <!-- Messaggio di errore -->
                <span class="message"><?php echo $message; ?></span> <!-- Messaggio di successo -->
                <label for="email">Inserisci l'email associata all'account:</label>
                <input type="email" id="email" placeholder="Inserisci email" name="email" required>
                <button class="buttonSend" type="submit">Invia email </button>
            </div>
        </div>
    </form>
</body>
</html>
