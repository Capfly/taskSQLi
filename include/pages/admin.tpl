Willkommen!

        <div id="content">
                <h2>Gästebuch - Überprüfung</h2>
<?php
        $query = Connector::instance()->query("SELECT * FROM gb_entries WHERE enabled = 0 ORDER BY id DESC;");
        if($query->num_rows > 0) while($item = $query->fetch_object()) {
?>
                <div class="gbitem">
                        <h3><?=htmlentities($item->user)?> <div style="float: right;"><?=date("d.m.Y H:i", strtotime($item->datetime))?></div></h3>
                        <?=$item->entry?>
			<div style="text-align: right;"><a href="admin.php?do=enable&id=<?=$item->id?>&enabled=1&token=<?=csrf_token()?>">Freischalten</a> | <a href="admin.php?do=delete&id=<?=$item->id?>&token=<?=csrf_token()?>">Löschen</a></div>
                </div>
<?php } ?>
	</div>
