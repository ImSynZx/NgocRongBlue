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
                        <b class="text text-danger">Lưu Ý: </b><br>
                        - Hãy thoát game trước khi buff tránh lỗi không mong muốn!
                        <br>
                        - Chỉ dùng những chỉ số thực sự có ích không chọn chỉ số lỗi nhé
                        <br>
                        <br>
                        <?php
                        echo '<form method="post" onsubmit="return validateForm()">';
                        echo '<label for="player_name">Tên nhân vật:</label>';
                        echo '<input class="form-control" type="text" name="player_name" id="player_name" required>';
                        echo '<br>';
                        echo '<label for="id">ID:</label>';
                        echo '<input class="form-control" type="text" name="id" id="id" required>';
                        echo '<br>';
                        echo '<label for="soluong">Số lượng:</label>';
                        echo '<input class="form-control" type="text" name="soluong" id="soluong" required>';
                        echo '<br>';

                        echo '<label for="option_type">Chọn Option:</label>';
                        echo '<select class="form-control" name="option_type" id="option_type" onchange="toggleOptionFields()">';
                        echo '<option value="no_option">Không chọn chỉ số</option>';
                        echo '<option value="has_option">Có chỉ số</option>';
                        echo '</select>';
                        echo '<br>';

                        $item_query = "SELECT id, name FROM item_option_template";
                        $item_result = mysqli_query($conn, $item_query);

                        $options = array();
                        while ($item_data = mysqli_fetch_assoc($item_result)) {
                            $options[] = array("id" => $item_data["id"], "name" => $item_data["name"]);
                        }

                        echo '<div id="optionFields" style="display: none;">'; // hiển thị option chỉ số có trong item_option_template
                        echo '<label for="option">Chỉ Số:</label>';
                        echo '<select class="form-control" name="option" id="option">';
                        foreach ($options as $option) {
                            echo '<option value="' . $option["id"] . '">' . $option["name"] . '</option>';
                        }
                        echo '</select>';
                        echo '<br>';

                        echo '<label for="param">Phần Trăm Chỉ Số:</label>';
                        echo '<input class="form-control" type="text" name="param" id="param">';
                        echo '<br>';
                        echo '</div>';

                        echo '<button type="submit" name="redeem_gift" class="btn btn-main form-control">Đổi quà</button>';
                        echo '</form>';


                        // Kiểm tra xem người dùng đã thực hiện đổi quà hay chưa
                        if (isset($_POST['redeem_gift'])) {
                            $account_id = $_SESSION['id'];
                            $player_name = $_POST['player_name'];

                            $player_query = "SELECT * FROM player WHERE account_id = $account_id AND name = '$player_name' LIMIT 1";
                            $player_result = mysqli_query($conn, $player_query);

                            if (mysqli_num_rows($player_result) > 0) {
                                $player_data = mysqli_fetch_assoc($player_result);
                                $player_id = $player_data['id'];

                                $gift_items = "";

                                $id = $_POST['id'];
                                $soluong = $_POST['soluong'];
                                $option_type = $_POST['option_type'];

                                if ($option_type === "has_option" && !empty($id) && !empty($soluong) && isset($_POST['option']) && isset($_POST['param'])) {
                                    $option = $_POST['option'];
                                    $param = $_POST['param'];
                                    $gift_items = "[$id, $soluong,\"[\"[$option, $param]\"]";
                                } else {
                                    $option = 73; // Giá trị mặc định cho option
                                    $param = 1; // Giá trị mặc định cho param
                                    $gift_items = "[$id, $soluong,\"[\"[73, 1]\"]";
                                }

                                if (!empty($gift_items)) {
                                    $_items_bag = $player_data['items_bag'];

                                    $replacement = "[$id, $soluong,\\\"[\\\\\\\\\\\"[$option,$param]\\\\\\\\\\\"]\\\"";
                                    $_items_bag = preg_replace('/\[-1,0,\\\"\[\]\\\"/', $replacement, $_items_bag, 1, $count);

                                    if ($count === 0) {
                                        echo '<div class="text-danger pb-2 font-weight-bold">';
                                        echo 'Không tìm thấy vật phẩm phù hợp';
                                        echo '</div>';
                                        exit; // Dừng việc thực thi tiếp nếu không tìm thấy vật phẩm phù hợp
                                    }

                                    if (empty($_items_bag)) {
                                        echo '<div class="text-danger pb-2 font-weight-bold">';
                                        echo 'Hành trang đầy, không thể nhận quà.';
                                        echo '</div>';
                                        exit; // Dừng việc thực thi tiếp nếu hành trang đã đầy
                                    }

                                    // Cập nhật dữ liệu ngay lập tức vào cơ sở dữ liệu
                                    $escaped_gift_items = mysqli_real_escape_string($conn, $gift_items);
                                    $escaped_items_bag = mysqli_real_escape_string($conn, $_items_bag);
                                    $update_query = "UPDATE player SET items_bag = '$escaped_items_bag' WHERE id = $player_id";
                                    mysqli_query($conn, $update_query);

                                    echo '<div class="text-danger pb-2 font-weight-bold">';
                                    echo "BUFF thành công cho người chơi $player_name";
                                    echo '</div>';
                                } else {
                                    echo '<div class="text-danger pb-2 font-weight-bold">';
                                    echo 'Không tìm thấy vật phẩm phù hợp';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="text-danger pb-2 font-weight-bold">';
                                echo 'Tên nhân vật không tồn tại.';
                                echo '</div>';
                            }
                        }
                        ?>

                        <script>
                            function toggleOptionFields() {
                                var optionType = document.getElementById("option_type").value;
                                var optionFieldsContainer = document.getElementById("optionFields");

                                if (optionType === "has_option") {
                                    optionFieldsContainer.style.display = "block";
                                } else {
                                    optionFieldsContainer.style.display = "none";
                                }
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