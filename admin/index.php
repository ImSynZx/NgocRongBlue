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
                    <div class="col"> <a href="../index" style="color: white">Quay lại diễn đàn</a> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container color-main2 pb-2">
        <div class="row pb-2 pt-2">
            <div class="col-lg-6">
                <br>
                <br>
                <a class="btn btn-main btn-sm" href="vatpham">VẬT PHẨM</a>
                <a class="btn btn-main btn-sm" href="chiso">CHỈ SỐ</a>
                <a class="btn btn-main btn-sm" href="giatri">GT NẠP THẺ</a>
                <a class="btn btn-main btn-sm" href="congvnd">CỘNG VNĐ</a>
                <a class="btn btn-main btn-sm" href="activetv">MỞ THÀNH VIÊN</a>
                <br>
                <br>
                <a class="btn btn-main btn-sm" href="vipham">BAN-UNBAN</a>
                <div id="notification"></div>
            </div>

            <div class="col-lg-6 htop ">
                <br>
                <br>
                <h6> THÔNG TIN VỀ ADMIN PANEL</h6>
                1. Thông tin chính
                <br>
                - Gồm các Menu dành cho Admin Máy Chủ <?php echo $_tenmaychu; ?>
                <br>
                - Thực hiện thao tác dễ dàng hơn
                <br>
                - Chỉnh sửa, tạo sự kiện, thực hiện đơn giản hóa
                <br>
                - Có thể thao thác xử lý dễ dàng
                <br>
                2. Quyền Hạn Admin
                <br>
                - Toàn bộ chức năng của máy chủ có thể thao tác qua ADMIN PANEL
                <br>
                - Cần có Quyền hạn Admin để truy cập vào ADMIN PANEL
                <br>
                <br>
                <br>
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