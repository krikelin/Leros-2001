<?php
require_once 'header.php';
$swimCollection = new Collection("Swim");
$laps = $swimCollection->query("*", array('user_id' => $_COOKIE['user_id']));
?>
<table>
	<thead>
		<th>Lap</th>
		<th>Distance</th>
		<th>Time</th>
	</thead>
	<tbody>
		<?php foreach($laps as $lap):?>
		<tr>
			<td><a href="lap.php?id=<?php echo $lap->_id?>"><?php echo $lap->time?></a></td>
			<td><?php echo $lap->metres?></td>
			<td><?php echo $lap->duration?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>