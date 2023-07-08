<?php
include_once 'set.php';
include_once 'connect.php';
include('head.php');
?>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
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
            <div class="text-center pb-3"> <a href="history" class="text-dark"><i class="fas fa-hand-point-right"></i>
                    Xem tình trạng nạp thẻ <i class="fas fa-hand-point-left"></i></a> </div>
            <h4>NẠP SỐ DƯ</h4>
            <?php
            if ($_login == null) {
                ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
                <script type="text/javascript"> new WOW().init(); </script>
                <form method="POST" action="#" id="myform">
                    <tbody>
                        <label>Tài Khoản: </label><br>
                        <input type="text" class="form-control form-control-alternative"
                            style="background-color: #DCDCDC; font-weight: bold; color: #696969" name="username" value="<?php echo $_username; ?>
" readonly required>

                        <label>Loại thẻ:</label>
                        <select class="form-control form-control-alternative" name="card_type" required>
                            <option value="">Chọn loại thẻ</option>
                            <?php
                            $cdurl = curl_init("https://thesieutoc.net/card_info.php");
                            curl_setopt($cdurl, CURLOPT_FAILONERROR, true);
                            curl_setopt($cdurl, CURLOPT_FOLLOWLOCATION, true);
                            curl_setopt($cdurl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($cdurl, CURLOPT_CAINFO, __DIR__ . '/api/curl-ca-bundle.crt');
                            curl_setopt($cdurl, CURLOPT_CAPATH, __DIR__ . '/api/curl-ca-bundle.crt');
                            $obj = json_decode(curl_exec($cdurl), true);
                            curl_close($cdurl);
                            $length = count($obj);
                            for ($i = 0; $i < $length; $i++) {
                                if ($obj[$i]['status'] == 1) {
                                    echo '<option value="' . $obj[$i]['name'] . '">' . $obj[$i]['name'] . ' (' . $obj[$i]['chietkhau'] . '%)</option> ';
                                }
                            }
                            ?>
                        </select>
                        <label>Mệnh giá:</label>
                        <select class="form-control form-control-alternative" name="card_amount" required>
                            <option value="">Chọn mệnh giá</option>
                            <option value="10000">10.000</option>
                            <option value="20000">20.000</option>
                            <option value="30000">30.000 </option>
                            <option value="50000">50.000</option>
                            <option value="100000">100.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">300.000</option>
                            <option value="500000">500.000</option>
                            <option value="1000000">1.000.000</option>
                        </select>
                        <label>Số seri:</label>
                        <input type="text" class="form-control form-control-alternative" name="serial" required />
                        <label>Mã thẻ:</label>
                        <input type="text" class="form-control form-control-alternative" name="pin" required /><br>
                        <button type="submit" class="btn btn-main form-control" name="submit">NẠP NGAY</button>

                    </tbody>
                </form>
                <script type="text/javascript">

                    $(document).ready(function () {
                        var lastSubmitTime = 0;
                        $("#myform").submit(function (e) {
                            var now = new Date().getTime();
                            if (now - lastSubmitTime < 5000) { // 10000 milliseconds = 10 seconds
                                swal('Thông báo', 'Vui lòng đợi ít nhất 5 giây trước khi nạp tiếp', 'error');
                                return false;
                            }
                            lastSubmitTime = now;

                            $.ajax({
                                url: "/ajax/card.php",
                                type: 'post',
                                data: $("#myform").serialize(),
                                success: function (data) {
                                    $("#status").html(data);
                                    document.getElementById("myform").reset();
                                    $("#load_hs").load(".history.php");
                                }
                            });
                        });

                    });
                </script>
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