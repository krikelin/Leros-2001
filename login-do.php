<?php
require_once 'models.php';
$username = $_POST['username'];
$password = $_POST['password'];
$user = get_user($username);
var_dump($user);
if($user != NULL && $user->login($password)) {
	header("location: index.php");
} else {
	header("location: login.php?error=e");
}

