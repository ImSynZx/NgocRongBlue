<?php
include 'connect.php';
include 'set.php';

// Lấy giá trị mật khẩu cấp 2 được gửi từ client
$deletePasswordcap2 = $_POST['passwordcap2'] ?? '';

// Kiểm tra mật khẩu cấp 2 nhập vào có khớp với giá trị trong cơ sở dữ liệu hay không
$sql = "SELECT * FROM account WHERE mkc2 = '$deletePasswordcap2'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mật khẩu cấp 2 khớp, thực hiện xóa mật khẩu cấp 2 và cập nhật vào cơ sở dữ liệu
    $sqlUpdate = "UPDATE account SET mkc2 = NULL WHERE mkc2 = '$deletePasswordcap2'";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Xóa mật khẩu cấp 2 thành công
        echo "Xóa mật khẩu cấp 2 thành công";
    } else {
        // Xảy ra lỗi khi cập nhật vào cơ sở dữ liệu
        echo "Lỗi: ";
    }
} else {
    // Mật khẩu cấp 2 không khớp
    echo "Mật khẩu cấp 2 không chính xác";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
