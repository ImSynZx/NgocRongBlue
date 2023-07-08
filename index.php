<?php
// 
include_once 'connect.php';
include_once 'set.php';
include('head.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DragonKing - Máy Chủ Ngọc Rồng Online</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="./assets/jquery/jquery.min.js"></script>
    <script src="./assets/notify/notify.js"></script>
    <link href="./assets/main.css" rel="stylesheet">
    <script>
        var login = false
    </script>
</head>
<div class="container color-main2 pb-3">
    <div class="row">
        <div class="col">
            <div class="box-stt">
                <div style="width: 40px; float:left; margin-right: 5px;">
                    <img src="image/avatar3.png" style="width: 35px">
                </div>
                <div class="box-right">
                    <a href="mo-thanh-vien" class="important"> Mở Thành Viên 1 Đồng <img src="image/hot.gif"></a>
                    <div class="box-name" style="font-size: 9px;"> bởi ADMIN </div>
                </div>
            </div>
            <div class="box-stt">
                <div style="width: 40px; float:left; margin-right: 5px;">
                    <img src="image/avatar4.png" style="width: 35px">
                </div>
                <div class="box-right">
                    <a href="gioithieu" class="important"> Sự Kiện Giới Thiệu <img src="image/hot.gif"></a>
                    <div class="box-name" style="font-size: 9px;"> bởi Nguyễn Đức Kiên </div>
                </div>
            </div>
            <div class="box-stt">
                <div style="width: 40px; float:left; margin-right: 5px;">
                    <img src="image/avatar6.png" style="width: 35px">
                </div>
                <div class="box-right">
                    <a href="bang-xep-hang" class="important"> Bảng Xếp Hạng Đua Top <img src="image/hot.gif"></a>
                    <div class="box-name" style="font-size: 9px;"> bởi NTDucKien </div>
                </div>
            </div>
            <div class="box-stt">
                <div style="width: 40px; float:left; margin-right: 5px;">
                    <img src="image/avatar10.png" style="width: 35px">
                </div>
                <div class="box-right">
                    <a href="top-nap" class="important"> Bảng Xếp Hạng Top Nạp <img src="image/hot.gif"></a>
                    <div class="box-name" style="font-size: 9px;"> bởi NTDucKien </div>
                </div>
            </div>
            <div class="box-stt">
                <?php
                $query = "SELECT posts.*, player.gender, account.admin FROM posts 
                    LEFT JOIN player ON posts.username = player.name 
                    LEFT JOIN account ON player.account_id = account.id 
                    WHERE posts.username = player.name 
                    ORDER BY posts.id DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $post_id = $row['id'];

                    // Lấy Avatar và tên người dùng
                    $gender = $row['gender'];
                    $admin = $row['admin'];
                    $avatar_url = "";

                    if ($admin == 1) {
                        if ($gender == 1) {
                            $avatar_url = "image/avatar10.png";
                        } elseif ($gender == 2) {
                            $avatar_url = "image/avatar11.png";
                        } else {
                            $avatar_url = "image/avatar12.png";
                        }
                    } else {
                        if ($gender == 1) {
                            $avatar_url = "image/avatar1.png";
                        } elseif ($gender == 2) {
                            $avatar_url = "image/avatar2.png";
                        } else {
                            $avatar_url = "image/avatar0.png";
                        }
                    }

                    if ($row['ghimbai'] == 1) {
                        // Tiêu đề và avatar của bài viết ghim
                        echo '<div style="width: 40px; float:left; margin-right: 5px;"><img src="' . $avatar_url . '" alt="Avatar" style="width: 35px"></div>';
                        echo '<div class="box-right">';

                        if ($row['admin'] == 1) {
                            // Determine title color based on the value of 'theloai'
                            $titleColor = '';
                            switch ($row['theloai']) {
                                case 0:
                                    $titleColor = 'color: #8B0000; font-weight: bold;'; // Brown color
                                    break;
                                case 1:
                                    $titleColor = 'color: #FF0000; font-weight: bold;'; // Green color
                                    break;
                                case 2:
                                    $titleColor = 'color: #A52A2A; font-weight: bold;'; // Orange color
                                    break;
                                case 3:
                                    $titleColor = 'color: #CD3333; font-weight: bold;'; // Red color
                                    break;
                                default:
                                    $titleColor = ''; // Default color (fallback)
                                    break;
                            }

                            echo '<a href="bai-viet?id=' . $row['id'] . '"><span style="' . $titleColor . '">' . $row['tieude'] . '</span></a>';
                            echo '<div class="box-name" style="font-size: 9px;"> bởi <span class="text-danger font-weight-bold">';
                            echo $row['username'];
                            echo ' <i class="fas fa-star"></i>'; // Icon sao cho quản trị viên
                            echo '</span>';
                        } else {
                            echo '<a href="bai-viet?id=' . $row['id'] . '">' . $row['tieude'] . '</a>';
                            echo '<div class="box-name" style="font-size: 9px;"> bởi ' . $row['username'] . '';
                        }


                        $query2 = "SELECT comments.id, comments.nguoidung, player.account_id, account.admin, account.tichdiem FROM comments INNER JOIN player ON comments.nguoidung = player.name INNER JOIN account ON player.account_id = account.id WHERE comments.post_id = '$post_id' ORDER BY comments.id ASC";
                        $result2 = mysqli_query($conn, $query2);


                        $thao_luan_da_hien_thi = false;
                        $displayed_danh_hieu = false;
                        $first_comment_processed = false;
                        $first_comment_tichdiem = 0;
                        $first_comment_color = "";
                        $first_comment_danh_hieu = "";

                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $tichdiem = $row2['tichdiem'];
                                if ($row2['admin'] == 1 && !$thao_luan_da_hien_thi) {
                                    echo '<span style="color: #212F3C;"> (Admin Đã Tham Gia)</span>';
                                    $thao_luan_da_hien_thi = true;
                                    $displayed_danh_hieu = true;
                                    // Đánh dấu rằng đã hiển thị thông tin của admin
                                    // và không cần hiển thị danh hiệu nữa
                                } elseif ($row2['admin'] != 1) {
                                    if ($tichdiem >= 200) {
                                        $danh_hieu = "(Chuyên Gia Đã Giải Đáp)";
                                        $color = "#800000";
                                    } elseif ($tichdiem >= 100) {
                                        $danh_hieu = "(Người Hỏi Đáp Đã Trả Lời)";
                                        $color = "#A0522D";
                                    } elseif ($tichdiem >= 35) {
                                        $danh_hieu = "(Người Bắt Chuyện Đã Trả Lời)";
                                        $color = "#6A5ACD";
                                    } else {
                                        $danh_hieu = "";
                                    }
                                    if ($danh_hieu !== "" && !$displayed_danh_hieu) {
                                        if (!$first_comment_processed) {
                                            $first_comment_color = $color;
                                            $first_comment_danh_hieu = $danh_hieu;
                                            $first_comment_processed = true;
                                        }
                                    }
                                }
                            }
                            if ($first_comment_danh_hieu !== "" && !$displayed_danh_hieu) {
                                echo '<span style="color:' . $first_comment_color . ' !important"> ' . $first_comment_danh_hieu . '</span>';
                            }
                        }

                        echo '</div></div>';


                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container color-forum2 pt-2">
        <div class="row">
            <div class="col">
                <div class="box-stt">
                    <?php
                    // Tính toán số lượng bài viết
                    $query = "SELECT COUNT(*) AS count FROM posts";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['count'];

                    // Thiết lập giới hạn cho mỗi trang
                    $limit = 20;

                    // Tính toán số lượng trang
                    $total_pages = ceil($count / $limit);

                    // Lấy số trang từ tham số URL
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Xác định vị trí của trang hiện tại trong danh sách các trang
                    $page_position = min(max(1, $page - 1), max(1, $total_pages - 2));

                    // Tính toán giới hạn kết quả truy vấn theo biến $limit và $page
                    $offset = ($page - 1) * $limit;
                    $query = "SELECT posts.*, player.gender, account.admin FROM posts 
          LEFT JOIN player ON posts.username = player.name 
          LEFT JOIN account ON player.account_id = account.id 
          WHERE posts.username = player.name 
          ORDER BY posts.id DESC LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['id'];

                        //lấy  Avatar và tên của người dùng
                        $gender = $row['gender'];
                        $admin = $row['admin'];
                        $avatar_url = "";

                        if ($admin == 1) {
                            if ($gender == 1) {
                                $avatar_url = "image/avatar10.png";
                            } elseif ($gender == 2) {
                                $avatar_url = "image/avatar11.png";
                            } else {
                                $avatar_url = "image/avatar12.png";
                            }
                        } else {
                            if ($gender == 1) {
                                $avatar_url = "image/avatar1.png";
                            } elseif ($gender == 2) {
                                $avatar_url = "image/avatar2.png";
                            } else {
                                $avatar_url = "image/avatar0.png";
                            }
                        }

                        // Tiêu đề và avatar của người dùng
                        echo '<div style="width: 25px; float:left; margin-right: 5px;"><img src="' . $avatar_url . '" alt="Avatar" style="width: 25px"></div>';

                        echo '<div class="box-right">';

                        if ($row['admin'] == 1) {
                            // Determine title color based on the value of 'theloai'
                            $titleColor = '';
                            switch ($row['theloai']) {
                                case 0:
                                    $titleColor = 'color: #8B0000; font-weight: bold;'; // Brown color
                                    break;
                                case 1:
                                    $titleColor = 'color: #FF0000; font-weight: bold;'; // Green color
                                    break;
                                case 2:
                                    $titleColor = 'color: #A52A2A; font-weight: bold;'; // Orange color
                                    break;
                                case 3:
                                    $titleColor = 'color: #CD3333; font-weight: bold;'; // Red color
                                    break;
                                default:
                                    $titleColor = ''; // Default color (fallback)
                                    break;
                            }

                            echo '<a href="bai-viet?id=' . $row['id'] . '"><span style="' . $titleColor . '">' . $row['tieude'] . '</span></a>';
                            echo '<div class="box-name" style="font-size: 9px;"> bởi <span class="text-danger font-weight-bold">';
                            echo $row['username'];
                            echo ' <i class="fas fa-star"></i>'; // Icon sao cho quản trị viên
                            echo '</span>';
                        } else {
                            echo '<a href="bai-viet?id=' . $row['id'] . '">' . $row['tieude'] . '</a>';
                            echo '<div class="box-name" style="font-size: 9px;"> bởi ' . $row['username'] . '';
                        }


                        $query2 = "SELECT comments.id, comments.nguoidung, player.account_id, account.admin, account.tichdiem
            FROM comments 
            INNER JOIN player ON comments.nguoidung = player.name
            INNER JOIN account ON player.account_id = account.id
            WHERE comments.post_id = '$post_id'
            ORDER BY comments.id ASC";

                        $result2 = mysqli_query($conn, $query2);

                        $thao_luan_da_hien_thi = false;
                        $displayed_danh_hieu = false;
                        $first_comment_processed = false;
                        $first_comment_tichdiem = 0;
                        $first_comment_color = "";
                        $first_comment_danh_hieu = "";

                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $tichdiem = $row2['tichdiem'];
                                if ($row2['admin'] == 1 && !$thao_luan_da_hien_thi) {
                                    echo '<span style="color: #212F3C;"> (Admin Đã Tham Gia)</span>';
                                    $thao_luan_da_hien_thi = true;
                                    $displayed_danh_hieu = true;
                                    // Đánh dấu rằng đã hiển thị thông tin của admin
                                    // và không cần hiển thị danh hiệu nữa
                                } elseif ($row2['admin'] != 1) {
                                    if ($tichdiem >= 200) {
                                        $danh_hieu = "(Chuyên Gia Đã Giải Đáp)";
                                        $color = "#800000";
                                    } elseif ($tichdiem >= 100) {
                                        $danh_hieu = "(Người Hỏi Đáp Đã Trả Lời)";
                                        $color = "#A0522D";
                                    } elseif ($tichdiem >= 35) {
                                        $danh_hieu = "(Người Bắt Chuyện Đã Trả Lời)";
                                        $color = "#6A5ACD";
                                    } else {
                                        $danh_hieu = "";
                                    }
                                    if ($danh_hieu !== "" && !$displayed_danh_hieu) {
                                        if (!$first_comment_processed) {
                                            $first_comment_color = $color;
                                            $first_comment_danh_hieu = $danh_hieu;
                                            $first_comment_processed = true;
                                        }
                                    }
                                }
                            }
                            if ($first_comment_danh_hieu !== "" && !$displayed_danh_hieu) {
                                echo '<span style="color:' . $first_comment_color . ' !important"> ' . $first_comment_danh_hieu . '</span>';
                            }
                        }
                        echo '</div></div>';

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container pt-4 pb-1 color-main2">
    <div class="row mt-3">
        <div class="col-5">
            <?php if ($_login == null) { ?>
            <?php } else {
                echo ' <a class="btn btn-sm btn-light" href="dang-bai">Đăng bài mới</a>';
            } ?>
        </div>
        <?php
        echo '<div class="col-7 text-right">';
        echo '<ul class="pagination" style="justify-content: flex-end;">';
        if ($page > 1) {
            echo '<li><a class="btn btn-sm btn-light" href="?page=' . ($page - 1) . '"><</a></li>';
        }
        $start_page = max(1, min($total_pages - 2, $page - 1));
        $end_page = min($total_pages, max(2, $page + 1));
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i >= $start_page && $i <= $end_page) {
                $class_name = "btn btn-sm btn-light";
                if ($i == $page) {
                    $class_name = "btn btn-sm page-active";
                }
                echo '<li><a class="' . $class_name . '" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($page < $total_pages) {
            echo '<li><a class="btn btn-sm btn-light" href="?page=' . ($page + 1) . '">></a></li>';
        }
        echo '</ul>';
        echo '</div>';
        ?>
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
                    </small></div>
            </div>
        </div>
    </div>
</div>
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/main.js"></script>
</body><!-- Bootstrap core JavaScript -->

</html>