<?php

 class Connector {

	private $server = "localhost";
	private $user = "sqli_gb_user";
	private $pass = "AaQGrvf2q993XpBJ";
	private $db = "sqli_guestbook";
	private static $instance;
	private $connection;

	private function __construct() {

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$this->connection = new mysqli($this->server,$this->user,$this->pass,$this->db);
		if($this->connection->connect_errno)
			throw new Exception("The database connection could not be established: ".$this->connection->connect_error);
		else $this->connection->query("SET NAMES 'utf8';");
	}

	public static function instance() {

		try {
			if(!(self::$instance instanceof MySQLi)) {
				self::$instance = new Connector();
			}
			return self::$instance->connection;
		}
		catch(Exception $e) { die("Exception: ".$e->getMessage()); }
	}
 }
