<?php
session_start();

// Verifica se sono autenticato
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("location: index.php");
    exit;
}

// Verifica se ho passato l'ID dell'evento come parametro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location: main.php");
    exit;
}

$eventId = $_GET['id'];

// Verifica se l'evento con l'ID specificato esiste nella sessione
if (isset($_SESSION['eventi'][$eventId])) {
    $evento = $_SESSION['eventi'][$eventId];
} else {
    header("location: main.php");
    exit;
}

include __DIR__ . '/layout.php';
?>

<div class="containerMain">
    <div class="containerEvent">
        <div class="containerSaluti">
            <p class="detalis">Ecco i dettagli dell'evento</p>
        </div>
        <div class="gestionEvent">
        <div class="gestionEvent">
    <div class="singleEvent">
        <h3><?php echo $evento['titolo']; ?></h3>
        <p>Data: <?php echo $evento['data']; ?></p>
        <p>Partecipanti: <?php echo $evento['partecipanti']; ?></p>
        <p>Descrizione: <?php echo $evento['descrizione']; ?></p>
        <div class="containerButton">
        <form method="post" action="modifyEvent.php?id=<?php echo $eventId; ?>">
            <button type="submit" name="modifyEvent" class="buttonModify">Modifica Evento</button>
        </form>
        <form method="post" action="deleteEvent.php?id=<?php echo $eventId; ?>">
            <button type="submit" name="deleteEvent" class="buttonDelete">Elimina Evento</button>
        </form>
        </div>
       
    </div>
</div>

        </div>
    </div>
</div>
</body>
</html>
