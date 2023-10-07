<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("location: index.php");
    exit;
}

if (!isset($_SESSION['adminEmails'])) {
    $_SESSION['adminEmails'] = array(
        "ulysses200915@varen8.com",
        "qmonkey14@falixiao.com",
        "mavbafpcmq@hitbase.net",
        "dgipolga@edume.me",
        "giovanni.maiorana.14@gmail.com"
    );
}

include __DIR__ . '/layout.php';

// Ottieni l'email dell'utente loggato
$userEmail = $_SESSION["email"];

// Verifica se l'utente è un admin confrontando la sua email con la whitelist
$isUserAdmin = in_array($userEmail, $_SESSION['adminEmails']);

// Se l'utente non è un admin, reindirizzalo a un'altra pagina
if (!$isUserAdmin) {
    header("location: userPage.php");
    exit;
}

// Inizializza o recupera l'array degli eventi dalla sessione
if (!isset($_SESSION['eventi'])) {
    $_SESSION['eventi'] = array();
}

// Aggiungi un nuovo evento se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Raccogli i dati dal form
    $date = $_POST['date'];
    $title = $_POST['title'];
    $participants = $_POST['participants'];
    $description = $_POST['description'];
    
    // Crea un nuovo evento
    $nuovoEvento = array(
        'data' => $date,
        'titolo' => $title,
        'partecipanti' => $participants,
        'descrizione' => $description
    );
    
    // Aggiungi evento all'array degli eventi nella sessione
    $_SESSION['eventi'][] = $nuovoEvento;
}
?>

<div class="containerMain">
    <button class="backButton"><a href="./logout.php"> LogOut</a></button>
    <a class="addTask" href="./addEvent.php"> Add Event </a>
    <a class="addAdmin" href="./addAdmin.php"> Add Admin </a>
    <div class="containerEvent">
        <div class="containerSaluti">
            <?php
                echo '<div class="dinamicMessage">Ciao ' . $_SESSION["nome"] . ' ecco i tuoi eventi</div>';
             ?>
        </div>
        <div class="gestionEvent">
            <?php foreach ($_SESSION['eventi'] as $index => $evento) { ?>
                <div class="evento">
                    <h3><?php echo $evento['titolo']; ?></h3>
                    <p>Data: <?php echo $evento['data']; ?></p>
                    <a href="singleEvent.php?id=<?php echo $index; ?>" class="buttonShow">JOIN</a>
                </div>
            <?php } ?>
        </div>
        <!-- Ciclo foreach per creare un div per ogni evento -->
    </div>
</div>
</body>
</html>
