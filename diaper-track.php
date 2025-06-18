<?php session_start() ?>
<html>
<head>
	<title>Caroline's Feeding & Diaper Tracker</title>
	<link rel="stylesheet" href="caroline.css" />
	<meta http-equiv="refresh" content="60; url=diaper-track.php">
	<script>
		let now = new Date();
		let timezoneOffset = now.getTimezoneOffset() * 60000;
		let localDate = new Date(now - timezoneOffset);
		window.addEventListener("load", () => {document.getElementById('time').value = localDate.toISOString().slice(0,16)});
	</script>
</head>
<body>
<?php

$correct_password = 'yes';

if (isset($_POST['pass'])) {
	if($_POST['pass'] == $correct_password) {
		$_SESSION['authorized'] = true;
		header("Location: diaper-track.php");
	} else {
			echo '<div id="failure">';
		echo '<p>Incorrect Password</p>';
		echo '<p><a href="diaper-track.php">Try Again</a></p>';
		echo '</div>';
		echo '</body></html>';
		exit;
	}
}

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


if (isset($_GET['time'])) {
	$the_date = strtotime($_GET['time']);
	$time_to_insert = date('m/d h:i a', $the_date);
	$entry_insert="\n".$time_to_insert.':  '.$_GET['entry'];
	file_put_contents('diaper-log.txt', $entry_insert, FILE_APPEND | LOCK_EX );
	sleep(1);
	header("Location: diaper-track.php?success=true");
	exit();
}


if (isset($_GET['success'])) {
	echo '<div id="success">';
	echo '<p>Entry logged!</p>';
	echo '<p><a href="diaper-track.php">Add another entry</a></p>';
	echo '</div>';
	include('caroline-counts.php');
	echo '</body></html>';
	exit();
}

?>

<div>
	<form method="get" action="diaper-track.php">
		<p>
			<input type="datetime-local" name="time" id="time" value="<?php echo date('Y-m-d\TH:i'); ?>" class="time" />
		</p>
		<p>
			<input type="submit" name="entry" value="poop" class="poop" /><br />
			<input type="submit" name="entry" value="pee" class="pee" /><br />
			<input type="submit" name="entry" value="poop-n-pee" class="p2" /><br />
			<input type="submit" name="entry" value="feed" class="feed" /><br />
		</p>
	</form>
	<p><a href="diaper-log-editor.php">Edit the log</a></p>
</div>

<?php include('caroline-counts.php'); ?>

<pre>
<?php
	$log_contents = array_reverse(file("diaper-log.txt"));

	$i=0;
	foreach ($log_contents as $thisline) {
		echo $thisline;
		if ($i == 0) {  		// the last line in the document never has a "\n" at the end, so add it
			echo "\n";
			$i = 1; 
		}
	}

?>
</pre>

</body>
</html>
