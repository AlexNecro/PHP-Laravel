<?php

class TestDB {
    private $db;

    public function __construct($dbname, $user, $pass)
    {
        $this->db = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
    }

    public function createTable() {
        $query = "create table if not exists test (
            id int auto_increment primary key,
            firstname varchar(50),
            lastname varchar(50)
        );";
        $this->db->exec($query);
    }
};



$db = new TestDB('test', 'root', '');
$db->createTable();
