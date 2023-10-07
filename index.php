<!DOCTYPE html>
<html lang="en">

<?php
require_once('config.php');
require_once('login.php');

$emailError = isset($_SESSION['emailError']) ? $_SESSION['emailError'] : "";
$passwordError = isset($_SESSION['passwordError']) ? $_SESSION['passwordError'] : "";
$accountError = isset($_SESSION['accountError']) ? $_SESSION['accountError'] : "";

unset($_SESSION['redirectToPersonalPage']);

include __DIR__ . '/layout.php';
?>

<div class="containerMain">
    <h2>Hai già un account?</h2>
    <div class="containerLogin">
        <form method="POST">
            <?php
            if (isset($_POST['login'])) {
                echo '<span class="error-message">' . $accountError . '</span>';
            }
            ?>
            <div class="input">
                <label for="email">Inserisci l'email</label>
                <input type="mail" placeholder="name@example.com" id="email" name="email">
                <?php
                if (isset($_POST['login'])) {
                    echo '<span class="error-message">' . $emailError . '</span>';
                }
                ?>
            </div>
            <div class="input">
                <label for="password">Inserisci la password</label>
                <input type="password" placeholder="Scrivila qui" id="password" name="password">
                <span toggle="#password" class="toggle-password"><i class="fa-solid fa-eye"></i></span>
                <?php
                if (isset($_POST['login'])) {
                    echo '<span class="error-message">' . $passwordError . '</span>';
                }
                ?>
            </div>
            <div class="buttonGo">
                <button type="submit" name="login">ACCEDI</button>
            </div>
            <div class="linkRegister">
                <p>Non hai ancora un profilo? <a href="register.php">Registrati</a></p>
            </div>
            <div class="linkRegister">
                <p>Hai dimenticato la password? <a href="passwordRecovery.php">Recuperala qui</a></p>
            </div>
        </form>
    </div>
</div>

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

