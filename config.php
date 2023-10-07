<?php
$host = "127.0.0.1";
$username = 'root';
$password = 'root';
$db = 'edusogno-db';
$port = '3306';

// Connessione al database
$connection = new mysqli($host, $username, $password, $db, $port);

if ($connection->connect_error) {
    die("Errore durante la connessione al server: " . $connection->connect_error);
}

// Query per creare le tabelle
$queryCreateTableUtenti = "
CREATE TABLE IF NOT EXISTS utenti (
  id int NOT NULL AUTO_INCREMENT,
  nome varchar(45),
  cognome varchar(45),
  email varchar(255),
  password varchar(255),
  token_recupero_password varchar(255),
  PRIMARY KEY (id)
);
";

$queryCreateTableEventi = "
CREATE TABLE IF NOT EXISTS eventi (
  id int NOT NULL AUTO_INCREMENT,
  attendees text,
  nome_evento varchar(255),
  data_evento datetime,
  PRIMARY KEY (id)
);
";

// Esegui le query per creare le tabelle
if ($connection->query($queryCreateTableUtenti) === TRUE) {
   
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connection->error . "<br>";
}

if ($connection->query($queryCreateTableEventi) === TRUE) {
    
} else {
    echo "Errore durante la creazione della tabella 'eventi': " . $connection->error . "<br>";
}

// Query per inserire dati nella tabella 'eventi'
$queryInsertData = "
INSERT INTO eventi (attendees, nome_evento, data_evento)
VALUES
  ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 1', '2022-10-13 14:00'),
  ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 2', '2022-10-15 19:00'),
  ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net', 'Test Edusogno 2', '2022-10-15 19:00');
";

// Esegui la query per inserire i dati
if ($connection->query($queryInsertData) === TRUE) {
   
} else {
    echo "Errore durante l'inserimento dei dati nella tabella 'eventi': " . $connection->error . "<br>";
}


?>
