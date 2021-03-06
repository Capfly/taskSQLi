<?php
require_once("include/Connector.php");
$sql_conn = Connector::instance();
?>
<!DOCTYPE html>
<html>
<head>
	<title>SQLi Me</title>
	<meta charset="utf-8" />
	<style type="text/css">
	html { font-family: Verdana; font-size: .9em; }
	body { margin: 0; padding: 20px; background: #e2e1e0; }
	input[type=text],textarea { width: calc(100% - 20px); padding: 10px; }
	input[type=submit] { padding: 5px; margin-top: 5px; }
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
	<h1 align="center">Super Quick'n'dirty Lightweight Internet GUESTBOOK</h1>
	<a style="position: absolute; right: 20px; top: 20px;" href="admin.php">Admin-Bereich</a>
	<p align="center">Willkommen! Sie können gerne einen Gästebuch-Eintrag da lassen! &#x1f60a;</p>
	<div id="content">
		<h2>Gästebuch</h2>
<?php
	$query = $sql_conn->query("SELECT * FROM gb_entries WHERE enabled = 1 ORDER BY id DESC;");
	if($query->num_rows > 0) while($item = $query->fetch_object()) {
?>
		<div class="gbitem">
			<h3><?=htmlentities($item->user)?> <div style="float: right;"><?=date("d.m.Y H:i", strtotime($item->datetime))?></div></h3>
			<?=htmlentities($item->entry)?>
		</div>
<?php } ?>
		<div class="gbitem">
			<form action="entry.php" method="post">
				<h3>Neuer Eintrag</h3>
				<div style="margin: 10px 0; padding-bottom: 5px;">
					<input type="text" placeholder="Dein Username" name="username" autocomplete="off" maxlength="20" />
				</div>
				<textarea rows="8" name="gbentry" placeholder="Deine Nachricht" maxlength="1000"></textarea>
				<div style="text-align: right;"><input type="submit" value="Eintragen" /></div>
			</form>
		</div>
	</div>
	<!--<p align="center">Wir glauben an das Kerkhoff'sche Prinzip, deswegen können Sie die Quellcodes <a href="#" target="_blank">hier</a> herunterladen.</p> - erstmal nur GIT -->
</body>
</html>
