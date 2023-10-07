<?php 
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("location: index.php");
    exit;
}
include __DIR__ . '/layout.php';

if (!isset($_SESSION['eventi'])) {
    $_SESSION['eventi'] = array();
}
?>

<div class="containerMain">
<button class="backButton"><a href="./logout.php"> LogOut</a></button>
    <div class="containerEvent">
        <div class="containerSaluti">
            <h2>Ecco gli eventi in programma</h2>
        </div>
        <div class="gestionEvent">
            <?php foreach ($_SESSION['eventi'] as $index => $evento) { ?>
                <div class="evento">
                    <h3><?php echo $evento['titolo']; ?></h3>
                    <p>Data: <?php echo $evento['data']; ?></p>
                    <p>Partecipanti: <?php echo $evento['partecipanti']; ?></p>
                    <p>Descrizione: <?php echo $evento['descrizione']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
