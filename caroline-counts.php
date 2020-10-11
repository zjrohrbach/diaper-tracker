<?php 

$diaper_log = file("diaper-log.txt");
$counts = array();

function check($entry,$str) {
	if(strpos($entry,$str) !== false) {
		return 1;
	} else {
		return 0;
	}
}
foreach($diaper_log as $entry) {
	$thisdate = substr($entry, 0, 5);

	if(!isset($counts[$thisdate]['poop'])) {
		$counts[$thisdate]['poop'] = 0;
		$counts[$thisdate]['pee'] = 0;
		$counts[$thisdate]['feed'] = 0;
	}
	$things_to_count = array('poop','pee','feed');
	
	foreach ($things_to_count as $item) {
		$counts[$thisdate][$item] = $counts[$thisdate][$item] + check($entry,$item);
	}
}

?>

<table>
	<tr class="firstrow">
		<td>Date</td>
		<td># poops</td>
		<td># pees</td>
		<td># feedings</td>
	</tr>

<?php

	$class = "odd";

	foreach ($counts as $day => $c_array) {
		echo '<tr class="'.$class.'"><td class="firstcol">'.$day.'</td><td>'.$c_array['poop'].'</td><td>'.$c_array['pee'].'</td><td>'.$c_array['feed'].'</td></tr>'."\n";
		if ($class == "odd") { 
			$class = "even";
		} else {
			$class = "odd";
		}
	}

?>

</table>
