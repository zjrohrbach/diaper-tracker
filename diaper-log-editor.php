<?php session_start() ?>
<html>
<head>
	<title>Editing Caroline's Feeding & Diaper log</title>
	<link rel="stylesheet" href="caroline.css" />
	<meta http-equiv="refresh" content="60">
</head>
<body>
<?php

if (!isset($_SESSION['authorized']) || !$_SESSION['authorized']){
	echo '
		<form method="post" action="diaper-track.php">
			<p>
				Password:
				<input type="password" name="pass" />
			</p>
			<input type="submit" value="Log In">
		</form>
	';
	echo '</body></html>';
	exit;
}

if (isset($_POST['submit'])) {
		if(copy('diaper-log.txt','backups/diaper-log.txt.backup'.date('Ymd-H.i.s'))) {
			echo 'good';
		} else {
			echo 'bad';
		}
		file_put_contents('diaper-log.txt',$_POST['log-contents']);
		echo '<div id="success">';
		echo '<p>Log Saved!</p>';
		echo '<p><a href="diaper-track.php">Go back to Diaper Tracker</a></p>';
		echo '</div>';
		echo '<pre>';
		echo $_POST['log-contents'];
		echo '</pre>';
		exit();
}

?>
<div>
	<form method="post" action="diaper-log-editor.php">
		<p>
		<textarea name="log-contents" rows="15"><?php echo file_get_contents('diaper-log.txt') ?></textarea>
		</p>
		<p>
			<input type="submit" name="submit" value="save" class="feed" /><br />
		</p>
	</form>
</div>


</body>
</html>
