<?php
session_start();
$eventId = isset($_GET['id']) ? $_GET['id'] : null;

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("location: index.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location: main.php");
    exit;
}

$eventId = $_GET['id'];

if (isset($_SESSION['eventi'][$eventId])) {
    $evento = $_SESSION['eventi'][$eventId];
} else {
    header("location: main.php");
    exit;
}

$date = $evento['data'];
$title = $evento['titolo'];
$participants = $evento['partecipanti'];
$description = $evento['descrizione'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveChanges'])) {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $participants = $_POST['participants'];
    $description = $_POST['description'];

    $_SESSION['eventi'][$eventId]['data'] = $date;
    $_SESSION['eventi'][$eventId]['titolo'] = $title;
    $_SESSION['eventi'][$eventId]['partecipanti'] = $participants;
    $_SESSION['eventi'][$eventId]['descrizione'] = $description;

    header("location: personalPage.php");
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="containerMain">
    <div class="containerEvent">
        <div class="containerSaluti">
            <?php
                echo "Ciao " . $_SESSION["nome"] . ", modifica l'evento:";
            ?>
        </div>
        <div class="gestionEvent">
            <div class="modifyEvent">
                <form method="post" action="modifyEvent.php?id=<?php echo $eventId; ?>">
                    <label for="date">Data:</label>
                    <input type="date" id="date" name="date" value="<?php echo $date; ?>"><br>
                    
                    <label for="title">Titolo:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
                    
                    <label for="participants">Partecipanti:</label>
                    <input type="text" id="participants" name="participants" value="<?php echo $participants; ?>"><br>
                    
                    <label for="description">Descrizione:</label>
                    <textarea id="description" name="description"><?php echo $description; ?></textarea><br>
                    
                    <button type="submit" name="saveChanges" class="buttonModify">Salva Modifiche</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
