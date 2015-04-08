<?php
// A class holds a bunch of code and relevant data together, isolated from everything else. 
// It makes it easier to change the code around without disrupting other code, without affecting other classes.
// You can call it anytime because it's an object.
class Database {
	private $connection;
	private $host;
	private $username;
	private $password;
	private $database;
	public $error;
// Added a public error variable to prevent errors.
// This is storing variables into a construct function.
	public function __construct($host, $username, $password, $database) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		// It's connnecting to the datbase.
		$this->connection = new mysqli($host, $username, $password);
		// If you get an error, it will print out an error.
		if($this->connection->connect_error) {
			die("<p>Error: " . $this->connection->connect_error . "</p>");
		}
		// This is going to try and access a database that exists on the server.
		$exists = $this->connection->select_db($database);
		// This will create a database.
		if(!$exists) {
			$query = $this->connection->query("CREATE DATABASE $database");
	
		// And this will echo out if the database was created successfully.
		if($query) {
			echo "</p>";
		}
		} 
		// This echos out that the database has already been added.
		else {
			echo "<p>Database already exists.</p>";
		}
	}
	public function openConnection() {
		$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
	// If you get an error, it will print out an error.
	if($this->connection->connect_error) {
		die("<p>Error: " . $this->connection->connect_error . "</p>");
	}
	}
// The isset function is checking to see if the variable is set or not. And it is closing the connection.
	public function closeConnection() {
		if(isset($this->connection)) {
			$this->connection->close();
		}
	}
	public function query($string) {
		$this->openConnection();
		$query = $this->connection->query($string);
		if(!$query) {
			$this->error = $this->connection->error;
		}
		$this->closeConnection();
		return $query;
	}
}
//A function is a block of statements that can be used repeatedly in a program. It will not execute immediately when a page loads. But it will be executed by a call to the function.
