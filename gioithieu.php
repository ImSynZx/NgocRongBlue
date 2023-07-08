<?php
include_once 'set.php';
include_once 'connect.php';
include('head.php');

?>
<div class="container color-main2 pb-3">
    <div class="row">
        <div class="container color-main pt-2">
            <div class="row">
                <div class="col"> <a href="index" style="color: white">Quay lại diễn đàn</a> </div>
            </div>
        </div>
        <div class="col-lg-6 offset-lg-3 pr-5 pl-5">
            <br>
            <br>
            <h4>GIỚI THIỆU NGƯỜI CHƠI MỚI</h4><br>
            <?php if ($_login == null) { ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
                <b class="text-danger">Cư dân đã giới thiệu được :
                </b>
                <b>
                    <?php echo $_gioithieu; ?> Người
                </b>
                <br><br>
                <b> Link Giới Thiệu:</b>
                <b>
                    <style>
                        .small-text {
                            font-size: 14px;
                            color: gray;
                        }

                        #notification {
                            font-size: 12px;
                        }

                        a {
                            text-decoration: none;
                        }

                        a:hover {
                            text-decoration: none;
                        }
                    </style>
                </b>
                <a href="<?php echo $_domain ?>/dang-ky.php?ref=<?php echo $_SESSION['id'] ?>" onclick="copyLink(event)">
                    <span style="color: black;">
                        <?php echo $_domain ?>/dang-ky.php?ref=
                        <?php echo $_SESSION['id'] ?>
                    </span>
                </a>
                <br>
                <br>
                <div id="notification"></div>
                <script>
                    function copyLink(event) {
                        event.preventDefault(); // Ngăn chặn chuyển hướng khi nhấp vào liên kết

                        var link = event.target.href; // Lấy đường dẫn từ liên kết
                        navigator.clipboard.writeText(link) // Sao chép đường dẫn vào clipboard
                            .then(function () {
                                // Sao chép thành công
                                document.getElementById("notification").innerText = "Bạn đã sao chép liên kết giới thiệu thành công!";
                            })
                            .catch(function (error) {
                                // Sao chép thất bại
                                console.error(error);
                                document.getElementById("notification").innerText = "Có lỗi xảy ra khi sao chép liên kết giới thiệu.";
                            });
                    }
                </script>
                </b>
                <br>
                <br>
                <?php if ($_gioithieu > 0) { ?>
                    <span class="text-danger"><strong>
                            Số Điểm Giới Thiệu Là
                            <?php echo $_gioithieu; ?> Người Bạn Nhận Được :
                        </strong></span><br>
                    #<b><span>
                            <?php echo ($_gioithieu == 1) ? '5,000 VNĐ' :
                                (($_gioithieu == 2) ? '10,000 VNĐ' :
                                    '15,000 VNĐ'); ?>
                        </span></b><br>
                    <?php
                }
                ?>
                <br>
                <br>
                <b class="text text-danger">Phổ Biến Luật Sự Kiện: </b><br>
                <b>- Đây là Link riêng của mỗi cư dân Light
                    <br>
                    - Người chơi phải đăng ký thành công mới được tính điểm
                    <br>
                    - Chỉ tính điểm với người chơi mới, tối đa là 3 người chơi mới
                    <br>
                    <br>
                    <span style="color:red"><strong>Quan Trọng : <span style="color:212529">
                        </strong></span>
                    </span>
                    <br>
                    <b>- Các cư dân lưu ý không <span style="color:red">spam</span> để tránh làm phiền người chơi
                        khác
                        <br>
                        - Mỗi tài khoản chỉ đạt được <span style="color:red">3 Điểm</span> thôi và phần quà sẽ gửi
                        vào <span style="color:red">hành trang</span> của cư dân khi
                        đạt đủ số điểm tích luỹ
                        <br>
                        - Khi cư dân đạt đủ <span style="color:red">1-3 Điểm</span> tích luỹ thì sẽ hiển thị nút <span
                            style="color:red">Đổi Quà</span>
                        <br>
                        <br>
                        <?php
                        // Các giá trị mốc quà và điểm tương ứng
                        $moc_qua = [
                            1 => [
                                'diem' => 1,
                                'gia_tri' => 50000
                            ],
                            2 => [
                                'diem' => 2,
                                'gia_tri' => 10000
                            ],
                            3 => [
                                'diem' => 3,
                                'gia_tri' => 15000
                            ]
                        ];

                        // Kiểm tra xem người chơi có điểm tích luỹ hay không
                        if ($_gioithieu > 0) {
                            // Kiểm tra xem điểm tích luỹ nằm trong mốc quà nào
                            if (array_key_exists($_gioithieu, $moc_qua)) {
                                $moc = $moc_qua[$_gioithieu];
                                $diem_moc = $moc['diem'];
                                $gia_tri_moc = $moc['gia_tri'];

                                // Kiểm tra xem người chơi đã nhấn nút "Đổi Quà" hay chưa
                                if (isset($_POST['doi_qua'])) {
                                    // Thêm giá trị của mốc quà vào cột "vnd"
                                    $_coin += $gia_tri_moc;

                                    // Thực hiện trừ điểm tích luỹ tương ứng với mốc đó
                                    $_gioithieu -= $diem_moc;

                                    // Cập nhật cơ sở dữ liệu với giá trị mới của cột "vnd" và "gioithieu"
                                    $sql = "UPDATE account SET vnd = $_coin, gioithieu = $_gioithieu WHERE id = $_SESSION[id]";
                                    if (mysqli_query($conn, $sql)) {
                                        echo "Đổi quà thành công!";
                                    } else {
                                        echo "Lỗi cập nhật cơ sở dữ liệu: " . mysqli_error($conn);
                                    }
                                }
                            }
                        }
                        ?>


                        <!-- Hiển thị nút "Đổi Quà" nếu người chơi có điểm tích luỹ -->
                        <?php if ($_gioithieu > 0): ?>
                            <form method="POST">
                                <input class="btn btn-sm btn-main form-control" type="submit" name="doi_qua" value="Đổi Quà">
                            </form>
                        <?php endif;
            } ?>
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