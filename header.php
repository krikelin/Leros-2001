<?php
require_once 'models.php';
if(!user_is_logged_in()) {
	header('location: login.php');
}
?>
<html>
	<head>
		<title>Leros</title>
	</head>
	<body>
		<table border="">
			<tr>
				<td><a href="/">Home</a></td>
				<td><a href="/swims">Swimming Laps</a></td>
			</tr>
		</table>