<?php
require_once '../models.php';
var_dump($_POST);
foreach($_POST as $k => $v) {
	if(strpos('item-', $k) == 0) {
		$id = substr($k, strlen('item-'));
		if($v == 'on')
		$ids[] = $id;
	}
	
}
$action = $_POST['action'];
switch($action) {
	case 'Delete':
		$sql = "DELETE FROM swims WHERE _id IN (" . implode(',', $ids) . ")";
		var_dump($sql);
		$q = mysql_query($sql) or die(mysql_error());
		break;
}
header('location: index.php');