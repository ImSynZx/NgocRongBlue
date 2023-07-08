<?php
include_once 'set.php';
include_once 'connect.php';
include_once '../head.php';


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Chủ Chính Thức - DragonKing</title>
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
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/notify/notify.js"></script>
    <link rel="icon" href="../image/icon.png?v=99">
    <link href="../assets/main.css" rel="stylesheet">
</head>

<body>
    <div class="container color-main2 pb-3">
        <div class="row">
            <div class="container color-main pt-2">
                <div class="row">
                    <div class="col"> <a href="index" style="color: white">Quay lại admin panel</a> </div>
                </div>
            </div>
        </div>
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <br>
                    <br>
                    <h6> THÔNG TIN VỀ GIÁ TRỊ NẠP</h6>
                    1. Thông tin chung
                    <br>
                    - Giá trị thực nhận: x1
                    <br>
                    - Có thể thay đổi giá trị
                    <br>
                    - Chỉ áp dụng cho thẻ cào
                    <br>
                    2. Sửa đổi
                    <br>
                    - Giá trị nạp sẽ được áp dụng trực tiếp vào CallBack
                    <br>
                    - Vẫn có thể thay đổi giá trị
                    <br>
                    <br>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Lấy giá trị nhập từ form
                        $giatri = $_POST['giatri'];

                        // Kiểm tra giá trị nạp
                        if ($giatri >= 1) {
                            // Cập nhật giá trị vào cột "giatri" trong bảng "trans_log"
                            $sql = "UPDATE trans_log SET giatri = '$giatri'";
                            if ($conn->query($sql) === TRUE) {
                                echo "Sửa giá nạp thành công!";
                            } else {
                                echo "Lỗi khi cập nhật giá trị: " . $conn->error;
                            }
                        } else {
                            echo "Giá trị nạp không hợp lệ!";
                        }
                    }

                    // Đóng kết nối đến cơ sở dữ liệu
                    $conn->close();
                    ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="font-weight-bold">Giá trị nạp thẻ:</label>
                            <input type="number" class="form-control" name="giatri" id="giatri"
                                placeholder="Giá trị cần thay đổi nạp (số từ 1 trở đi)" required min="1">
                        </div>
                        <button class="btn btn-main form-control" type="submit">Thực hiện</button>
                    </form>
                    <div id="notification"></div>
                </div>
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
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>