<?php

class TestDB {
    private $db;
    private $insertUsersStmt;

    public function __construct($dbname, $user, $pass)
    {
        $this->db = new PDO('mysql:host=localhost;dbname='.$dbname.";charset=UTF8", $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createTableUsers() {
        $query = "create table if not exists users (
            id int auto_increment primary key,
            name varchar(50),
            age int(3)
        );";
        $this->db->exec($query);
    }

    public function insertToTableUsers($name, $age) {

        if ($this->insertUsersStmt == null) {
            $this->insertUsersStmt = $this->db->prepare("insert into users(name,age) values (?,?)");
        };
        
        $this->insertUsersStmt->execute(array($name, $age));
    }

    public function select($query) {
        return $this->db->query($query);
    }

    public function exec($query) {
        return $this->db->exec($query);
    }
};

class DataGen {
    private $testDB;
    private static $letters = "абвгдеёжзиклмнопрстуфхцчшщьыъэюя";

    public function __construct($testDB) {
        $this->testDB = $testDB;
    }

    public function fillUsers($rows) {

        $this->testDB->insertToTableUsers("Имя на русском", 66);

        while ($rows > 0) {
            $rows--;
            $this->addRandomUser();
        };
    }

    public function selectOld() {

        $stmt = $this->testDB->select("SELECT * from users where age > 50");
        $rows = $stmt->fetchAll();

        return $rows;
    }

    public function selectLike() {

        $stmt = $this->testDB->select("SELECT * from users where name like '%ав%' or name like '%аб%'");
        $rows = $stmt->fetchAll();

        return json_encode($rows,  JSON_UNESCAPED_UNICODE);
    }

    public function makePepitos() {

        $stmt = $this->testDB->select("SELECT * from users where age > 70");
        $rows = $stmt->fetchAll();

        $this->testDB->exec("update users set name = 'Pepito' where age > 70");

        return $rows;
    }

    public function selectNames() {

        $stmt = $this->testDB->select("select distinct name from users");
        $rows = $stmt->fetchAll();

        return $rows;
    }

    protected function addRandomUser() {
        $name = $this->newName();
        $age = $this->newAge();

        $this->testDB->insertToTableUsers($name, $age);
    }

    protected function newName($minLen = 5, $maxLen = 50) {
        
        $size = rand($minLen, $maxLen);
        $strlen = mb_strlen($this::$letters);

        $result = mb_strtoupper(mb_substr($this::$letters, rand(0,$strlen-1),1));

        for ($i=1; $i<$size; $i++) {
            $result .= mb_substr($this::$letters, rand(0,$strlen-1),1);
        };
        //return ucfirst($result);
        return ($result);

    }

    protected function newAge($minAge = 10, $maxAge = 100) {
       return rand($minAge, $maxAge); 
    }

};


print_r('start');

$db = new TestDB('test', 'root', '');
$db->createTableUsers();
$dataGen = new DataGen($db);
$dataGen->fillUsers(1000);

$data = $dataGen->selectOld();

$data2 = $dataGen->selectLike();

$data3 = $dataGen->makePepitos();
//var_dump($data3);

$names = $dataGen->selectNames();
foreach($names as $name)
    print_r($name['name'].'</br>');


print_r('end');
