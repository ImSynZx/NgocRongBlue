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
                    <h4>VẬT PHẨM</h4><br>
                    <b class="text text-danger">Phổ Biến Thông Tin: </b><br>
                    <b>- Ví Dụ:
                        <br>
                        - ID: 457 (Thỏi Vàng)
                        <br>
                        - Số Lượng: 1 (Đây Là Số Lượng Vật Phẩm)
                        <br>
                        - Chỉ Số: Tấn Công (Chọn Chỉ Số Bất Kì)
                        <br>
                        - Phần Trăm Chỉ Số: 10 (Đây Là 10% Chỉ Số)
                        <br>
                        <br>
                        <br>
                        <?php
                        $_alert = '';

                        // Xử lý dữ liệu form khi submit
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Lấy giá trị từ form
                            $name = $_POST["name"];
                            $select_property = isset($_POST["select-property"]) ? $_POST["select-property"] : "";

                            // Kiểm tra tính hợp lệ của dữ liệu
                            if (!empty($name)) {
                                // Tìm nhân vật trong CSDL
                                $sql = "SELECT * FROM player WHERE name='$name'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Nhân vật tồn tại, cộng chỉ số cho nhân vật
                                    $row = $result->fetch_assoc();
                                    $data_point = json_decode($row["data_point"], true); // Chuyển đổi JSON thành mảng
                        
                                    // Cộng chỉ số tương ứng
                                    switch ($select_property) {
                                        case 'sucmanh':
                                            $sucmanh = isset($_POST["sucmanh"]) ? intval($_POST["sucmanh"]) : 0;
                                            $data_point[1] += $sucmanh;
                                            break;
                                        case 'tiemnang':
                                            $tiemnang = isset($_POST["tiemnang"]) ? intval($_POST["tiemnang"]) : 0;
                                            $data_point[2] += $tiemnang;
                                            break;
                                        case 'theluc':
                                            $theluc = isset($_POST["theluc"]) ? intval($_POST["theluc"]) : 0;
                                            $data_point[3] += $theluc;
                                            break;
                                        case 'toidatheluc':
                                            $toidatheluc = isset($_POST["toidatheluc"]) ? intval($_POST["toidatheluc"]) : 0;
                                            $data_point[4] += $toidatheluc;
                                            break;
                                        case 'hp':
                                            $hp = isset($_POST["hp"]) ? intval($_POST["hp"]) : 0;
                                            $data_point[5] += $hp;
                                            break;
                                        case 'mp':
                                            $mp = isset($_POST["mp"]) ? intval($_POST["mp"]) : 0;
                                            $data_point[6] += $mp;
                                            break;
                                        case 'sdg':
                                            $sdg = isset($_POST["sdg"]) ? intval($_POST["sdg"]) : 0;
                                            $data_point[7] += $sdg;
                                            break;
                                        case 'giapgoc':
                                            $giapgoc = isset($_POST["giapgoc"]) ? intval($_POST["giapgoc"]) : 0;
                                            $data_point[8] += $giapgoc;
                                            break;
                                        case 'chimang':
                                            $chimang = isset($_POST["chimang"]) ? intval($_POST["chimang"]) : 0;
                                            $data_point[9] += $chimang;
                                            break;
                                        case 'congtoanbo':
                                            $congtoanbo_sucmanh = isset($_POST["congtoanbo-sucmanh"]) ? intval($_POST["congtoanbo-sucmanh"]) : 0;
                                            $congtoanbo_tiemnang = isset($_POST["congtoanbo-tiemnang"]) ? intval($_POST["congtoanbo-tiemnang"]) : 0;
                                            $congtoanbo_theluc = isset($_POST["congtoanbo-theluc"]) ? intval($_POST["congtoanbo-theluc"]) : 0;
                                            $congtoanbo_toidatheluc = isset($_POST["congtoanbo-toidatheluc"]) ? intval($_POST["congtoanbo-toidatheluc"]) : 0;
                                            $congtoanbo_hp = isset($_POST["congtoanbo-hp"]) ? intval($_POST["congtoanbo-hp"]) : 0;
                                            $congtoanbo_mp = isset($_POST["congtoanbo-mp"]) ? intval($_POST["congtoanbo-mp"]) : 0;
                                            $congtoanbo_sdg = isset($_POST["congtoanbo-sdg"]) ? intval($_POST["congtoanbo-sdg"]) : 0;
                                            $congtoanbo_giapgoc = isset($_POST["congtoanbo-giapgoc"]) ? intval($_POST["congtoanbo-giapgoc"]) : 0;
                                            $congtoanbo_chimang = isset($_POST["congtoanbo-chimang"]) ? intval($_POST["congtoanbo-chimang"]) : 0;

                                            $data_point[1] += $congtoanbo_sucmanh;
                                            $data_point[2] += $congtoanbo_tiemnang;
                                            $data_point[3] += $congtoanbo_theluc;
                                            $data_point[4] += $congtoanbo_toidatheluc;
                                            $data_point[5] += $congtoanbo_hp;
                                            $data_point[6] += $congtoanbo_mp;
                                            $data_point[7] += $congtoanbo_sdg;
                                            $data_point[8] += $congtoanbo_giapgoc;
                                            $data_point[9] += $congtoanbo_chimang;
                                            break;
                                    }

                                    // Cập nhật chỉ số của nhân vật trong CSDL
                                    $updated_data_point = json_encode($data_point);
                                    $player_id = $row["name"]; // Tên cột chưa rõ, hãy thay thế "player_id" bằng tên cột chứa ID của nhân vật
                                    $sql_update = "UPDATE player SET data_point='$updated_data_point' WHERE name='$player_id'";
                                    if ($conn->query($sql_update) === TRUE) {
                                        $_alert = 'Cập nhật thành công!';
                                    } else {
                                        $_alert = 'Cập nhật thất bại!';
                                    }
                                } else {
                                    $_alert = 'Không tìm thấy nhân vật.';
                                }
                            } else {
                                $_alert = 'Vui lòng nhập tên nhân vật.';
                            }
                        }

                        // Hiển thị form và thông báo
                        echo $_alert;
                        ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="font-weight-bold" for="name">Tên Tài Khoản:</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Nhập tên tài khoản" required autocomplete="name">
                            </div>

                            <div class="mb-3">
                                <label class="font-weight-bold" for="select-property">Chỉ Số:</label>
                                <select class="form-control" id="select-property" name="select-property">
                                    <option value="none">Chọn Chỉ Số</option>
                                    <option value="sucmanh">Sức Mạnh</option>
                                    <option value="tiemnang">Tiềm Năng</option>
                                    <option value="tiemnang">Thể Lực</option>
                                    <option value="tiemnang">Tối Đa Thể Lực</option>
                                    <option value="hp">HP</option>
                                    <option value="mp">MP</option>
                                    <option value="sdg">Sức Đánh Gốc</option>
                                    <option value="giapgoc">Giáp Gốc</option>
                                    <option value="chimang">Chí Mạng</option>
                                    <option value="congtoanbo">Cộng Toàn Bộ Chỉ Số</option>
                                </select>
                            </div>

                            <div class="mb-3" id="sucmanh-input" style="display:none;">
                                <label class="font-weight-bold" for="sucmanh">Sức Mạnh:</label>
                                <input type="number" class="form-control" name="sucmanh" id="sucmanh"
                                    placeholder="Nhập chỉ số Sức Mạnh" required autocomplete="sucmanh">
                            </div>

                            <div class="mb-3" id="tiemnang-input" style="display:none;">
                                <label class="font-weight-bold" for="tiemnang">Tiềm Năng:</label>
                                <input type="number" class="form-control" name="tiemnang" id="tiemnang"
                                    placeholder="Nhập tiềm năng cần cộng" required autocomplete="tiemnang">
                            </div>

                            <div class="mb-3" id="theluc-input" style="display:none;">
                                <label class="font-weight-bold" for="theluc">Thể Lực:</label>
                                <input type="number" class="form-control" name="theluc" id="theluc"
                                    placeholder="Nhập thể lực cần cộng" required autocomplete="theluc">
                            </div>

                            <div class="mb-3" id="toidatheluc-input" style="display:none;">
                                <label class="font-weight-bold" for="toidatheluc">Tối Đa Thể Lực:</label>
                                <input type="number" class="form-control" name="toidatheluc" id="toidatheluc"
                                    placeholder="Nhập tối đa thẻ lực cần cộng" required autocomplete="toidatheluc">
                            </div>

                            <div class="mb-3" id="hp-input" style="display:none;">
                                <label class="font-weight-bold" for="hp">HP:</label>
                                <input type="number" class="form-control" name="hp" id="hp" placeholder="Nhập chỉ số HP"
                                    required autocomplete="hp">
                            </div>

                            <div class="mb-3" id="mp-input" style="display:none;">
                                <label class="font-weight-bold" for="mp">MP:</label>
                                <input type="number" class="form-control" name="mp" id="mp" placeholder="Nhập chỉ số MP"
                                    required autocomplete="mp">
                            </div>

                            <div class="mb-3" id="sdg-input" style="display:none;">
                                <label class="font-weight-bold" for="sdg">Sức Đánh Gốc:</label>
                                <input type="number" class="form-control" name="sdg" id="sdg"
                                    placeholder="Nhập chỉ số Sức Đánh Gốc" required autocomplete="sdg">
                            </div>

                            <div class="mb-3" id="giapgoc-input" style="display:none;">
                                <label class="font-weight-bold" for="giapgoc">Giáp Gốc:</label>
                                <input type="number" class="form-control" name="giapgoc" id="giapgoc"
                                    placeholder="Nhập chỉ số Giáp Gốc" required autocomplete="giapgoc">
                            </div>

                            <div class="mb-3" id="chimang-input" style="display:none;">
                                <label class="font-weight-bold" for="chimang">Chí Mạng:</label>
                                <input type="number" class="form-control" name="chimang" id="chimang"
                                    placeholder="Nhập chỉ số Chí Mạng" required autocomplete="chimang">
                            </div>

                            <div class="mb-3" id="congtoanbo-input" style="display:none;">
                                <label class="font-weight-bold">Cộng Toàn Bộ Chỉ Số:</label>
                                <input type="number" class="form-control" name="congtoanbo-sucmanh"
                                    id="congtoanbo-sucmanh" placeholder="Nhập chỉ số Sức Mạnh" required
                                    autocomplete="sucmanh">
                                <input type="number" class="form-control" name="congtoanbo-tiemnang"
                                    id="congtoanbo-tiemnang" placeholder="Nhập chỉ số Tiềm Năng" required
                                    autocomplete="tiemnang">
                                <input type="number" class="form-control" name="congtoanbo-theluc"
                                    id="congtoanbo-theluc" placeholder="Nhập chỉ số Thể Lực" required
                                    autocomplete="theluc">
                                <input type="number" class="form-control" name="congtoanbo-toidatheluc"
                                    id="congtoanbo-toidatheluc" placeholder="Nhập chỉ số Thể lực tối đa" required
                                    autocomplete="toidatheluc">
                                <input type="number" class="form-control" name="congtoanbo-hp" id="congtoanbo-hp"
                                    placeholder="Nhập chỉ số HP" required autocomplete="hp">
                                <input type="number" class="form-control" name="congtoanbo-mp" id="congtoanbo-mp"
                                    placeholder="Nhập chỉ số MP" required autocomplete="mp">
                                <input type="number" class="form-control" name="congtoanbo-sdg" id="congtoanbo-sdg"
                                    placeholder="Nhập chỉ số Sức Đánh Gốc" required autocomplete="sdg">
                                <input type="number" class="form-control" name="congtoanbo-giapgoc"
                                    id="congtoanbo-giapgoc" placeholder="Nhập chỉ số Giáp Gốc" required
                                    autocomplete="giapgoc">
                                <input type="number" class="form-control" name="congtoanbo-chimang"
                                    id="congtoanbo-chimang" placeholder="Nhập chỉ số Chí Mạng" required
                                    autocomplete="chimang">
                            </div>

                            <input class="btn btn-main form-control" type="submit" value="Thực Hiện">
                        </form>

                        <script>
                            document.getElementById('select-property').addEventListener('change', function () {
                                var value = this.value;
                                switch (value) {
                                    case 'none':
                                        hideAllInputs();
                                        break;
                                    case 'sucmanh':
                                        hideAllInputs();
                                        showInput('sucmanh-input');
                                        break;
                                    case 'tiemnang':
                                        hideAllInputs();
                                        showInput('tiemnang-input');
                                        break;
                                    case 'theluc':
                                        hideAllInputs();
                                        showInput('theluc-input');
                                        break;
                                    case 'toidatheluc':
                                        hideAllInputs();
                                        showInput('toidatheluc-input');
                                        break;
                                    case 'hp':
                                        hideAllInputs();
                                        showInput('hp-input');
                                        break;
                                    case 'mp':
                                        hideAllInputs();
                                        showInput('mp-input');
                                        break;
                                    case 'sdg':
                                        hideAllInputs();
                                        showInput('sdg-input');
                                        break;
                                    case 'giapgoc':
                                        hideAllInputs();
                                        showInput('giapgoc-input');
                                        break;
                                    case 'chimang':
                                        hideAllInputs();
                                        showInput('chimang-input');
                                        break;
                                    case 'congtoanbo':
                                        hideAllInputs();
                                        showInput('congtoanbo-input');
                                        break;
                                }
                            });

                            function hideAllInputs() {
                                var inputs = document.querySelectorAll('div[id$="-input"]');
                                inputs.forEach(function (input) {
                                    input.style.display = 'none';
                                });
                            }

                            function showInput(inputId) {
                                var input = document.getElementById(inputId);
                                input.style.display = 'block';
                            }
                        </script>
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