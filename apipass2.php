<?php
include_once 'config.php';
include_once 'cauhinh.php';
function has_mkc2($username)
{
    // Kết nối tới cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "", "nro");

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Thực hiện truy vấn để lấy giá trị của cột "mkc2" từ bảng "account"
    $sql = "SELECT mkc2 FROM account WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra và trả về kết quả là true/nếu giá trị khác rỗng và false/ngược lại
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['mkc2'] != '') {
                return true;
            }
        }
    }

    // Ngắt kết nối
    mysqli_close($conn);

    // Trả về giá trị mặc định là false
    return false;
}
?>