<?php

//definisco le credenziali del DB
define('db_servername', 'localhost');
define('db_username', 'root');
define('db_password', 'root');
define('db_name', 'edusogno');
define('db_port', 3306);

class DB
{
    static public function getConnection()
    {


        $connection = new mysqli(db_servername, db_username, db_password, db_name, db_port);

        if ($connection && $connection->connect_error) {
            echo $connection->connect_error;
        };

        return $connection;
    }

    static public function Migration($path)
    {

        //controllo l'esistenza della tabella
        $connection = DB::getConnection();
        $checkTableQuery = "SHOW TABLES LIKE 'eventi'";
        $tableExists = $connection->query($checkTableQuery);

        //se non esiste viene eseguita la migration
        if (!$tableExists->num_rows > 0) {
            $queries = file($path);
            $query = '';

            foreach ($queries as $line) {
                $query .= $line;
                //controllo fine query
                $endLine = substr(trim($line), -1);

                if ($endLine == ';') {
                    $connection->query($query);
                    $query = '';
                }
            }
        }
        $connection->close();
    }
}