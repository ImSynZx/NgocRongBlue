<?php
$apikey = 'DD3F10665151EF744B8BDC55F0CD7179'; //API key, lấy từ website thesieutoc.net thay vào trong cặp dấu ''
// database Mysql config
$local_db = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "nro";
# đừng đụng vào 
$conn = new mysqli($local_db, $user_db, $pass_db, $name_db);
$conn->set_charset("utf8");

define("CARD_LOG_FILE", "card.log");

// Kiểm tra và tạo file card.log nếu nó chưa tồn tại
if (!file_exists(CARD_LOG_FILE)) {
    $fileHandle = fopen(CARD_LOG_FILE, 'w') or die("Không thể tạo file.");
    fclose($fileHandle);
}

$validate = validateCallback($_POST);

if ($validate !== false) {
    $status = $validate['status'];
    $serial = $validate['serial'];
    $pin = $validate['pin'];
    $card_type = $validate['card_type'];
    $amount = $validate['amount'];
    $content = $validate['content'];

    $stmt = $conn->prepare("SELECT * FROM trans_log WHERE status = 0 AND trans_id = ? AND pin = ? AND seri = ? AND type = ?");
    $stmt->bind_param("ssss", $content, $pin, $serial, $card_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $log = $result->fetch_assoc();
        $logID = $log['id'];
        $giatri = $row['giatri'];

        if ($status === 'thanhcong') {
            // Xử lý nạp thẻ thành công
            $price = $amount * $giatri;
            $stmt = $conn->prepare("UPDATE account SET tongnap = tongnap + ?, vnd = vnd + ? WHERE username = ?");
            $stmt->bind_param("iis", $price, $price, $log['name']);
            $stmt->execute();
            updateStatus($conn, $logID, 1);
        } elseif ($status === 'saimenhgia') {
            // Xử lý nạp thẻ sai mệnh giá
            $stmt = $conn->prepare("UPDATE trans_log SET status = 3, amount = ? WHERE id = ?");
            $stmt->bind_param("ii", $amount, $logID);
            $stmt->execute();
            updateStatus($conn, $logID, 3);
        } else {
            // Xử lý nạp thẻ thất bại
            updateStatus($conn, $logID, 2);
        }

        // Lưu log Nạp Thẻ
        $logData = "Tai khoan: " . $log['name'] . ", data: " . json_encode($_POST) . "\r\n";
        file_put_contents(CARD_LOG_FILE, $logData, FILE_APPEND);
    }
}

function validateCallback($out)
{
    $requiredFields = ['status', 'serial', 'pin', 'card_type', 'amount', 'content'];

    foreach ($requiredFields as $field) {
        if (!isset($out[$field])) {
            return false;
        }
    }

    return $out;
}

function updateStatus($conn, $id, $status)
{
    $stmt = $conn->prepare("UPDATE trans_log SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);
    $stmt->execute();
}
?>