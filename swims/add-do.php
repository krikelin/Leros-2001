<?php
require_once '../models.php';
if(!is_numeric($_POST['minutes']))
	die("Minutes must be an integer");

if(!is_numeric($_POST['seconds'])) {
	die("Seconds must be a valid number");
}
if(!is_numeric($_POST['distance'])) 
	die("Distance must be a valid number");

$time = date('Y-m-d H:i:s');
if(isset($_POST['time'])) {
	$time = $_POST['time'];
}

$duration = ((((int)$_POST['minutes']) * 60) + ((int)$_POST['seconds']));

$distance = $_POST['distance'];

if(!user_is_logged_in()) {
	die("A");
}

$swim = new Swim();
$swim->metres = $distance;
$swim->time = date('Y-m-d H:i:s', strtotime($time));
$swim->duration = $duration;
$swim->user = current_user();
$swim->save();
header('location: index.php');