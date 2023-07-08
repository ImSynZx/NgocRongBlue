<?php
require_once 'connect.php';
require_once 'set.php';

$_alert = '';
$recafcode = '';

if (isset($_GET['ref']) && !empty($_GET['ref'])) {
    $recafcode = $_GET['ref'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM account WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_alert = "<div class='text-danger pb-2 font-weight-bold'>Tài khoản đã tồn tại.</div>";
    } else {
        $recaf = isset($_POST["recaf"]) && !empty($_POST["recaf"]) ? mysqli_real_escape_string($conn, trim($_POST['recaf'])) : null;
        if (!empty($recaf)) {
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM account WHERE id=? AND ip_address=?");
            $stmt->bind_param("ss", $recaf, $ip_address);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                $_alert = '<div class="text-danger pb-2 font-weight-bold">Không thể nhập mã giới thiệu của bản thân đâu nhé!</div>';
            } else {
                $stmt = $conn->prepare("SELECT gioithieu, gioihan FROM account WHERE id = ?");
                $stmt->bind_param("s", $recaf);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $gioithieu = $row['gioithieu'];
                $gioihan = $row['gioihan'];

                if ($gioithieu < 3) {
                    if ($gioihan < 3) {
                        $stmt = $conn->prepare("UPDATE account SET gioithieu = gioithieu + 1, gioihan = gioihan + 1 WHERE id = ?");
                        $stmt->bind_param("s", $recaf);
                        if ($stmt->execute()) {
                            $stmt = $conn->prepare("INSERT INTO account (username, password, recaf) VALUES (?, ?, ?)");
                            $stmt->bind_param("sss", $username, $password, $recaf);
                            if ($stmt->execute()) {
                                $_alert = '<div class="text-danger pb-2 font-weight-bold">Đăng kí thành công!!</div>';
                            } else {
                                $_alert = '<div class="text-danger pb-2 font-weight-bold">Đăng ký thất bại.</div>';
                            }
                        } else {
                            $_alert = '<div class="text-danger pb-2 font-weight-bold">Có lỗi khi cập nhật số lần nhập mã!</div>';
                        }
                    } else {
                        $_alert = '<div class="text-danger pb-2 font-weight-bold">Mã giới thiệu này đã đạt đủ số người nhập mã!</div>';
                    }
                } else {
                    $_alert = '<div class="text-danger pb-2 font-weight-bold">Mã giới thiệu này đã đạt giới hạn người dùng!</div>';
                }
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO account (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                $_alert = '<div class="text-danger pb-2 font-weight-bold">Đăng kí thành công!!</div>';
            } else {
                $_alert = '<div class="text-danger pb-2 font-weight-bold">Đăng ký thất bại.</div>';
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DragonKing - Máy Chủ Ngọc Rồng Online</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="">
    <meta name="description"
        content="Website chính thức của DragonKing - Máy Chủ Ngọc Rồng Online Online – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!">
    <meta name="keywords"
        content="DragonKing - Máy Chủ Ngọc Rồng Online Online,ngoc rong mobile, game ngoc rong, game 7 vien ngoc rong, game bay vien ngoc rong">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title"
        content="Website chính thức của DragonKing - Máy Chủ Ngọc Rồng Online Online – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!">
    <meta name="twitter:description"
        content="Website chính thức của DragonKing - Máy Chủ Ngọc Rồng Online Online – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!">
    <meta name="twitter:image" content="../image/logo.png">
    <meta name="twitter:image:width" content="200">
    <meta name="twitter:image:height" content="200">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="./assets/jquery/jquery.min.js"></script>
    <script src="./assets/notify/notify.js"></script>
    <link href="./assets/main.css" rel="stylesheet">
    <script>
        var login = false
    </script>
</head>

<body class="">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text-center"> <img height="12" src="/image/12.png" style="vertical-align: middle;"> <small
                        style="font-size: 10px" id="hour3">Dành cho người chơi trên 12 tuổi. Chơi quá 180 phút mỗi ngày
                        sẽ hại sức khỏe.</small> </div>
            </div>
        </div>
        <div class="row bg bg-main pb-3 pt-2 rounded-top">
            <div class="col">
                <div class="text-center mb-2"> <a href="/"><img class="rounded" src="image/logo.png" id="logo"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-4 pb-1 color-main2">
        <div class="row mb-3"> </div>
    </div>
    <div class="container color-main2 pb-3">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 pr-5 pl-5" id="div-register">
                <h4 class="text-center">ĐĂNG KÝ</h4>
                <form id="form" method="POST">
                    <div class="form-group">
                        <label>Tài khoản:</label>
                        <input class="form-control" type="text" name="username" id="username"
                            placeholder="Nhập tài khoản">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu:</label>
                        <input class="form-control" type="password" name="password" id="password"
                            placeholder="Nhập mật khẩu">
                    </div>
                    <?php if (!empty($recafcode)) { ?>
                        <div class="form-group">
                            <label for="referral_code">Mã giới thiệu:</label>
                            <input type="text" class="form-control" id="recaf" name="recaf"
                                value="<?php echo $recafcode; ?>" placeholder="Nhập mã giới thiệu (nếu có)">
                        </div>
                    <?php } ?>
                    <div class="form-check form-group">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="accept" id="accept" checked="">
                            Đồng ý <a href="dieu-khoan" target="_blank">Điều khoản sử dụng</a>
                        </label>
                    </div>

                    <?php if (!empty($_alert)) {
                        echo $_alert;
                    } ?>
                    <div id="notify" class="text-danger pb-2 font-weight-bold"></div>
                    <button class="btn btn-main form-control" type="submit" onclick="redirectToRegisterPage()">ĐĂNG
                        KÝ</button>
                </form>
                <br>
                <script>
                    function redirectToRegisterPage() {
                        <?php if (isset($_SESSION['id'])) { ?>
                            var url = "<?php echo $_domain ?>/dang-ky.php?ref=<?php echo $_SESSION['id'] ?>";
                            window.location.href = url;
                        <?php } ?>
                    }
                </script>
            </div>
        </div>
        <div class="text-center">
            <p>Bạn đã có tài khoản <a href="/dang-nhap">Đăng nhập tại đây</a></p>
            <p><a href="/forgot-password">Quên mật khẩu?</a></p>
        </div>
    </div>
    <div class="container pt-5 pb-4 bg bg-main rounded-bottom text-white">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <div style="font-size: 15px"> <small class="text-dark">
                            <?php echo $_tenmaychu; ?><br>2023©
                            <?php echo $_mienmaychu; ?>
                        </small> </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>