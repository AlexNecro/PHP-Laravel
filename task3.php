<?php

//* =========== interfaces ============== */
interface IDBConnection {
	public function __construct($dbname, $user, $pass);
	public function select($query);
	public function exec($query);
	public function lastInsertId();

};

interface IDataAdapter { //smth like templates needed: DataAdapter<T>
	public function __construct($dbconnection);
	public function all();
	public function create($title, $text, $source);
};

interface IPublication {
	public function getSource();
	public function getContent();
	public function getAll();
};

//* =========== implementations ============== */
class MysqlConnection implements IDBConnection{
    private $db;
    private $insertUsersStmt;

    public function __construct($dbname, $user, $pass)
    {
        $this->db = new PDO('mysql:host=localhost;dbname='.$dbname.";charset=UTF8", $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
    public function select($query) {
        return $this->db->query($query);
    }

    public function exec($query) {
        return $this->db->exec($query);
	}
	
	public function lastInsertId() {
		return $this->db->lastInsertId();
	}
};

class AnnounceDB implements IDataAdapter { //smth like templates needed: DataAdapter<T>
	private $db;
	public function __construct($dbconnection) {

		$this->db = $dbconnection;

		$query = "create table if not exists announces (
            id int auto_increment primary key,
            title varchar(20), text text, author varchar(20), created_at datetime, updated_at datetime
        );";
        $this->db->exec($query);
	}

	public function all(){

		$data = $this->db->select("select * from announces");

		$all = [];
		foreach ($data as $record) {
			array_push($all, new Announce($record["id"], $record["title"], $record["text"], $record["author"]));
		}

		return $all;
	}

	public function create($title, $text, $author) {
		$this->db->exec("insert into announces(title,text,author) values ('$title', '$text', '$author')");
		$obj = new Announce($this->db->lastInsertId(), $title, $text, $author);
		return $obj;
	}
};

class NewsDB implements IDataAdapter { //smth like templates needed: DataAdapter<T>
	private $db;
	public function __construct($dbconnection) {

		$this->db = $dbconnection;

		$query = "create table if not exists news (
            id int auto_increment primary key,
            title varchar(20), text text, link varchar(20), created_at datetime, updated_at datetime
        );";
        $this->db->exec($query);
	}

	public function all(){

		$data = $this->db->select("select * from news");

		$all = [];
		foreach ($data as $record) {
			array_push($all, new News($record["id"], $record["title"], $record["text"], $record["link"]));
		}

		return $all;
	}

	public function create($title, $text, $link) {
		$this->db->exec("insert into news(title,text,link) values ('$title', '$text', '$link')");
		$obj = new News($this->db->lastInsertId(), $title, $text, $link);
		return $obj;
	}
};

class Announce implements IPublication {
	//friend AnnounceDB;  //doesnt work, cant make factory
	protected $id;
	protected $title;
	protected $author;
	protected $text;

	public function __construct($id, $title, $text, $author) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		$this->author = $author;
	}

	public function getContent() {
		return $this->text;
	}

	public function getSource() {
		return $this->author;
	}

	function getAll() {
		return $this->getContent() + $this->getSource();
	}

};

class News implements IPublication {
	protected $id;
	protected $title;
	protected $link;
	protected $text;

	public function __construct($id, $title, $text, $link) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		$this->link = $link;
	}

	public function getContent() {
		return $this->text;
	}

	public function getSource() {
		return $this->link;
	}

	function getAll() {
		return $this->getContent() + $this->getSource();
	}

};

//* ==================== helper funcs ============================ */
function println($text = "") {
	echo($text."<br>");
}

/* ======================= code =========================== */

$db = new MysqlConnection('test', 'root', '');
$announces = new AnnounceDB($db);
$news = new NewsDB($db);

for ($i = 0; $i < 100; $i++) {
	$announces->create("Announce $i", "Announce text $i", "Announce author $i");
	$news->create("News $i", "News $i", "Pepito");
};

$allnews = $news->all();
$allannounces = $announces->all();

foreach ($allnews as $pub) {
	println($pub->getContent() . " // " . $pub->getSource()); //no meth for Title!!!
}

foreach ($allannounces as $pub) {
	println($pub->getContent() . " // " . $pub->getSource());
}

