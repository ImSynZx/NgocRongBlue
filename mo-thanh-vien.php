<?php
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
            <h4 class="text-center">MỞ THÀNH VIÊN</h4>
            <?php
            if ($_login = null) {
                ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
                <?php
            } else {
                $mysqli = new mysqli("localhost", "root", "", "nro");

                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                    exit();
                }
                // Check if account is already activated
                if ($_status == '1') {
                    $_alert = '<div class="text-danger pb-2 font-weight-bold">Tài khoản của bạn đã được kích hoạt!</div>';
                }
                // Check if account is not activated and balance is insufficient
                elseif (($_status == '0' || $_status == '-1') && $_coin < 20000) {
                    $_alert = '<div class="text-danger pb-2 font-weight-bold">Bạn không đủ 20.000 KCoin. Vui lòng nạp thêm tiền vào tài khoản để ' . ($_status == '0' ? 'kích hoạt nhé!' : 'mở lại tài khoản!</div>');
                }
                // Activate or unlock account
                elseif (($_status == '0' || $_status == '-1') && $_coin >= 20000) {
                    $coin = $_coin - 20000;
                    $stmt = $mysqli->prepare('UPDATE account SET active = 1, vnd = ? WHERE username = ?');
                    $stmt->bind_param('is', $coin, $_username);
                    if ($stmt->execute() && $stmt->affected_rows > 0) {
                        $_alert = '<div class="text-danger pb-2 font-weight-bold">Kích hoạt tài khoản thành công. Bây giờ bạn đã có thể đăng nhập vào game!</div>';
                        if ($_status == '-1') {
                            $_alert = '<div class="text-danger pb-2 font-weight-bold">Mở khóa tài khoản thành công. Bây giờ bạn đã có thể đăng nhập vào game!</div>';
                        }
                    } else {
                        $_alert = '<div class="text-danger pb-2 font-weight-bold">Có lỗi gì đó xảy ra. Vui lòng liên hệ Admin!</div>';
                    }
                }
                ?>
                <form id="form" method="POST">
                    <div> Thông tin mở thành viên:<br>- Mở thành viên với chỉ <strong>20.000 VNĐ</strong>. <img
                            src="image/hot.gif"><br>- Được miễn phí <strong>GiftCode Thành viên</strong>. <img
                            src="image/hot.gif"><br>- Tận hưởng trọn vẹn các tính năng. <img src="image/hot.gif"><br>-
                        Xây dựng, ủng hộ nro hoạt động. </div>
                    <div id="notify" class="text-danger pb-2 font-weight-bold"></div>
                    <?php if (isset($_POST['submit']))
                        echo $_alert; ?>
                    <button class="btn btn-main form-control" id="btn" type="submit" name="submit">MỞ NGAY</button>
                </form>
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