<?php
session_start();

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
    unset($_SESSION['eventi'][$eventId]);
    header("location: personalPage.php");
    exit;
} else {
    header("location: personalPage.php");
    exit;
}
?>
