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
                                <th>Nhân vật</th>
                                <th>Sức Mạnh</th>
                                <th>Đệ Tử</th>
                                <th>Hành Tinh</th>
                                <th>Tổng</th>
                            </tr>
                        <tbody>
                            <?php
                            $countTop = 1;
                            $data = mysqli_query($config, "SELECT name, gender, 
    CASE 
        WHEN gender = 1 THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
        WHEN gender = 2 THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
        ELSE CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED)
    END AS second_value,
    SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(pet, '$[1]')), ',', 2), ',', -1) AS detu_sm,
    CAST(JSON_UNQUOTE(JSON_EXTRACT(data_point, '$[1]')) AS SIGNED) + CAST(COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(pet, '$[1]')), ',', 2), ',', -1), '0') AS SIGNED) AS tongdiem
FROM player
ORDER BY tongdiem DESC
LIMIT 10;");
                            if (mysqli_num_rows($data) > 0) { // Check the number of returned results
                                while ($row = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr class="top_<?php echo $countTop; ?>">
                                        <td>
                                            <?php echo $countTop++; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $value = $row['second_value'];

                                            if ($value != '') {
                                                if ($value > 1000000000) {
                                                    echo number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                                } elseif ($value > 1000000) {
                                                    echo number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                                } elseif ($value >= 1000) {
                                                    echo number_format($value / 1000, 1, '.', '') . ' k';
                                                } else {
                                                    echo number_format($value, 0, ',', '');
                                                }
                                            } else {
                                                echo 'Không có chỉ số sức mạnh';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $value = $row['detu_sm'];

                                            if ($value != '') {
                                                if ($value > 1000000000) {
                                                    echo number_format($value / 1000000000, 1, '.', '') . ' tỷ';
                                                } elseif ($value > 1000000) {
                                                    echo number_format($value / 1000000, 1, '.', '') . ' Triệu';
                                                } elseif ($value >= 1000) {
                                                    echo number_format($value / 1000, 1, '.', '') . ' k';
                                                } else {
                                                    echo number_format($value, 0, ',', '');
                                                }
                                            } else {
                                                echo 'Không đệ tử';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['gender'] == 0) {
                                                echo "Trái đất";
                                            } elseif ($row['gender'] == 1) {
                                                echo "Namec";
                                            } elseif ($row['gender'] == 2) {
                                                echo "Xayda";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $total = $row['tongdiem'];

                                            if ($total > 1000000000) {
                                                echo number_format($total / 1000000000, 1, '.', '') . ' tỷ';
                                            } elseif ($total > 1000000) {
                                                echo number_format($total / 1000000, 1, '.', '') . ' Triệu';
                                            } elseif ($total >= 1000) {
                                                echo number_format($total / 1000, 1, '.', '') . ' k';
                                            } else {
                                                echo number_format($total, 0, ',', '');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo 'Máy Chủ 1 chưa có thông kê bảng xếp hạng!';
                            }
                            ?>


                        </tbody>
                    </table>
                    <script>
                        // Cập nhật tự động sau mỗi 3 giây
                        setInterval(function () {
                            $.ajax({
                                url: location.href, // URL hiện tại
                                success: function (result) {
                                    var leaderboardTable = $(result).find('#leaderboard-table'); // Tìm bảng xếp hạng trong HTML mới nhận được
                                    $('#leaderboard-table').html(leaderboardTable.html()); // Cập nhật HTML của bảng xếp hạng
                                }
                            });
                        }, 3000);
                    </script>
                    <div class="text-right">
                        <?php
                        date_default_timezone_set('Asia/Ho_Chi_Minh');

                        // Thực hiện truy vấn để lấy thời gian cập nhật từ cột data_point trong bảng player
                        $updateTimeQuery = mysqli_query($config, "SELECT data_point, pet FROM player");
                        $lastUpdate = null;

                        while ($row = mysqli_fetch_assoc($updateTimeQuery)) {
                            $dataPoint = json_decode($row['data_point'], true);
                            $pet = json_decode($row['pet'], true);

                            if (isset($dataPoint[1]) && $dataPoint[1] !== null) {
                                $updateTime = strtotime($dataPoint[1]);
                                if ($updateTime !== false && ($lastUpdate === null || $updateTime > $lastUpdate)) {
                                    $lastUpdate = $updateTime;
                                }
                            }

                            if (isset($pet[1]) && $pet[1] !== null) {
                                $petValue = intval($pet[1]);
                                // Thực hiện các tính toán khác với giá trị pet
                                // Ví dụ:
                                // $totalPet = $petValue * 2;
                                // echo "Giá trị pet: " . $totalPet;
                            }
                        }

                        if ($lastUpdate !== null) {
                            $formattedLastUpdate = date('H:i d/m/Y', $lastUpdate);
                            echo '<small>Cập nhật lúc: ' . $formattedLastUpdate . '</small>';
                        } else {
                            echo '<small>Chưa có dữ liệu cập nhật.</small>';
                        }

                        ?>
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