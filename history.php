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
        <center>
        <br>
        <br>
            <h6 class="text-center">LỊCH SỬ NẠP THẺ</h6>
        </center> 
        <?php if ($_login == null) { ?>
                <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
            <?php } else { ?>
        <table class="table table-borderless text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TÀI KHOẢN</th>
                    <th>MỆNH GIÁ</th>
                    <th>LOẠI THẺ</th>
                    <th>TRẠNG THÁI</th>
                    <th>THỜI GIAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_username)) {
                    $stmt = $conn->prepare("SELECT * FROM trans_log WHERE name = ? ORDER BY id DESC LIMIT 10");
                    $stmt->bind_param("s", $_username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<tbody>';

                        while ($row = $result->fetch_assoc()) {
                            $status = '';

                            switch ($row['status']) {
                                case 1:
                                    $status = '<span>Thành Công</span>';
                                    break;
                                case 2:
                                    $status = '<span>Thất Bại</span>';
                                    break;
                                case 3:
                                    $status = '<span>Sai Mệnh Giá</span>';
                                    break;
                                default:
                                    $status = '<span>Chờ Duyệt</span>';
                            }

                            echo '<tr>
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . number_format($row['amount']) . 'đ</td>
                                    <td>' . $row['type'] . '</td>
                                    <td>' . $status . '</td>
                                    <td>' . $row['date'] . '</td>
                                    </tr>';
                        }

                        echo '</tbody>';
                    } else {
                        echo '<tbody>
                                <tr>
                                   <td colspan="6" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td>
                                </tr>
                               </tbody>';
                    }
                } else {
                    echo 'Chưa có tên người dùng được cung cấp.';
                }
            }
                ?>
            </tbody>
        </table>
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
<style>
    th,
    td {
        white-space: nowrap;
        padding: 2px 4px !important;
        font-size: 11px;
    }
</style>