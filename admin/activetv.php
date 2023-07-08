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
                    <h4>Kích Hoạt Thành Viên</h4><br>
                    <b class="text text-danger">Lưu Ý: </b><br>
                    - Hãy thoát game trước khi mở thành viên tránh lỗi không mong muốn!
                    <br>
                    - Chỉ dùng cho những tài khoản không bị khóa do vi phạm
                    <br>
                    <br>
                    <?php
                    $_alert = '';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $_username = $_POST["username"];

                        // Use prepared statement to prevent SQL injection
                        $stmt_check = $conn->prepare("SELECT * FROM account WHERE username = ?");
                        $stmt_check->bind_param("s", $_username);
                        $stmt_check->execute();
                        $result_check = $stmt_check->get_result();

                        if ($result_check->num_rows == 0) {
                            $_alert = '<div class="alert alert-danger">Lỗi: Tài khoản không tồn tại!</div>';
                        } else {
                            $row = $result_check->fetch_assoc();
                            if ($row["ban"] == 1) {
                                $_alert = '<div class="alert alert-danger">Lỗi: Tài khoản đã bị vi phạm và không thể kích hoạt!
                        </div>';
                            } else {
                                // Use prepared statement to update active status
                                $stmt_update = $conn->prepare("UPDATE account SET active = '1' WHERE username = ?");
                                $stmt_update->bind_param("s", $_username);
                                if ($stmt_update->execute()) {
                                    if ($stmt_update->affected_rows == 1) {
                                        $_alert = '<div class="alert alert-danger">>Kích hoạt thành viên thành công cho tài khoản: ' .
                                            $_username . '!</div>';
                                    } else {
                                        $_alert = '<div class="alert alert-danger">Tài khoản: ' . $_username . ' đã kích hoạt thành viên
                            rồi!</div>';
                                    }
                                } else {
                                    $_alert = '<div class="alert alert-danger">Lỗi: Kết nối đến máy chủ</div>';
                                }
                            }
                        }

                        $stmt_check->close();
                        $stmt_update->close();
                    }

                    $conn->close();
                    ?>

                    <!-- Hiển thị biến $_alert -->
                    <?php
                    echo $_alert;
                    ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Tên Tài Khoản:</label>
                            <input type="username" class="form-control" name="username" id="username"
                                placeholder="Nhập tên tài khoản" required autocomplete="username">
                        </div>
                        <button class="btn btn-main form-control" type="submit">Kích Hoạt</button>
                    </form>
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