<?php
require_once("include/Connector.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Neuer Eintrag</title>
</head>
<body>
<?php
	if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['gbentry'])) {
		$user = Connector::instance()->real_escape_string($_POST['username']);
		$entry = Connector::instance()->real_escape_string($_POST['gbentry']);
		$query = Connector::instance()->query("INSERT INTO gb_entries VALUES ( NULL , '".$user."' , '".$entry."' , CURRENT_TIMESTAMP , 0 );") or die("Schwerwiegender Fehler!");
		echo "<p>Ihr Eintrag wurde zur Überprüfung an die Admins gesendet, bitte warten Sie ein paar Minuten bis zur Freigabe! <a href='index.php'>Zurück</a></p>";
	}
	else echo "<p>Bitte alle Felder ausfüllen!</p>";
?>
</body>
</html>
