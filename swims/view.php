<?php require_once '../header.php';
$lap = new Swim($_GET['id']);
$lap->create($_GET['id']);

?>
<form method="POST" action="view-do.php">
	<input type="hidden" name="_id" value="<?php echo $lap->_id?>" />
	<label for="distance">Distance</label><br />
	<input type="text" value="<?php echo $lap->metres?>" name="distance" /><br />
	<label for="duration">Duration</label><br />
	<input type="text" name="minutes" value="<?php echo round($lap->duration / 60)?>" />min : <input type="text" value="<?php echo ($lap->duration % 60)?>" name="seconds" />s<br />
	<label for="time" name="time">Time</label><br />
	<input type="text" name="time" value="<?php echo $lap->time?>" /><br />
	<button type="submit">Send</button>
</form>