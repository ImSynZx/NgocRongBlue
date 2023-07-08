<?php
include_once 'set.php';
$_title = "Ngọc Rồng Light - Đăng Nhập";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DragonKing - Máy Chủ Ngọc Rồng Online</title>
    <meta name="description" content="">
    <meta name="author" content="">
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
                <h4 class="text-center">QUÊN MẬT KHẨU</h4>
                <?php
                require 'cauhinh.php';
                require 'vendor/autoload.php';
                require 'vendor/phpmailer/phpmailer/src/Exception.php';
                require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
                require 'vendor/phpmailer/phpmailer/src/SMTP.php';
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;

                function generateRandomPassword($length = 6)
                {
                    $characters = '0123456789';
                    $password = '';

                    for ($i = 0; $i < $length; $i++) {
                        $password .= $characters[rand(0, strlen($characters) - 1)];
                    }

                    return $password;
                }

                if ($_login == null) {

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $username = $_POST['username'];
                        $gmail = $_POST['gmail'];

                        // Thực hiện kết nối tới cơ sở dữ liệu MySQL
                        $conn = new mysqli("localhost", "root", "", "nro");
                        if ($conn->connect_error) {
                            die("Kết nối thất bại: " . $conn->connect_error);
                        }

                        // Tạo một mật khẩu mới ngẫu nhiên
                        $newPassword = generateRandomPassword();

                        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                        $updateQuery = "UPDATE account SET password = '$newPassword' WHERE username = '$username' AND gmail = '$gmail'";
                        if ($conn->query($updateQuery) === TRUE) {
                            // Tạo một đối tượng PHPMailer và cấu hình
                            $mail = new PHPMailer(true);
                            try {
                                // Cấu hình gửi email thông qua Gmail
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = true;
                                $mail->Username = 'ngocrongdragonking@gmail.com'; // Thay đổi thành email của bạn
                                $mail->Password = 'vscwwaluzuvwztwr'; // Thay đổi thành mật khẩu của bạn
                                $mail->SMTPSecure = 'tls';
                                $mail->Port = 587;

                                // Thiết lập thông tin email
                                $mail->setFrom('ngocrongdragonking@gmail.com', 'Ngọc Rồng DragonKing'); // Thay đổi thành email của bạn và tên của bạn
                                $mail->addAddress($gmail);
                                $mail->Subject = '=?UTF-8?B?' . base64_encode('Quên Mật Khẩu - Ngọc Rồng DragonKing') . '?=';
                                $mail->Body = "Xin chào bạn,\n\nTài khoản $username đang thực hiện Quên mật khẩu.\n\nThông tin tài khoản của bạn:\n- Tài khoản: $username \n- Mật khẩu mới: $newPassword \n\nAdmin chân thành cảm ơn bạn đã tin tưởng và đồng hành cùng $_tenmaychu!\n\n$_tenmaychu";
                                $mail->CharSet = 'UTF-8';
                                $mail->Encoding = 'base64';

                                // Gửi thư
                                $mail->send();
                                echo "Email đã được gửi thành công đến địa chỉ: " . $gmail;
                            } catch (Exception $e) {
                                echo "Có lỗi xảy ra khi gửi email: " . $mail->ErrorInfo;
                            }
                        } else {
                            echo "Không tìm thấy thông tin trong cơ sở dữ liệu hoặc không thể cập nhật mật khẩu mới.";
                        }

                        // Đóng kết nối cơ sở dữ liệu
                        $conn->close();
                    }
                    ?>
                    <form id="form" method="POST">
                        <div class="form-group">
                            <label>Tài khoản:</label>
                            <input class="form-control" type="text" name="username" id="username"
                                placeholder="Nhập tên tài khoản">
                        </div>
                        <div class="form-group">
                            <label>Gmail:</label>
                            <input class="form-control" type="gmail" name="gmail" id="gmail"
                                placeholder="Nhập Gmail của bạn">
                        </div>
                        <div id="notify" class="text-danger pb-2 font-weight-bold"></div>
                        <button class="btn btn-main form-control" type="submit">XÁC NHẬN</button>
                    </form>
                    <br>
                    <div class="text-center">
                        <p>Bạn đã lấy lại tài khoản? <a href="/dang-nhap">Đăng nhập tại đây</a></p>
                    </div>
                <?php } else { ?>
                    <p>Bạn đang đăng nhập? Hãy thoát đăng nhập để dùng được chức năng này</p>
                <?php } ?>
            </div>
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