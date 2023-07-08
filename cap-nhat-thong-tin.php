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
                $stmt = $conn->prepare("SELECT password, gmail FROM account WHERE username=?");
                $stmt->bind_param("s", $_username);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $primaryPassword = $row['password'];
                $primaryGmail = $row['gmail'];

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $password = $_POST['password'] ?? '';
                    $newGmail = $_POST['new_gmail'] ?? '';
                    $newGmailConfirm = $_POST['new_gmail_confirm'] ?? '';

                    if (!empty($primaryGmail)) {
                        $oldGmail = isset($_POST['old_gmail']) ? $_POST['old_gmail'] : '';

                        if (!empty($password) && !empty($newGmail) && !empty($newGmailConfirm) && !empty($oldGmail)) {
                            // Kiểm tra xem mật khẩu hiện tại nhập vào có giống với mật khẩu trong database không.
                            // Nếu sai, in ra thông báo lỗi.
                            if ($password !== $primaryPassword) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai mật khẩu hiện tại</div>";
                            } elseif ($oldGmail !== $primaryGmail) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai Gmail hiện tại</div>";
                            } elseif ($newGmail === $primaryGmail) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Gmail mới không được giống với Gmail hiện tại</div>";
                            } elseif ($newGmail !== $newGmailConfirm) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Gmail mới không giống nhau</div>";
                            } elseif (!filter_var($newGmail, FILTER_VALIDATE_EMAIL) || substr($newGmail, -10) !== "@gmail.com") {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng nhập địa chỉ email Gmail (ví dụ: example@gmail.com)</div>";
                            } elseif (!filter_var($newGmailConfirm, FILTER_VALIDATE_EMAIL) || substr($newGmailConfirm, -10) !== "@gmail.com") {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng nhập địa chỉ email Gmail (ví dụ: example@gmail.com)</div>";
                            } else {
                                // Cập nhật Gmail mới lên database
                                $stmt = $conn->prepare("UPDATE account SET gmail=? WHERE username=?");
                                $stmt->bind_param("ss", $newGmail, $_username);

                                if ($stmt->execute()) {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Cập nhật Gmail thành công</div>";
                                } else {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Lỗi khi cập nhật Gmail</div>";
                                }
                            }
                        } else {
                            echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng điền đầy đủ thông tin trong form</div>";
                        }
                    } else {
                        if (!empty($password) && !empty($newGmail) && !empty($newGmailConfirm)) {
                            if ($password !== $primaryPassword) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Sai mật khẩu hiện tại</div>";
                            } elseif ($newGmail !== $newGmailConfirm) {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Gmail không giống nhau</div>";
                            } elseif (!filter_var($newGmail, FILTER_VALIDATE_EMAIL) || substr($newGmail, -10) !== "@gmail.com") {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng nhập địa chỉ email Gmail (ví dụ: example@gmail.com)</div>";
                            } elseif (!filter_var($newGmailConfirm, FILTER_VALIDATE_EMAIL) || substr($newGmailConfirm, -10) !== "@gmail.com") {
                                echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng nhập địa chỉ email Gmail (ví dụ: example@gmail.com)</div>";
                            } else {
                                // Cập nhật Gmail lên database
                                $stmt = $conn->prepare("UPDATE account SET gmail=? WHERE username=?");
                                $stmt->bind_param("ss", $newGmail, $_username);

                                if ($stmt->execute()) {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Cập nhật Gmail thành công</div>";
                                } else {
                                    echo "<div class='text-danger pb-2 font-weight-bold'>Lỗi khi cập nhật Gmail</div>";
                                }
                            }
                        } else {
                            echo "<div class='text-danger pb-2 font-weight-bold'>Vui lòng điền đầy đủ thông tin trong form</div>";
                        }
                    }
                }

                if (!empty($primaryGmail)) {
                    ?>
                    <p>Tài khoản của bạn đã được liên kết Gmail</p>
                    <!-- Trang HTML -->
                    <div id="remaining-time"></div>

                    <script>
                        // Sử dụng JavaScript và AJAX để gửi yêu cầu đến máy chủ và cập nhật nội dung của vùng hiển thị kết quả
                        function updateRemainingTime() {
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState === 4 && this.status === 200) {
                                    // Nhận phản hồi từ máy chủ và cập nhật nội dung của vùng hiển thị kết quả
                                    document.getElementById("remaining-time").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "./gmail/time.php", true); // Thay đổi đường dẫn đến tệp PHP xử lý
                            xhttp.send();
                        }

                        // Tự động cập nhật thời gian mỗi giây
                        setInterval(updateRemainingTime, 1000);
                    </script>

                    <div>Gmail liên kết: <span class="font-weight-bold">
                            <?php echo $primaryGmail; ?>
                        </span></div>
                <?php } else { ?>
                    <?php
                    // Lấy thông báo và lớp thông báo từ tham số truy vấn
                    $message = $_GET['message'] ?? '';
                    $messageClass = $_GET['messageClass'] ?? '';

                    // Hiển thị thông báo và lớp thông báo
                    if ($message && $messageClass) {
                        echo '<div class="' . $messageClass . '">' . $message . '</div>';
                    }
                    ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="font-weight-bold">Mật khẩu hiện tại:</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Mật khẩu hiện tại" required autocomplete="password">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Gmail mới:</label>
                            <input type="text" class="form-control" name="new_gmail" id="new_gmail" placeholder="Gmail mới"
                                required autocomplete="new_gmail">
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Xác nhận Gmail mới:</label>
                            <input type="text" class="form-control" name="new_gmail_confirm" id="new_gmail_confirm"
                                placeholder="Xác nhận Gmail mới" required autocomplete="new_gmail_confirm">
                        </div>
                        <button class="btn btn-main form-control" type="submit">Thực hiện</button>
                    </form>
                    <br>
                    <br>
                <?php }
            }
            ?>
            <div id="notification"></div>
        </div>
        <?php if ($_login == null) { ?>
        <?php } else { ?>
            <div class="col-lg-6 htop ">
                <br>
                <br>
                <h6> THÔNG TIN VỀ CẬP NHẬT THÔNG TIN</h6>
                1. Thông tin chung
                <br>
                - Cập nhật Gmail
                <br>
                - Dùng để lấy lại thông tin khi quên
                <br>
                - Có thể dùng hoặc không dùng
                <br>
                - Có thể đổi được gmail mới
                <br>
                - Nhấn vào nút HỦY GMAIL HIỆN TẠI là nó sẽ gửi gmail nha :3
                <br>
                <br>
                2. Hủy gmail hiện tại
                <br>
                - Gmail sẽ được huỷ luôn nếu như bạn xác nhận
                <br>
                - Vẫn có thể bật lại sau khi Hủy
                <br>
                <br>

                <?php if (!empty($primaryGmail)) { ?>
                    <div class="mt-2 mb-2">
                        <?php if (!empty($primaryGmail)) { ?>
                            <div class="mt-2 mb-2">
                                <a class="btn btn-sm color-main" href="#" id="sendEmailLink">
                                    <i class="fas fa-ban text-danger"></i> HỦY GMAIL HIỆN TẠI
                                </a>

                                <script>
                                    document.getElementById('sendEmailLink').addEventListener('click', function (event) {
                                        event.preventDefault();

                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', 'gmail/guithu.php', true);
                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                        xhr.send();

                                        xhr.onreadystatechange = function () {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    var response = xhr.responseText;
                                                    if (response === "success") {
                                                        alert("Gửi gmail thành công");
                                                        updateRemainingTime(); // Cập nhật thời gian sau khi gửi gmail thành công
                                                    } else {
                                                        console.error(response);
                                                    }
                                                } else {
                                                    console.error(xhr.statusText);
                                                }
                                            }
                                        };
                                    });
                                </script>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <br>
                <br>
                <br>
            </div>
        <?php } ?>
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