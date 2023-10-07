<?php
// Impostazioni per mostrare gli errori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includi il file di configurazione e il layout
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
        $smtpServer = "sandbox.smtp.mailtrap.io";
        $smtpPort = "2525";
        $smtpAuth = true;
        $smtpUsername = "2e4624f3c91b19";
        $smtpPassword = "46b13a89716a1c";
        $senderEmail = "example@eduSogno.it";

        // Configuro le impostazioni SMTP
        ini_set("SMTP", $smtpServer);
        ini_set("smtp_port", $smtpPort);
        ini_set("smtp_auth", $smtpAuth);
        ini_set("sendmail_from", $senderEmail);
        ini_set("username", $smtpUsername);
        ini_set("password", $smtpPassword);

        // Invio l'email di recupero tramite Mailtrap
        $emailTo = $email;
        $subject = "Recupero Password";
        $message = "Per reimpostare la password, inserisci il seguente token: $tokenRecupero";
        $headers = "From: $senderEmail";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Invio dell'email
        ini_set("mail.add_x_header", "On");
        if (mail ($emailTo, $subject, $message, $headers)) {
            $successMessage = "Email di recupero inviata con successo. Controlla la tua casella di posta.";
            header('Location: reset_password.php');
            exit;
        } else {
            $message = "Errore nell'invio dell'email di recupero: " . error_get_last()['message'];
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
