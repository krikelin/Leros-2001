 <?php
function db_conn() {
	$conn = mysql_connect("localhost", "root", "");
	$db = mysql_select_db("leros");
}