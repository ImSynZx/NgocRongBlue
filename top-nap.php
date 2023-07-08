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
        <style>
            th,
            td {
                white-space: nowrap;
                padding: 2px 4px !important;
                font-size: 11px;
            }
        </style>
        <div class="container color-forum pt-2">
            <br>
            <br>
            <div class="row">
                <div class="col">
                    <h6 class="text-center">BẢNG XẾP HẠNG ĐUA TOP DragonKing</h6>
                    <table class="table table-borderless text-center">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Nhân Vật</th>
                                <th>Tổng Nạp</th>
                            </tr>
                        </tbody>
                        <tbody>
                            <?php
                            include 'connect.php';

                            $query = "SELECT player.name, SUM(account.tongnap) AS tongnap FROM account JOIN player ON account.id = player.account_id GROUP BY player.name ORDER BY tongnap DESC LIMIT 10";
                            $result = $conn->query($query);
                            $stt = 1;
                            if (!$result) {
                                echo 'Lỗi truy vấn SQL: ' . mysqli_error($conn);
                            } else if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                           <tr>
                           <td>' . $stt . '</td>
                           <td>' . $row['name'] . '</td>
                           <td>' . number_format($row['tongnap'], 0, ',') . 'đ</td>
                           </tr>
                           ';
                                    $stt++;
                                }
                            } else {
                                echo '<div class="alert alert-success">Máy Chủ 1 chưa có thông kê bảng xếp hạng!';
                            }

                            // Đóng kết nối
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <small>Cập nhật lúc:
                            <?php echo date('H:i d/m/Y'); ?>
                        </small>
                    </div>
                </div>
            </div>
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
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>