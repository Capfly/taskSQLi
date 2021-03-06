<?php
ini_set( 'session.cookie_httponly', 1 );
session_start();
if(!isset($_REQUEST["do"]) || $_REQUST["do"] == "login") $_SESSION["csrf_token"] = uniqid();
function csrf_token() { return $_SESSION["csrf_token"]; }
require_once("include/Connector.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AdminCP</title>
	<style type="text/css">
		html { font-family: Verdana; font-size: .8em; background: #e2e1e0; }
		input { padding: 5px; }
		body { width: 980px; margin: auto; }
		#content { margin: auto; width: 980px; display: block; }
	        .gbitem {
	                display: block;
	                background: #FFF;
	                box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
	                padding: 5px 20px 20px 20px;
	                border-radius: 2px;
	                margin: 20px 0;
	        }

	</style>
</head>
<body>
<h1>AdminCP</h1>
<?php
if(!$_SESSION['userid']) showLogin();
else showAdminCP();

 function showLogin() {
	if(!empty($_POST) && isset($_POST['do'])) {

			if(!empty($_POST['user']) && !empty($_POST['pass'])) {
				$user = Connector::instance()->real_escape_string($_POST["user"]);
				$pass = Connector::instance()->real_escape_string($_POST["pass"]);

				$query = Connector::instance()->query("SELECT id,role FROM users WHERE username = '".$user."' AND password = '".md5($pass)."';");
				if($query->num_rows === 1) {
					session_regenerate_id();
					$o = $query->fetch_object();
					$_SESSION['userid'] = $o->id;
					$_SESSION['role'] = $o->role;
					showAdminCP();
				}
				else {
					unset($_POST);
					echo "<p>Falsche Zugangsdaten!</p>";
					showLogin();
				}
			}
	}
	else include("include/pages/login.tpl");
 }
 function showAdminCP() {

	if(isset($_REQUEST['do']) && $_REQUEST['do'] != "login") {
		adminPost();
	}
	else {
		include("include/pages/admin.tpl");
	}
 }

 function adminPost() {

	switch($_REQUEST['do']) {
		default: die("Nope");
		case "enable": // only for admins
			if(checkCSRF()) {
				$id = $_REQUEST["id"]; // don't need to escape, it's admin
				$enabled = $_REQUEST["enabled"];
				Connector::instance()->query("UPDATE gb_entries SET enabled = ".$enabled." WHERE id = ".$id." ;");
				echo "<p>Eintrag mit ID ".$id." ".($enabled?"freigeschaltet":"gesperrt").".</p>";
			}
			else die("CSRF-ERROR");
			break;
		case "delete": // admins and mods
			if(checkCSRF()) {
				$id = $_REQUEST["id"]; // --"--
				Connector::instance()->query("DELETE FROM gb_entries WHERE id = ".$id." ;");
				echo "<p>Eintrag mit ID ".$id." gelöscht.</p>";
			}
			else die("CSRF-ERROR");
			break;
	}
	$_SESSION["csrf_token"] = uniqid();
	include("include/pages/admin.tpl");
 }

 function checkCSRF() {
	return (!empty($_REQUEST["token"]) && $_REQUEST["token"] === $_SESSION["csrf_token"]);
 }
?>
</body>
</html>
