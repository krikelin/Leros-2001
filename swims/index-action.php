<?php
require_once '../models.php';
foreach($_GET as $k => $v) {
	$ids = array();
	if(strpos('item-', $k) == 0) {
		$id = substr($k, strlen('item-'));
		$ids[] = $id;
	}
	
}
$action = $_POST['action'];
switch($action) {
	case 'delete':
		$sql = "DELETE FROM swims WHERE id IN (" . implode(',', $ids) . ")";
		$q = mysql_query($sql);
		break;
}
header('location: index.php');