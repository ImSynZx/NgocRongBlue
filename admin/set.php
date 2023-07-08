<?php
include_once '../cauhinh.php';
include_once '../config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra và khởi động phiên làm việc nếu chưa được khởi động
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


$_login = isset($_login) ? $_login : null;
$_user = isset($_SESSION['account']) ? $_SESSION['account'] : null;

if ($_user !== null) {
	$_login = "on";
	$user_arr = _fetch("SELECT * FROM account WHERE username='$_user'");

	if (is_array($user_arr) && count($user_arr) <= 0) {
		header("Location: ../logout.php");
		exit();
	} else {
		$_username = htmlspecialchars($user_arr['username']);
		$_password = htmlspecialchars($user_arr['password']);
		$_gmail = htmlspecialchars($user_arr['gmail']);
		$_gioithieu = htmlspecialchars($user_arr['gioithieu']);
		$_admin = htmlspecialchars($user_arr['admin']);
		$_coin = $user_arr['vnd'];
		$_tcoin = htmlspecialchars($user_arr['tongnap']);
		$_status = $user_arr['active'];

		switch ($_status) {
			case '1':
				$isPremium_name = '<span style="color:green;font-weight: bold;">Đã kích hoạt</span>';
				break;
			case '0':
				$isPremium_name = '<span style="color:#007BFF;font-weight: bold;"><a href="/active">Kích hoạt ngay</a></span>';
				break;
			case '-1':
				$isPremium_name = '<span style="color:red;font-weight: bold;">Đang bị khóa</span>';
				break;
		}
		if ($_admin != 1) {
			echo '<script>alert("Bạn không phải là admin!"); window.location.href="../index"</script>';
			exit;
		}
	}
} else {
	$_login = null;
}

if (isset($_GET['out'])) {
	session_destroy();
	header("Location:/");
	exit();
}
?>