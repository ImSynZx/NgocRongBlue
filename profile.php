<?php
include_once 'set.php';
include_once 'connect.php';
include('head.php');

$_active = (isset($_active)) ? $_active : null;
$_tcoin = (isset($_tcoin)) ? $_tcoin : 0;

function get_user_ip()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($addr[0]);
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
?>
<div class="container color-main2 pb-3">
    <div class="row">
        <div class="container color-main pt-2">
            <div class="row">
                <div class="col"> <a href="index" style="color: white">Quay lại diễn đàn</a> </div>
            </div>
        </div>
        <div class="container">
            <br>
            <br>
            <div class="dashboard-container">
                <div class="dashboard-content">
                    <div class="profile-page settings dashboard-panel">

                        <h3 class="heading">Thông tin tài khoản</h3>
                        <div class="row profile-summary">
                            <div class="col-sm-3 d-flex flex-column align-items-center">

                            </div>

                            <div class="col-sm-9 mt-4">
                                <div class="info-row row no-gutters">
                                    <?php if ($_login == null) { ?>
                                        <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
                                    <?php } else { ?>
                                        <div class="col-sm-2 col-3">Địa Chỉ IP:</div>
                                        <div class="col-sm-10 col-9">
                                            <?php echo get_user_ip(); ?> <br>
                                            <small class="text-muted"> Đăng nhập từ:
                                                <?php
                                                $user_agent = $_SERVER['HTTP_USER_AGENT'];

                                                // Find browser name
                                                if (strpos($user_agent, 'Chrome') !== false) {
                                                    $browser_name = 'Google Chrome';
                                                } elseif (strpos($user_agent, 'Firefox') !== false) {
                                                    $browser_name = 'Mozilla Firefox';
                                                } elseif (strpos($user_agent, 'Safari') !== false) {
                                                    $browser_name = 'Safari';
                                                } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident/7') !== false) {
                                                    $browser_name = 'Internet Explorer';
                                                } else {
                                                    $browser_name = 'Unknown';
                                                }

                                                // Find device type
                                                if (strpos($user_agent, 'iPhone') !== false) {
                                                    $device_type = 'Điện thoại iPhone';
                                                } elseif (strpos($user_agent, 'Mobile') !== false || strpos($user_agent, 'Android') !== false) {
                                                    $device_type = 'Điện thoại di động';
                                                } elseif (strpos($user_agent, 'iPad') !== false) {
                                                    $device_type = 'Máy tính bảng iPad';
                                                } elseif (strpos($user_agent, 'Windows') !== false) {
                                                    $device_type = 'Máy Tính Windows';
                                                } elseif (strpos($user_agent, 'Mac OS X') !== false) {
                                                    $device_type = 'macOS';
                                                } elseif (strpos($user_agent, 'Linux') !== false) {
                                                    $device_type = 'Linux';
                                                } else {
                                                    $device_type = 'Máy tính để bàn hoặc laptop';
                                                }

                                                // Display browser and device information
                                                echo "$browser_name từ $device_type";
                                                ?>
                                            </small>
                                        </div>
                                    </div>

                                    <div class="info-row row no-gutters">
                                        <div class="col-sm-2 col-3">Bảo mật</div>
                                        <div class="col-sm-10 col-9">
                                            <div class="bao-mat">
                                                <style>
                                                    .checked-vote {
                                                        font-weight: 900
                                                    }
                                                </style>
                                                <?php if ($_user !== null) { ?>
                                                    <?php if ($has_mkc2) { ?>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star checked-vote" aria-hidden="true"></i>
                                                        <i class="far fa-star" aria-hidden="true"></i>
                                                        <i class="far fa-star" aria-hidden="true"></i>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <ul class="settings-list">
                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Tên Tài Khoản:</b>
                                    </div>
                                    <div class="col-5">
                                        <?php echo $_username; ?>
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->


                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Số Dư:</b>
                                    </div>
                                    <div class="col-5">
                                        <?php echo number_format($_coin); ?> VND
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Tổng Nạp:</b>
                                    </div>
                                    <div class="col-5">
                                        <?php echo number_format($_tcoin); ?> VND
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Giới thiệu thành viên:</b>
                                    </div>
                                    <div class="col-5">
                                        <?php echo $_gioithieu; ?> Người
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Mật Khẩu Cấp 2:</b>
                                    </div>
                                    <div class="col-5">
                                        <strong>
                                            <span style="color:#e90600">
                                                <?php if ($_user !== null) { ?>
                                                    <?php if ($has_mkc2) { ?>
                                                        <p>Đã cập nhật.</p>
                                                    <?php } else { ?>
                                                        <p>Bạn chưa đặt mật khẩu cấp 2. Hãy đặt ngay để bảo vệ tài khoản của
                                                            mình.</p>
                                                    <?php }
                                                } ?>
                                            </span>
                                        </strong>
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Trạng Thái Thành Viên:</b>
                                    </div>
                                    <div class="col-5">
                                        <strong>
                                            <span style="color:#e90600">
                                                <?php if ($_status == "0") {
                                                    echo 'Chưa kích hoạt';
                                                } else if ($_status == "-1") {
                                                    echo 'Đang bị khoá';
                                                } else if ($_status == "1") {
                                                    echo 'Đã kích hoạt';
                                                } ?>
                                            </span>
                                        </strong>
                                    </div>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Mật Khẩu:</b>
                                    </div>
                                    <form>
                                        <div class="col-5 d-flex">
                                            <input type="password" id="passwordInput" value="<?php echo $_password; ?>"
                                                class="form-control" style="padding-right:30px;font-size:14px;width:200px"
                                                readonly autocomplete="password">
                                            <button class="btn btn-default ml-2" type="button" id="showPasswordButton"
                                                style="padding:6px">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <button class="btn btn-default ml-2" type="button" id="hidePasswordButton"
                                                style="display:none;padding:6px">
                                                <i class="far fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <script>
                                        $(document).ready(function () {
                                            $("#showPasswordButton").click(function () {
                                                $("#passwordInput").attr("type", "text");
                                                $("#showPasswordButton").hide();
                                                $("#hidePasswordButton").show()
                                            });
                                            $("#hidePasswordButton").click(function () {
                                                $("#passwordInput").attr("type", "password");
                                                $("#hidePasswordButton").hide();
                                                $("#showPasswordButton").show()
                                            })
                                        });
                                    </script>
                                </div>
                                <br>
                                <!-- </li> -->

                                <!-- <li class="info"> -->
                                <div class="row">
                                    <div class="col-3">
                                        <b>Đăng Xuất:</b>
                                    </div>
                                    <div class="col-5">
                                        <a class="btn btn-main" href="/?out" style="font-weight:500">Đăng
                                            xuất</a>
                                    </div>
                                </div>
                                <!-- </li> -->
                            </ul>
                        <?php } ?>
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
        <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/main.js"></script>
        </body><!-- Bootstrap core JavaScript -->

        </html>