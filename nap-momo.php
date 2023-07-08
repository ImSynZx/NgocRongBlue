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
            <?php if ($_login == null) { ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
            <h4>Cách 1: Nạp qua tin nhắn</h4>
                <div>Thông tin nạp momo:<br>
                    <br>
                    <p><strong>- Tên Tài Khoản:</strong>
                        <?php echo $_taikhoanmm; ?>
                    </p>
                    <p> <strong>- Ngân Hàng:</strong>
                        <?php echo $_momo; ?>
                    </p>
                    <p><strong>- Số Tài Khoản:</strong>
                        <?php echo $_phonemomo; ?>
                    </p>
                    <p><strong>- Nội Dung:</strong>
                        <?php echo $_username ?>
                    </p>
                    <br>
                    - Xây dựng, ủng hộ nro hoạt động.
					<br>- Momo Bao Tri Cong Nap.
                </div>

                <br>
                <a class="btn btn-sm btn-main form-control" style="border-radius:10px">Xác
                    nhận đã chuyển khoản</a>
                <br>
                <p><i>Khi chuyển tiền xong nhấn xác nhận đã chuyển khoản để xác thực
                        giao dịch
                        nhé!.</i>
                </p>
                <p><i>Khi xác thực xong làm mới trang sau 1 - 3 phút để cập nhật
                        KCoin.</i>
                </p>
                </small>
                <?php } ?>
        </div>
    </div>
</div>
<div class="container pt-5 pb-4 bg bg-main rounded-bottom text-white">
    <div class="row">
        <div class="col">
            <div class="text-center">
                <div style="font-size: 15px"> <small class="text-dark"> <?php echo $_tenmaychu;?><br>2023© <?php echo $_mienmaychu; ?></small> </div>
            </div>
        </div>
    </div>
</div>
<div id="status"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<!-- Code made in tui 127.0.0.1 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>