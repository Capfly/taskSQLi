<?php

 class Connector {

	private static $server;
	private static $user;
	private static $pass;
	private static $db;
	private static $connection;

	public function __construct() {
		self::$server = "localhost";
		self::$user = "sqli_gb_user";
		self::$pass = "uBqfZKvRqCwFxNSe";
		self::$db = "sqli_guestbook";
	}

	public static function instance() {

		try {
			if(!self::$connection instanceof MySQLi) {
				self::$connection = @new mysqli(self::$server,self::$user,self::$pass,self::$db);
				if(self::$connection->connect_errno) {
					@session_start();
					$_SESSION["flash"] = [["Fehler in der Datenbankverbindung!","error"]];
					self::$connection = new self();
				}
			}
			self::$connection->query("SET NAMES 'utf8';");
			return self::$connection;
		}
		catch(Exception $e) { die("E"); }
	}
	function query($query) {
		$o = new StdClass();
		$o->num_rows = 0;
		return $o;
	}
 }
