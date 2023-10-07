<?php
require_once('config.php');
session_start();
include __DIR__ . '/layout.php';

$message = "";

// Verifica se è stata inviata una richiesta POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];

    $connection = new mysqli($host, $username, $password, $db, $port);

    // Verifico la connessione al database
    if ($connection->connect_error) {
        die("Errore di connessione al database: " . $connection->connect_error);
    }

    // Eseguo la query per cercare un utente con il token specificato nel mio database
    $sql_select = "SELECT * FROM utenti WHERE token_recupero_password = '$token'";
    $result = $connection->query($sql_select);

    if ($result) {
        if ($result->num_rows == 1) {
            // Token valido, recupero l'ID dell'utente
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            // Genero l'hash della nuova password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Eseguo la query per aggiornare la password nel database
            $sql_update = "UPDATE utenti SET password = '$hashedPassword', token_recupero_password = NULL WHERE id = $userId";

            if ($connection->query($sql_update) === TRUE) {
                // Password aggiornata con successo, posso reindirizzare l'utente o mostrare un messaggio di conferma
                header('Location: index.php?success=true');
                exit;
            } else {
                // Gestisco l'errore nell'aggiornamento della password
                $message = "Errore nell'aggiornamento della password: " . $connection->error;
            }
        } else {
            // Token non valido, mostro un messaggio di errore
            $message = "Token non valido. Inserisco un token valido.";
        }
    } else {
        // Errore nella query
        $message = "Errore in fase di ricerca nel database: " . $connection->error;
    }

    // Chiudo la connessione al database
    $connection->close();
}
?>

<!DOCTYPE html>
<body>
<form method="POST">
    <div class="containerMain">
        <div class="containerRecovery">
            <span><?php echo $message; ?></span>
            <label for="token">Inserisco il token ricevuto per email</label>
            <input type="text" placeholder="Inserisco token" name="token" required>
            <label for="new_password">Inserisco nuova Password</label>
            <input type="password" id="password" placeholder="Inserisco nuova password" name="new_password" required>
            <span toggle="#password" class="toggle-password"><i class="fa-solid fa-eye"></i></span>
            <button class="buttonSend" type="submit">Recupero la qui</button>
        </div>
    </div>
</form>
</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
});
</script>

