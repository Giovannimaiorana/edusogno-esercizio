<?php
session_start();
include __DIR__ . '/layout.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminEmail'])) {
    $newAdminEmail = $_POST['adminEmail'];

    // Verifica se l'email è già nell'array
    if (!in_array($newAdminEmail, $_SESSION['adminEmails'])) {
        // Aggiungi l'email all'array
        $_SESSION['adminEmails'][] = $newAdminEmail;

        // Reindirizza l'utente alla pagina da cui è arrivato
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

?>

<!-- HTML per il form di aggiunta email admin -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin Email</title>
</head>
<body>
    <div class="containerMain">
    <button class="backButton" ><a href="./personalPage.php"> Back </a></button>
    <h2>Add Admin Email</h2>
        <div class="containerAddAdmin">
    
    <form class="formStyle" method="post">
        <label for="adminEmail">Inserisci email</label>
        <input type="email" placeholder="Inserisci email" id="adminEmail" name="adminEmail" required>
        <button type="submit"><a href="./personalPage.php">Add Admin</a></button>
    </form>
        </div>
   
    </div>
    
</body>
</html>
