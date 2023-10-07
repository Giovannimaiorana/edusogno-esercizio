<?php
// Includo il layout e il file di configurazione
include __DIR__ . '/layout.php';
require_once('config.php');

// Inizializzo variabili per gli errori
$emailError = $nomeError = $cognomeError = $passwordError = "";

// Gestisco la richiesta POST quando il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ricevo e valido i dati dal modulo
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifico se tutti i campi sono stati compilati
    if (empty($nome) || empty($cognome) || empty($email) || empty($password)) {
        $errorMsg = "Tutti i campi devono essere compilati.";
    } else {
        // Verifico se l'indirizzo email è già presente nel database
        $checkEmailQuery = "SELECT * FROM utenti WHERE email = '$email'";
        $checkEmailResult = $connection->query($checkEmailQuery);

        if ($checkEmailResult === false) {
            die("Errore nella query: " . $connection->error);
        }

        if ($checkEmailResult->num_rows === 0) {
            // Nessun indirizzo email trovato, procedo con la registrazione
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $connection->prepare($insertQuery);

            if ($stmt === false) {
                die("Errore nella preparazione della query: " . $connection->error);
            }

            // Eseguo l'inserimento dei dati nel database
            $stmt->bind_param("ssss", $nome, $cognome, $email, $passwordHash);
            if ($stmt->execute()) {
                // Registrazione avvenuta con successo
                $successMsg = "Registrazione avvenuta con successo.";
            } else {
                die("Errore durante l'inserimento dei dati nel database: " . $stmt->error);
            }
        } else {
            // Indirizzo email già presente, gestisco questo caso a mio piacimento
            $emailError = "Questo indirizzo email è già registrato.";
        }
    }
}

// Chiudo la connessione al database
$connection->close();
?>
<!DOCTYPE html>
<html>

<main>
    <div class="containerMain">
        <button class="backButton"><a href="./index.php"> Back</a></button>
        <h2>Crea il tuo Account</h2>
        <div class="containerLogin">
            <form action="./user.php" method="POST" onsubmit="return validateForm();">
                <div class="error-message" id="errorMessage"></div>
                <div class="input">
                    <label for="nome">Inserisci nome</label>
                    <input type="text" placeholder="Mario" id="nome" name="nome">
                </div>
                <div class="input">
                    <label for="cognome">Inserisci cognome</label>
                    <input type="text" placeholder="Rossi" id="cognome" name="cognome">
                </div>
                <div class="input">
                    <label for="email">Inserisci l'email</label>
                    <input type="email" placeholder="name@example.com" id="email" name="email">
                </div>
                <div class="input">
                    <label for="password">Inserisci la password</label>
                    <input type="password" placeholder="Scrivila qui" id="password" name="password">
                </div>
                <div class="buttonGo">
                    <button type="submit" name="login" id="registrationButton">REGISTRATI</button>
                </div>
                <div class="linkRegister">
                    <p>Hai già un account? <a href="index.php">Accedi</a></p>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    function validateForm() {
        var nome = document.getElementById('nome').value;
        var cognome = document.getElementById('cognome').value;
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        var errorMessage = document.getElementById('errorMessage');
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (nome === '' || cognome === '' || email === '' || password === '') {
            errorMessage.textContent = 'Per favore, compila tutti i campi.';
            return false;
        }
        if (!emailRegex.test(email)) {
            errorMessage.textContent = 'L\'indirizzo email non è valido.';
            return false;
        }

        errorMessage.textContent = '';
        return true;
    }
</script>
</html>
