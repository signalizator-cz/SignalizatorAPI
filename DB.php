<?php

class DB
{
    private $connection;

    public function __construct($servername, $database, $username, $password)
    {
        try {
            $conString = "mysql:host=$servername;dbname=$database;charset=utf8";
            
            $this->connection = new PDO($conString, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
    
    public function close()
    {
        return $this->connection = null;
    }
}
