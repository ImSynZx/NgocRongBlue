<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connect.php';
require '../head.php';
require '../set.php';
require '../cap-nhat-thong-tin.php';
require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateRandomCode($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

// Lưu thời gian hiện tại
$currentTimestamp = time();

// Kiểm tra xem có thông tin xác minh trong cơ sở dữ liệu hay không
$stmt = $conn->prepare("SELECT xacminh, thoigian_xacminh FROM account WHERE username = ?");
$stmt->bind_param("s", $_username);
$stmt->execute();
$stmt->bind_result($xacminh, $thoigian_xacminh);
$stmt->fetch();
$stmt->close();

if ($xacminh == 1 && $currentTimestamp > $thoigian_xacminh) {
    // Thời gian đã hết hạn, cập nhật cột xacminh và thoigian_xacminh thành 0
    $stmt = $conn->prepare("UPDATE account SET xacminh = 0, thoigian_xacminh = 0 WHERE username = ?");
    $stmt->bind_param("s", $_username);
    $stmt->execute();
    $stmt->close();

    $xacminh = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $username = $_POST['username'];
    // $gmail = $_POST['gmail'];

    // Kiểm tra xem tài khoản có liên kết với Email hay không
    // Nếu tài khoản đã liên kết với Email
    $isLinked = true; // Giả sử đã liên kết

    if ($isLinked) {
        $verificationCode = generateRandomCode(); // Hàm tạo mã xác nhận ngẫu nhiên

        if ($xacminh == 0) {
            // Cập nhật cột xác minh và thời gian hết hạn trong cơ sở dữ liệu
            $newXacminh = 1;
            $newThoigianXacminh = $currentTimestamp + 1800;
            $stmt = $conn->prepare("UPDATE account SET xacminh = ?, thoigian_xacminh = ? WHERE username = ?");
            $stmt->bind_param("iis", $newXacminh, $newThoigianXacminh, $_username);
            $stmt->execute();
            $stmt->close();
        }

        // Lấy thời gian xác minh từ cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT thoigian_xacminh FROM account WHERE username = ?");
        $stmt->bind_param("s", $_username);
        $stmt->execute();
        $stmt->bind_result($thoigian_xacminh);
        $stmt->fetch();
        $stmt->close();

        // Tính thời gian còn lại
        $expirationTimestamp = $thoigian_xacminh;
        $remainingSeconds = $expirationTimestamp - $currentTimestamp;
        $remainingMinutes = ceil($remainingSeconds / 60);

        if ($remainingMinutes <= 0) {
            // Thời gian đã hết hạn, cập nhật cột xacminh và thoigian_xacminh thành 0
            $stmt = $conn->prepare("UPDATE account SET xacminh = 0, thoigian_xacminh = 0 WHERE username = ?");
            $stmt->bind_param("s", $_username);
            $stmt->execute();
            $stmt->close();

            echo "expired";
        } else {
            // Tạo nội dung email với số phút còn lại
            $emailContent = "Xin chào bạn,\n\nTài khoản " . $_username . " đang thực hiện xóa liên kết với Email này.\n
            Để xác nhận và hoàn tất xóa liên kết Email, bạn vui lòng truy cập vào đường dẫn sau:\n
            " . $_domain . "/gmail/verify-gmail?" . $verificationCode . "\n
            Đường dẫn sẽ hết hạn sau: " . $remainingMinutes . " phút.\n
            Admin chân thành cảm ơn bạn đã tin tưởng và đồng hành cùng " . $_tenmaychu . "!\n
            " . $_tenmaychu . "";

            // Gửi email với nội dung đã tạo
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
                $mail->addAddress($primaryGmail);
                $mail->Subject = '=?UTF-8?B?' . base64_encode('Xác nhận xóa liên kết Email - Ngọc Rồng DragonKing') . '?=';
                $mail->Body = $emailContent;
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                // Gửi thư
                if ($mail->send()) {
                    echo "Gửi gmail thành công";
                } else {
                    echo "Gửi gmail thất bại";
                }
            } catch (Exception $e) {
                echo "error";
            }
        }
    } else {
        echo "unlinked";
    }
}
?>
