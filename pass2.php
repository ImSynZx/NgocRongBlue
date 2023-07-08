<?php
include_once 'set.php';
include_once 'connect.php';
include_once 'head.php';

?>
<div class="container color-main2 pb-3">
    <div class="row">
        <div class="container color-main pt-2">
            <div class="row">
                <div class="col"> <a href="index" style="color: white">Quay lại diễn đàn</a> </div>
            </div>
        </div>
    </div>
</div>
<div class="container color-main2 pb-2" id="pageHeader">
    <div class="row pb-2 pt-2">
        <div class="col-lg-6">
            <br>
            <br>
            <?php if ($_login == null) { ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
                <?php
                $stmt = $conn->prepare("SELECT password, mkc2 FROM account WHERE username=?");
                $stmt->bind_param("s", $_username);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $primaryPassword = $row['password'];
                $mkc2 = $row['mkc2'];

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $password = $_POST['password'] ?? '';
                    $new_passwordcap2 = $_POST['new_passwordcap2'] ?? '';
                    $new_passwordcap2xacnhan = $_POST['new_passwordcap2xacnhan'] ?? '';

                    if (!empty($mkc2)) {
                        $old_passwordcap2 = isset($_POST['old_passwordcap2']) ? $_POST['old_passwordcap2'] : '';

                        if (!empty($password) && !empty($new_passwordcap2) && !empty($new_passwordcap2xacnhan) && !empty($old_passwordcap2)) {
                            // Kiểm tra xem mật khẩu hiện tại nhập vào có giống với mật khẩu trong database không.
                            // Nếu sai, in ra thông báo lỗi.
                            if ($password !== $primaryPassword) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai mật khẩu hiện tại</div>";
                            } elseif ($old_passwordcap2 !== $mkc2) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai mật khẩu cấp 2 hiện tại</div>";
                            } elseif ($new_passwordcap2 === $password) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Mật khẩu cấp 2 không được giống mật khẩu hiện tại</div>";
                            } elseif ($new_passwordcap2 !== $new_passwordcap2xacnhan) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Mật khẩu cấp 2 không giống nhau</div>";
                            } elseif ($password === $new_passwordcap2) { // Kiểm tra mật khẩu hiện tại có trùng với mật khẩu mới hay không.
                                echo "<div class='text-danger pb-2 font-weight-bold'>Mật khẩu cấp 2 phải khác với mật khẩu hiện tại</div>";
                            } else {
                                // Cập nhật mật khẩu cấp 2 lên database
                                $stmt = $conn->prepare("UPDATE account SET mkc2=? WHERE username=?");
                                $stmt->bind_param("ss", $new_passwordcap2, $_username);

                                if ($stmt->execute()) {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Cập nhật mật khẩu cấp 2 thành công</div>";
                                } else {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Lỗi khi cập nhật mật khẩu cấp 2</div>";
                                }
                            }
                        } else {
                            echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng điền đầy đủ thông tin trong form</div>";
                        }
                    } else {
                        if (!empty($password) && !empty($new_passwordcap2) && !empty($new_passwordcap2xacnhan)) {
                            if ($password !== $primaryPassword) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai mật khẩu hiện tại</div>";
                            } elseif ($new_passwordcap2 === $password) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Mật khẩu cấp 2 không được giống mật khẩu hiện tại</div>";
                            } elseif ($new_passwordcap2 !== $new_passwordcap2xacnhan) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Mật khẩu cấp 2 không giống nhau</div>";
                            } else {
                                $stmt = $conn->prepare("UPDATE account SET mkc2=? WHERE username=?");
                                $stmt->bind_param("ss", $new_passwordcap2, $_username);

                                if ($stmt->execute()) {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Cập nhật mật khẩu cấp 2 thành công</div>";
                                } else {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Lỗi khi cập nhật mật khẩu cấp 2</div>";
                                }
                            }
                        } else {
                            echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng điền đầy đủ thông tin trong form</div>";
                        }
                    }
                }

                if (!empty($mkc2)) {
                    ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật Khẩu hiện tại:</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Mật khẩu hiện tại" required autocomplete="password">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật Khẩu Cấp 2 Hiện Tại:</label>
                            <input type="password" class="form-control" name="old_passwordcap2" id="old_passwordcap2"
                                placeholder="Mật khẩu cấp 2 hiện tại" required autocomplete="old-passwordcap2">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật Khẩu Cấp 2 Mới:</label>
                            <input type="password" class="form-control" name="new_passwordcap2" id="new_passwordcap2"
                                placeholder="Mật khẩu cấp 2 mới" required autocomplete="new-passwordcap2">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Xác Nhận Mật Khẩu Cấp 2:</label>
                            <input type="password" class="form-control" name="new_passwordcap2xacnhan"
                                id="new_passwordcap2xacnhan" placeholder="Xác nhận mật khẩu cấp 2 mới" required
                                autocomplete="new-passwordcap2xacnhan">
                        </div>
                        <button class="btn btn-main form-control" type="submit">Thực hiện</button>
                    </form>
                <?php } else { ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật Khẩu Hiện Tại:</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Mật khẩu hiện tại" required autocomplete="password">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật Khẩu Cấp 2:</label>
                            <input type="password" class="form-control" name="new_passwordcap2" id="new_passwordcap2"
                                placeholder="Mật khẩu cấp 2" required autocomplete="new-passwordcap2">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Nhập Lại Mật Khẩu Cấp 2:</label>
                            <input type="password" class="form-control" name="new_passwordcap2xacnhan"
                                id="new_passwordcap2xacnhan" placeholder="Xác nhận mật khẩu cấp 2" required
                                autocomplete="new-passwordcap2xacnhan">
                        </div>
                        <button class="btn btn-main form-control" type="submit">Thực hiện</button>
                    </form>
                <?php }
            } ?>
            <div id="notification"></div>
        </div>
        <?php if ($_login == null) { ?>
        <?php } else { ?>
            <div class="col-lg-6 htop ">
                <br>
                <br>
                <h6> THÔNG TIN VỀ MẬT KHẨU CẤP 2</h6>
                1. Thông tin chung
                <br>
                - Gồm các kí tự a-z và 0-9
                <br>
                - Dùng để xác nhận khi đổi mật khẩu
                <br>
                - Có thể dùng hoặc không dùng
                <br>
                - Có thể đổi được mật khẩu cấp 2
                <br>
                2. Hủy mật khẩu cấp 2
                <br>
                - Sau 7 ngày kể từ lúc thao tác Hủy
                <br>
                - Vẫn có thể bật lại sau khi Hủy
                <br>
                <?php if (!empty($mkc2)) { ?>
                    <div class="mt-2 mb-2">
                        <button class="btn btn-sm color-main" type="button" data-toggle="modal" data-target="#modal-confirm">
                            <i class="fas fa-ban text-danger"></i> HỦY MẬT KHẨU CẤP 2</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header color-main">
                    <h4 class="modal-title">Xác nhận</h4> <button type="button" class="close"
                        data-dismiss="modal">×</button>
                </div>
                <div class="modal-body color-main2">
                    <div class="form-group"> <label>Mật khẩu cấp 2 hiện tại:</label> <input type="text" class="form-control"
                            id="cpass" name="cpass"> </div>
                </div>
                <div class="modal-footer color-main2"> <button class="btn btn-sm font-weight-bold color-main" type="button"
                        onclick="fCancelFast()" data-dismiss="modal"><i class="fas fa-key"></i> Xác
                        nhận</button> </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-confirm">
        <div class="modal-dialog modal-lg"> <!-- Thay đổi modal-dialog thành modal-lg -->
            <div class="modal-content">
                <div class="modal-header color-main">
                    <h4 class="modal-title">Xác nhận</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body color-main2">
                    <p>Sau <span class="text-danger">7 ngày</span> kể từ lúc xác nhận, Mật khẩu cấp 2 sẽ được Hủy. Bạn có
                        chắc chắn muốn thực hiện?</p>
                    <form id="deleteMkc2Form" method="POST">
                        <div class="form-group">
                            <label for="delete_passwordcap2">Mật khẩu cấp 2:</label>
                            <input type="password" class="form-control form-control-lg" name="delete_passwordcap2"
                                id="delete_passwordcap2" required> <!-- Thay đổi lớp CSS của input thành form-control-lg -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer color-main2">
                    <button class="btn btn-sm btn-block font-weight-bold color-main" type="button" onclick="deleteMkc2()">
                        <i class="fas fa-key"></i> Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    function deleteMkc2() {
        var deletePasswordcap2 = document.getElementById("delete_passwordcap2").value;
        // Gửi yêu cầu xóa mật khẩu cấp 2 bằng Ajax hoặc Fetch API
        // Sử dụng biến deletePasswordcap2 để gửi giá trị mật khẩu cấp 2 nhập vào

        // Ví dụ sử dụng Fetch API:
        fetch("delete_pass2.php", {
            method: "POST",
            body: new URLSearchParams("passwordcap2=" + deletePasswordcap2)
        })
            .then(function (response) {
                // Xử lý kết quả trả về từ server (thành công hay lỗi)
                // Tùy theo kịch bản của bạn
                if (response.ok) {
                    // Xóa mật khẩu cấp 2 thành công
                    $('#modal-confirm').modal('hide');
                    $('#notification').html("<div class='text-danger pb-2 font-weight-bold'>Hủy mật khẩu cấp 2 thành công</div>");
                } else {
                    // Xảy ra lỗi khi xóa mật khẩu cấp 2
                    $('#notification').html("<div class='text-danger pb-2 font-weight-bold'>Có lỗi xảy ra khi xóa mật khẩu cấp 2</div>");
                }
            })
            .catch(function (error) {
                console.error("Lỗi khi gửi yêu cầu xóa mật khẩu cấp 2:", error);
            });
    }

</script>
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