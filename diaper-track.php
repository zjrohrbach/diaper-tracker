<html>
<head>
	<title>Caroline's Feeding & Diaper Tracker</title>
	<link rel="stylesheet" href="caroline.css" />
	<meta http-equiv="refresh" content="60; url=diaper-track.php">
</head>
<body>
<?php

if (isset($_GET['time'])) {
	$entry_insert="\n".$_GET['time'].':  '.$_GET['entry'];
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
			<input type="text" name="time" value="<?php echo date('m/d h:i a'); ?>" class="time" />
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
