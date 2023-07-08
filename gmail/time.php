<?php
include_once '../set.php';
include_once '../connect.php';
// Chuẩn bị truy vấn SQL
$stmt = $conn->prepare("SELECT xacminh, thoigian_xacminh FROM account WHERE username = ?");
$stmt->bind_param("s", $_username);
$stmt->execute();
$stmt->bind_result($xacminh, $thoigian_xacminh);
$stmt->fetch();
$stmt->close();

// Kiểm tra cột xacminh và tính toán thời gian còn lại
if ($xacminh == 1) {
    $currentTimestamp = time();
    $remainingSeconds = $thoigian_xacminh - $currentTimestamp;
    $remainingMinutes = ceil($remainingSeconds / 60);

    // Kiểm tra nếu đã hết thời gian 30 phút
    if ($remainingMinutes <= 0) {
        // Sửa giá trị của cột xacminh và thoigian_xacminh sang 0
        $updateStmt = $conn->prepare("UPDATE account SET xacminh = 0, thoigian_xacminh = 0 WHERE username = ?");
        $updateStmt->bind_param("s", $_username);
        $updateStmt->execute();
        $updateStmt->close();

        echo "Thời gian xác minh đã hết";
    } else {
        echo "<p class='mb-1 mt-2'>Thư xác nhận xóa liên kêt Gmail đã được gửi tới địa chỉ Gmail liên kết<br>
        Vui lòng kiểm tra <span class='font-weight-bold font-italic'>Hộp thư đến</span> bao gồm cả <span class='font-weight-bold font-italic'>Thư rác</span> và làm theo yêu cầu để hoàn tất xóa liên kết Gmail
      </p>Thời gian còn lại: <strong>$remainingMinutes phút</strong><br><br>";
    }
} else {
    echo "";
}
?>