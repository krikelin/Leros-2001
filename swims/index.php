 <?php
require_once '../header.php';
$swimCollection = new Collection("Swim");
$laps = $swimCollection->query("*", array('user_id' => $_COOKIE['user_id']), ' `time` DESC');
?>
<form method="POST" action="index-post.php">
<table cellpadding="4">
	<caption>
		<td colspan="5" bgcolor="#eeeeee">
			[<a href="add.php"><?php echo __('Add session')?></a>]
			With selected: 
			<button type="submit" name="action" value="delete">Delete</button>

		</td>
	</caption>
	<thead>
		<th>*</th>
		<th>Lap</th>
		<th>Distance</th>
		<th>Duration</th>
		<th>Avg. speed (m/s)</th>
	</thead>
	<tbody>
		<?php foreach($laps as $lap):?>
		<tr>
			<td><input type="checkbox" name="item-<?php echo $lap->_id?>" /></td>
			<td align="right"><a href="view.php?id=<?php echo $lap->_id?>"><?php echo $lap->time?></a></td>
			<td align="right"><?php echo $lap->metres?></td>
			<td align="right"><?php echo round($lap->duration / 60)?>:<?php echo round($lap->duration % 60)?></td>
			<td align="right"><?php echo @round($lap->metres / $lap->duration, 2)?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot bgcolor="#eeeeee">
		<td colspan="5">
			[<a href="add.php"><?php echo __('Add session')?></a>]
		</td>
	</tfoot>
</table>