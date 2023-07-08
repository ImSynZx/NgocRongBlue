<?php
include_once 'cauhinh.php';
$config = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$config) {
	die("KHONG THE KET NOI DEN CSDL ! VUI LONG KIEM TRA LAI");
} else {
	mysqli_set_charset($config, 'utf8');
}
function _query($sql)
{
	global $config;
	return mysqli_query($config, $sql);
}
function _fetch($sql)
{
	return mysqli_fetch_array(_query($sql));
}
function isset_sql($txt)
{
	global $config;
	return mysqli_real_escape_string($config, $txt);
}
function _insert($table, $input, $output)
{
	return "INSERT INTO $table($input) VALUES($output)";
}
function _select($select, $from, $where)
{
	return "SELECT $select FROM $from WHERE $where";
}
function _update($tabname, $input_output, $where)
{
	return "UPDATE $tabname SET $input_output WHERE $where";
}
function _delete($table, $condition)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM $table WHERE $condition");
}
function show_alert($alert)
{
	echo '<div class="' . $alert[0] . '">' . $alert[1] . '</div>';
}

function _num_rows($result)
{
	return mysqli_num_rows($result);
}

?>