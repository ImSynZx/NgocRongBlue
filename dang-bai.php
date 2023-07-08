<?php
include_once 'set.php';
include_once 'connect.php';
include('head.php');


$_alert = '';
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
            <h4 class="text-center">ĐĂNG BÀI</h4>
            <?php if ($_login == null) { ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><span class="text-danger">*</span> Tiêu đề:</label>
                        <input class="form-control" type="text" name="tieude" id="tieude"
                            placeholder="Nhập tiêu đề bài viết" required>

                        <label><span class="text-danger">*</span> Nội dung:</label>
                        <textarea class="form-control" type="text" name="noidung" id="noidung"
                            placeholder="Nhập nội dung bài viết" required></textarea>
                        <?php
                        $query = "SELECT account.*, account.admin FROM account LEFT JOIN player ON player.account_id = account.id";
                        $result = mysqli_query($conn, $query);

                        if ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <label><span class="text-danger">*</span> Thể loại:</label>
                            <select class="form-control" name="theloai" id="theloai" required>
                                <?php
                                if ($row['admin'] == 1) {
                                    // Thiết lập giá trị mặc định cho $theloai khi admin = 0
                                    ?>
                                    <option value="0">Thường</option>
                                    <option value="1">Thông Báo</option>
                                    <option value="2">Sự Kiện</option>
                                    <option value="3">Cập Nhật</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="0">Thường</option>
                                    <?php
                                }
                        }
                        ?>
                        </select>
                        <label>Chọn ảnh:</label>
                        <input class="form-control" type="file" name="image[]" id="image" multiple>

                        <div id="submit-error" class="alert alert-danger mt-2" style="display: none;"></div>
                    </div>

                    <button class="btn btn-main form-control" type="submit">ĐĂNG BÀI</button>
                </form>
                <?php
                include_once 'set.php';

                // Lấy dữ liệu từ form sử dụng phương thức POST
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Lấy giá trị của tiêu đề và nội dung bài viết
                    $tieude = htmlspecialchars($_POST["tieude"]);
                    $noidung = htmlspecialchars($_POST["noidung"]);
                    $theloai = intval($_POST["theloai"]);

                    if (isset($_POST['username'])) {
                        $_username = $_POST['username'];
                    }
                    $sql = "SELECT player.name FROM player INNER JOIN account ON account.id = player.account_id WHERE account.username='$_username'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $_name = $row['name'];

                    // Kiểm tra nếu có tệp tin ảnh được tải lên
                    if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
                        $image_files = $_FILES['image'];
                        $total_files = count($image_files['name']);

                        $image_names = array(); // Mảng để lưu trữ tên tệp tin ảnh
                        $upload_directory = "uploads/"; // Thư mục lưu trữ ảnh
            
                        for ($i = 0; $i < $total_files; $i++) {
                            $image_filename = $image_files['name'][$i];
                            $image_tmp = $image_files['tmp_name'][$i];

                            $targetFile = $upload_directory . basename($image_filename);

                            // Di chuyển tệp tin ảnh vào thư mục lưu trữ
                            move_uploaded_file($image_tmp, $targetFile);

                            // Thêm tên tệp tin vào mảng
                            $image_names[] = basename($image_filename);
                        }

                        // Chuyển đổi mảng thành chuỗi JSON
                        $image_names_json = json_encode($image_names);

                        // Lưu dữ liệu (bao gồm username và danh sách tên tệp tin ảnh) vào cơ sở dữ liệu bằng câu lệnh INSERT INTO
                        $sql = "INSERT INTO posts (tieude, noidung, theloai, image, username) VALUES ('$tieude', '$noidung', '$theloai', '$image_names_json', '$_name')";
                    } else {
                        // Nếu không có tệp tin ảnh được tải lên, lưu dữ liệu (bao gồm username) vào cơ sở dữ liệu bằng câu lệnh INSERT INTO
                        $sql = "INSERT INTO posts (tieude, noidung, theloai, username) VALUES ('$tieude', '$noidung', '$theloai', '$_name')";
                    }

                    if (mysqli_query($conn, $sql)) {
                        // Lấy số điểm tích lũy hiện tại của người dùng
                        $sql_select = "SELECT a.tichdiem FROM account a INNER JOIN player p ON a.id = p.account_id WHERE p.name = '$_name'";
                        $result_select = mysqli_query($conn, $sql_select);
                        $row_select = mysqli_fetch_assoc($result_select);
                        $tichdiem = $row_select['tichdiem'];

                        // Cập nhật giá trị tichdiem trong bảng account
                        $sql_update = "UPDATE account SET tichdiem = ($tichdiem + 1) WHERE id = (SELECT account_id FROM player WHERE name = '$_name')";
                        mysqli_query($conn, $sql_update);

                        echo "Bài viết đã được đăng thành công.";
                        // header("Location: baiviet.php");
                        // exit;
                    } else {
                        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }

                // Đóng kết nối với cơ sở dữ liệu
                mysqli_close($conn);
                ?>
                <script>
                    const form = document.querySelector('form');
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const submitError = form.querySelector('#submit-error');

                    form.addEventListener('submit', (event) => {
                        const titleLength = document.getElementById('tieude').value.trim().length;
                        const contentLength = document.getElementById('noidung').value.trim().length;

                        if (titleLength < 1 || contentLength < 1) {
                            event.preventDefault();

                            submitError.innerHTML = '<strong>Lỗi:</strong> Tiêu đề và nội dung phải có ít nhất 5 ký tự!';
                            submitError.style.display = 'block';
                            submitBtn.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
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
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>