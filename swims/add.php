<?php require_once '../header.php';?>
<form method="POST" action="add-do.php">
	<label for="distance">Distance</label><br />
	<input type="text" name="distance" /><br />
	<label for="duration">Duration (seconds)</label><br />
	<input type="text" name="minutes" />min : <input type="text" name="seconds" />s<br />
	<label for="time" name="time">Time</label><br />
	<input type="text" name="time" /><br />
	<button type="submit">Send</button>
</form>