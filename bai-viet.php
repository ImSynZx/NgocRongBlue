<?php
ob_start();
include_once 'connect.php';
include_once 'set.php';
if (isset($_POST['username'])) {
    $_username = $_POST['username'];
}
include('head.php');
?>
<div class="container color-main2 pb-3">
    <div class="row">
        <div class="container color-main pt-2">
            <div class="row">
                <div class="col"> <a href="index" style="color: white">Quay lại diễn đàn</a> </div>
            </div>
        </div>
        <br>
        <br>
        <div class="container pt-5 pb-5">
            <div class="row">
                <table cellpadding="0" cellspacing="0" width="99%" style="font-size: 13px;">
                    <tbody>
                        <tr>
                            <td width="60px;" style="vertical-align: top">
                                <div class="text-center" style="margin-left: -10px;">
                                    <br>
                                    <div style="font-size: 9px; padding-top: 5px">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            // Xử lý lấy thông tin bài viết từ CSDL
                                            $post_id = $_GET['id'];
                                            $query = "SELECT posts.*, player.gender, account.tichdiem, account.admin, posts.image FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                                            $result = mysqli_query($conn, $query);

                                            if ($row = mysqli_fetch_assoc($result)) {
                                                $gender = $row['gender'];
                                                $hanhtinh = $row['gender'];
                                                $tichdiem = $row['tichdiem'];

                                                //lấy  Avatar và tên của người dùng
                                                $admin = $row['admin'];
                                                $avatar_url = "";

                                                if ($admin == 1) {
                                                    if ($gender == 1) {
                                                        $avatar_url = "image/avatar11.png";
                                                    } elseif ($gender == 2) {
                                                        $avatar_url = "image/avatar12.png";
                                                    } else {
                                                        $avatar_url = "image/avatar13.png";
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

                                                $name_hanhtinh = "";
                                                if ($hanhtinh == 1) {
                                                    $name_hanhtinh = "(Namec)";
                                                } elseif ($hanhtinh == 2) {
                                                    $name_hanhtinh = "(Xayda)";
                                                } else {
                                                    $name_hanhtinh = "(Trái Đất)";
                                                }
                                                $color = "";
                                                if ($tichdiem >= 200) {
                                                    $danh_hieu = "(Chuyên Gia)";
                                                    $color = "#800000"; // sets color to red
                                                } elseif ($tichdiem >= 100) {
                                                    $danh_hieu = "(Hỏi Đáp)";
                                                    $color = "#A0522D"; // sets color to yellow
                                                } elseif ($tichdiem >= 35) {
                                                    $danh_hieu = "(Người Bắt Chuyện)";
                                                    $color = "#6A5ACD";
                                                } else {
                                                    $danh_hieu = "";
                                                    $color = "";
                                                }

                                                echo '<div class="text-center"><img src="' . $avatar_url . '" alt="Avatar" style="width: 30px"><br></div>';
                                                if ($row['admin'] == 1) {
                                                    echo '<span class="text-danger font-weight-bold">' . $row['username'] . '</span><br>';
                                                    echo '<span class="text-danger pt-1 mb-0">(Admin)</span>';
                                                    echo '<div style="font-size: 8px">Điểm:' . $tichdiem;
                                                } else {
                                                    echo '<div style="font-size: 9px; padding-top: 5px">' . $row['username'] . '</div>';
                                                    if ($danh_hieu !== "") {
                                                        echo '<div style="font-size: 9px; padding-top: 5px"><span style="color:' . $color . ' !important">' . $danh_hieu . '</span></div>';
                                                    }
                                                    echo '<div style="font-size: 8px">Điểm:' . $tichdiem;
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '<td class="bg bg-light" style=" border-radius: 7px">';
                                                echo '<div class="row" style="padding: 0 7px 15px 7px">';
                                                $created_at = strtotime($row['created_at']);
                                                $now = time();
                                                $time_diff = $now - $created_at;
                                                echo '<div class="col"><div style="font-size: 9px; padding-top: 5px">';
                                                if ($time_diff < 60) {
                                                    echo $time_diff . ' giây trước';
                                                } elseif ($time_diff < 3600) {
                                                    echo floor($time_diff / 60) . ' phút trước';
                                                } elseif ($time_diff < 86400) {
                                                    echo floor($time_diff / 3600) . ' giờ trước';
                                                } elseif ($time_diff < 2592000) {
                                                    echo floor($time_diff / 86400) . ' ngày trước';
                                                } elseif ($time_diff < 31536000) {
                                                    echo floor($time_diff / 2592000) . ' tháng trước';
                                                } else {
                                                    echo floor($time_diff / 31536000) . ' năm trước';
                                                }
                                                echo '</div>';

                                                echo '<div class="col"><span class="font-weight-bold">' . $row['tieude'] . '</span>';
                                                echo '<br>';
                                                echo '<span style="white-space: pre-wrap;">';
                                                $noidung = $row['noidung'];
                                                // Biểu thức chính quy để tìm kiếm các URL có hoặc không có "http://" hoặc "https://"
                                                $pattern = '/(https?:\/\/[^\s]+)/';
                                                $replacement = '<a href="$1" target="_blank">$1</a>';
                                                $noidung = preg_replace($pattern, $replacement, $noidung);
                                                echo $noidung;
                                                echo '</span><br>';
                                                $image_filenames = json_decode($row['image'], true); // Chuyển đổi chuỗi JSON thành mảng
                                        
                                                if (is_array($image_filenames) && !empty($image_filenames)) {
                                                    foreach ($image_filenames as $image_filename) {
                                                        $image_path = "uploads/" . $image_filename; // Đường dẫn đến thư mục chứa ảnh
                                                        // Kiểm tra nếu tệp tồn tại trong thư mục image
                                                        if (file_exists($image_path)) {
                                                            echo '<div class="pt-3"><img class="img-thumbnail" src="' . $image_path . '" alt="Ảnh" style="max-width: 100%; height: auto;"></div><br><br>';
                                                        } else {
                                                            echo 'Không tìm thấy hình ảnh';
                                                        }
                                                    }
                                                }

                                            }
                                            ?>
                                            <style>
                                                img {
                                                    vertical-align: middle;
                                                    overflow-clip-margin: content-box;
                                                    overflow: clip;
                                                }

                                                .pt-3,
                                                .py-3 {
                                                    padding-top: 1rem !important;
                                                }

                                                .img-thumbnail {
                                                    display: inline-block;
                                                    padding: 0;
                                                    max-width: 100%;
                                                    height: auto;
                                                    border-radius: 10px;
                                                    /* Đặt giá trị radius để bo tròn khung */
                                                    overflow: hidden;
                                                    /* Ẩn phần ảnh vượt quá khung */
                                                }

                                                .img-thumbnail .img-container {
                                                    position: relative;
                                                }

                                                .img-thumbnail img {
                                                    display: block;
                                                    width: 100%;
                                                    height: auto;
                                                    border-radius: 10px;
                                                    /* Đặt giá trị radius để bo tròn ảnh bên trong khung */
                                                }

                                                .img-thumbnail::after {
                                                    content: '';
                                                    position: absolute;
                                                    top: 0;
                                                    left: 0;
                                                    right: 0;
                                                    bottom: 0;
                                                    border: 3px solid #dee2e6;
                                                    /* Đặt màu và độ rộng của viền ảnh */
                                                    border-radius: 10px;
                                                    /* Đặt giá trị radius để bo tròn viền ảnh */
                                                    z-index: -1;
                                                    /* Đẩy lớp viền xuống phía dưới ảnh */
                                                }
                                            </style>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            // Xử lý sự kiện khi nút chỉnh sửa được nhấn
            document.getElementById("editButton").addEventListener("click", function () {
                // Chuyển hướng người dùng đến trang chỉnh sửa bài viết
                window.location.href = "sua_baiviet.php?id=<?php echo $post_id; ?>";
            });
        </script>


        <?php
        // query the `comments` table to retrieve all comments for the current post, along with the author name
        $query = "SELECT nguoidung, traloi, created_at, gender FROM comments WHERE post_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);

        // retrieve post information based on the id parameter in the URL
    
        ?>
        <div class="container pt-5 pb-5">
            <?php foreach ($comments as $comment): ?>
                <div class="row pt-3">
                    <div class="col-md-12">
                        <table cellpadding="0" cellspacing="0" width="99%" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td width="60px;" style="vertical-align: top">
                                        <div class="text-center" style="margin-left: -10px;">
                                            <div style="font-size: 9px; padding-top: 5px">
                                                <?php
                                                //lấy  Avatar và tên của người dùng
                                                $gender = $row['gender'];
                                                $admin = $row['admin'];
                                                $avatar_url = "";

                                                if ($admin == 1) {
                                                    if ($gender == 1) {
                                                        $avatar_url = "image/avatar11.png";
                                                    } elseif ($gender == 2) {
                                                        $avatar_url = "image/avatar12.png";
                                                    } else {
                                                        $avatar_url = "image/avatar13.png";
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

                                                $nguoidung = $comment['nguoidung'];
                                                $sql = "SELECT account.tichdiem FROM account INNER JOIN player ON player.account_id = account.id WHERE player.name = '$nguoidung'";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    $tichdiem = intval($row['tichdiem']);
                                                } else {
                                                    $tichdiem = 0;
                                                }
                                                ?>
                                                <img src="<?php echo $avatar_url; ?>" alt="Avatar" style="width: 30px">
                                                <p>
                                                    <?php
                                                    $query = "SELECT DISTINCT posts.*, account.admin, player.account_id FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.username = '$nguoidung' ORDER BY posts.id DESC";
                                                    $result2 = mysqli_query($conn, $query);

                                                    // Hiển thị thông tin tài khoản và danh sách bài viết
                                                    $admins_displayed = array();
                                                    $has_admin = false; // Khởi tạo biến 'has_admin' với giá trị mặc định là false
                                            
                                                    while ($row = mysqli_fetch_assoc($result2)) {
                                                        if ($row['admin'] == 1 && !in_array($row['account_id'], $admins_displayed)) {
                                                            // echo '<span class="text-danger pt-1 mb-0">(Admin)</span><br> ';
                                                            $admins_displayed[] = $row['account_id'];
                                                            $has_admin = true; // Nếu có giá trị 'admin' bằng 1, gán giá trị true cho biến 'has_admin'
                                                        }
                                                    }
                                                    $color = "";
                                                    if ($tichdiem >= 200) {
                                                        $danh_hieu = "(Chuyên Gia)";
                                                        $color = "#800000"; // sets color to red
                                                    } elseif ($tichdiem >= 100) {
                                                        $danh_hieu = "(Hỏi Đáp)";
                                                        $color = "#A0522D"; // sets color to yellow
                                                    } elseif ($tichdiem >= 35) {
                                                        $danh_hieu = "(Người Bắt Chuyện)";
                                                        $color = "#6A5ACD";
                                                    } else {
                                                        $danh_hieu = "";
                                                        $color = "";
                                                    }
                                                    if ($has_admin) {
                                                        // Nếu tìm thấy giá trị 'admin' bằng 1 trong vòng lặp while, hiển thị tên người dùng với chữ màu đỏ
                                                        echo '<span class="text-danger font-weight-bold">' . $nguoidung . '</span><br>';
                                                        echo '<span class="text-danger pt-1 mb-0">(Admin)</span><br>';
                                                    } else {
                                                        // Nếu không tìm thấy giá trị 'admin' bằng 1 hoặc biến $row không tồn tại, hiển thị tên người dùng với chữ màu đen.
                                                        echo '<span>' . $nguoidung . '</span><br>';
                                                        if ($danh_hieu !== "") {
                                                            echo '<span style="color:' . $color . ' !important">' . $danh_hieu . '</span><br>';
                                                        }
                                                    }

                                                    echo '<span style="font-size: 8px">Điểm: ' . $tichdiem . '</span>';
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="bg bg-light" style="border-radius: 7px">
                                        <div class="row" style="padding: 0 7px 15px 7px">
                                            <div class="col">
                                                <small>
                                                    <?php
                                                    $created_at = strtotime($comment['created_at']);
                                                    $now = time();
                                                    $time_diff = $now - $created_at;
                                                    if ($time_diff < 60) {
                                                        echo $time_diff . ' giây trước';
                                                    } elseif ($time_diff < 3600) {
                                                        echo floor($time_diff / 60) . ' phút trước';
                                                    } elseif ($time_diff < 86400) {
                                                        echo floor($time_diff / 3600) . ' giờ trước';
                                                    } elseif ($time_diff < 2592000) {
                                                        echo floor($time_diff / 86400) . ' ngày trước';
                                                    } elseif ($time_diff < 31536000) {
                                                        echo floor($time_diff / 2592000) . ' tháng trước';
                                                    } else {
                                                        echo floor($time_diff / 31536000) . ' năm trước';
                                                    }
                                                    ?>
                                                </small>
                                                <br>
                                                <span>
                                                    <?php echo $comment['traloi']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            if ($_login == null) {
                ?>
            </div>
            <?php
            } else { // Lấy id bài viết từ URL
                $post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                // Tính toán số lượng comment cho bài viết hiện tại
                $query = "SELECT COUNT(*) AS count FROM comments WHERE post_id = '$post_id'";
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

                // Hiển thị pagination
                echo '<div class="col-5 text-right">';
                echo '<ul class="pagination justify-content-end">';
                if ($page > 1) {
                    echo '<li><a class="btn btn-sm btn-light" href="bai-viet?id=' . $post_id . '&page=' . ($page - 1) . '"><</a></li>';
                }
                $start_page = max(1, min($total_pages - 2, $page - 1));
                $end_page = min($total_pages, max(2, $page + 1));
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i >= $start_page && $i <= $end_page) {
                        $class_name = "btn btn-sm btn-light";
                        if ($i == $page) {
                            $class_name = "btn btn-sm page-active";
                        }
                        echo '<li><a class="' . $class_name . '" href="bai-viet?id=' . $post_id . '&page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($page < $total_pages) {
                    echo '<li><a class="btn btn-sm btn-light" href="bai-viet?id=' . $post_id . '&page=' . ($page + 1) . '">></a></li>';
                }
                echo '</ul>';
                echo '</div>';
                ?>

        </div>
        <div class="border-secondary border-top"></div><br>
        <table cellpadding="0" cellspacing="0" width="99%" style="font-size: 13px;">
            <tbody>
                <tr>
                    <td width="55px;" style="vertical-align: top">
                        <div class="text-left" style="display: block;">
                            <?php
                            $query = "SELECT posts.*, account.admin FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                            $result = mysqli_query($conn, $query);

                            if ($row = mysqli_fetch_assoc($result)) {
                                if ($row['trangthai'] == 0):
                                    // Lấy tên người dùng từ cơ sở dữ liệu
                                    $sql = "SELECT player.name, player.gender, account.admin FROM player INNER JOIN account ON account.id = player.account_id WHERE account.username='$_username'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);

                                    // Hiển thị ảnh đại diện và tên người dùng
                                    if (isset($row['gender'])) {
                                        //lấy  Avatar và tên của người dùng
                                        $gender = $row['gender'];
                                        $admin = $row['admin'];
                                        $avatar_url = "";

                                        if ($admin == 1) {
                                            if ($gender == 1) {
                                                $avatar_url = "image/avatar11.png";
                                            } elseif ($gender == 2) {
                                                $avatar_url = "image/avatar12.png";
                                            } else {
                                                $avatar_url = "image/avatar13.png";
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
                                        echo '<img src="' . $avatar_url . '" alt="Avatar" style="width: 30px">';
                                    }


                                endif;
                            }
                            ?>
                            <br>
                        </div>
                    </td>
                    <td style="border-radius: 7px">
                        <div class="row">
                            <div class="col">
                                <?php
                                $query = "SELECT posts.*, player.name FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                                $result = mysqli_query($conn, $query);

                                if ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['trangthai'] == 0) {
                                        ?>
                                        <form id="form" method="POST">
                                            <div class="form-group">
                                                <textarea class="form-control" type="text" name="traloi" id="traloi"
                                                    placeholder="Nhập bình luận của bạn..." required></textarea>
                                                <span id="notify" class="text-danger"></span>
                                            </div>
                                            <button class="btn btn-main btn-sm" id="btn-cmt" type="submit">Bình
                                                luận</button>
                                        </form>
                                        <?php
                                    }
                                }

                                $query2 = "SELECT account.*, account.admin FROM account LEFT JOIN player ON player.account_id = account.id WHERE account.admin = 1";
                                $result2 = mysqli_query($conn, $query2);

                                if ($row2 = mysqli_fetch_assoc($result2)) {
                                    if ($row2['admin'] == 1) {
                                        // Kiểm tra xem tài khoản hiện tại có quyền admin hay không
                                        if (isset($_SESSION['id'])) {
                                            $current_user_id = $_SESSION['id'];
                                            $admin_query = "SELECT admin FROM account WHERE id = $current_user_id";
                                            $admin_result = mysqli_query($conn, $admin_query);
                                            $admin_row = mysqli_fetch_assoc($admin_result);

                                            if ($admin_row['admin'] == 1) {
                                                ?>
                                                <form method="POST">
                                                    <button class="btn btn-main btn-sm" id="btn-delete" name="delete_post" type="submit">Xoá
                                                        Bài</button>
                                                    <button class="btn btn-main btn-sm" id="btn-pin" name="pin_post" type="submit">Ghim
                                                        Bài</button>
                                                    <button class="btn btn-main btn-sm" id="btn-delete-pin" name="delete_pin_post"
                                                        type="submit">Bỏ Ghim</button>
                                                    <button class="btn btn-main btn-sm" id="btn-block-comments" name="block_comments"
                                                        type="submit">Khoá Bình Luận</button>
                                                    <button class="btn btn-main btn-sm" id="btn-unlock-comments" name="unlock_comments"
                                                        type="submit">Mở Bình Luận</button>
                                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                                </form>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
                                ob_start(); // start buffering output
                        
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    if (isset($_POST['traloi'])) {
                                        // Xử lý bình luận
                                        require_once('connect.php');

                                        // Clean the input
                                        $comment = filter_var($_POST['traloi'], FILTER_SANITIZE_STRING);

                                        // Check if $_GET['id'] is set and sanitize it
                                        if (isset($_GET['id'])) {
                                            $id = intval($_GET['id']);

                                            // Prepare the select statement to retrieve user info
                                            $select_stmt = $conn->prepare("SELECT player.name, player.gender, player.account_id, account.admin FROM player INNER JOIN account ON account.id = player.account_id WHERE account.username = ?");
                                            $select_stmt->bind_param("s", $_username);
                                            $select_stmt->execute();
                                            $result = $select_stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                // Retrieve the user's name, gender, account ID, and admin status
                                                $row = $result->fetch_assoc();

                                                // Increment the "tichdiem" field in the "account" table
                                                $update_stmt = $conn->prepare("UPDATE account SET tichdiem = tichdiem + 1 WHERE id = ?");
                                                $update_stmt->bind_param("i", $row['account_id']);
                                                $update_stmt->execute();

                                                // Prepare the insert statement
                                                $insert_stmt = $conn->prepare("INSERT INTO comments (post_id, nguoidung, gender, traloi) VALUES (?, ?, ?, ?)");
                                                // Bind the parameters and execute the statement
                                                $insert_stmt->bind_param("isss", $id, $row['name'], $row['gender'], $comment);
                                                if ($insert_stmt->execute()) {
                                                    // Query the database for the updated post and retrieve it
                                                    $select_post = $conn->prepare("SELECT * FROM posts WHERE id = ?");
                                                    $select_post->bind_param("i", $id);
                                                    $select_post->execute();
                                                    $post_result = $select_post->get_result();

                                                    if ($post_result->num_rows > 0) {
                                                        $post = $post_result->fetch_assoc();
                                                        header("Location: /bai-viet?id=" . $post['id']);
                                                        exit();
                                                    } else {
                                                        echo "Error: Post not found.";
                                                    }
                                                } else {
                                                    echo "Error: Failed to insert into comments table.";
                                                }
                                            } else {
                                                // Handle errors if the name, gender, account ID, or admin status is not found
                                                echo "Error: Name, gender, account ID, or admin status not found.";
                                            }
                                        } else {
                                            // Handle errors if $_GET['id'] is not set
                                            echo "Error: ID not set.";
                                        }
                                    } elseif (isset($_POST['delete_post'])) {
                                        // Xử lý khi người dùng nhấn vào nút "Xoá Bài"
                                        require_once('connect.php');

                                        // Lấy id bài viết từ $_GET hoặc $_POST
                                        $post_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['post_id']);

                                        // Kiểm tra xem người dùng có quyền xoá bài không
                                        $query = "SELECT posts.*, account.admin FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                                        $result = mysqli_query($conn, $query);

                                        if ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['admin'] == 1) {
                                                // Xoá bài viết
                                                $delete_comments_query = "DELETE FROM comments WHERE post_id = $post_id";
                                                $delete_posts_query = "DELETE FROM posts WHERE id = $post_id";

                                                // Thực hiện xoá các comment của bài viết
                                                if (mysqli_query($conn, $delete_comments_query)) {
                                                    // Xoá bài viết sau khi xoá các comment thành công
                                                    if (mysqli_query($conn, $delete_posts_query)) {
                                                        header("Location:/index"); // Chuyển hướng về trang chủ hoặc trang danh sách bài viết
                                                        exit();
                                                    } else {
                                                        echo "Error: Failed to delete post.";
                                                    }
                                                } else {
                                                    echo "Error: Failed to delete comments.";
                                                }
                                            } else {
                                                echo "Error: You don't have permission to delete this post.";
                                            }
                                        } else {
                                            echo "Error: Post not found.";
                                        }
                                    } elseif (isset($_POST['pin_post'])) {
                                        // Xử lý khi người dùng nhấn vào nút "Ghim Bài"
                                        require_once('connect.php');

                                        // Lấy id bài viết từ $_GET hoặc $_POST
                                        $post_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['post_id']);

                                        // Kiểm tra xem người dùng có quyền ghim bài không
                                        $query = "SELECT posts.*, account.admin FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                                        $result = mysqli_query($conn, $query);

                                        if ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['admin'] == 1) {
                                                // Ghim bài viết
                                                $pin_query = "UPDATE posts SET ghimbai = 1 WHERE id = $post_id";
                                                if (mysqli_query($conn, $pin_query)) {
                                                    header("Location: /bai-viet?id=" . $post_id); // Chuyển hướng về trang bài viết
                                                    exit();
                                                } else {
                                                    echo "Error: Failed to pin post.";
                                                }
                                            } else {
                                                echo "Error: You don't have permission to pin this post.";
                                            }
                                        } else {
                                            echo "Error: Post not found.";
                                        }
                                    } elseif (isset($_POST['delete_pin_post'])) {
                                        // Xử lý khi người dùng nhấn vào nút "Bỏ Ghim"
                                        require_once('connect.php');

                                        // Lấy id bài viết từ $_GET hoặc $_POST
                                        $post_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['post_id']);

                                        // Kiểm tra xem người dùng có quyền bỏ ghim bài không
                                        $query = "SELECT posts.*, account.admin FROM posts LEFT JOIN player ON posts.username = player.name LEFT JOIN account ON player.account_id = account.id WHERE posts.id = $post_id";
                                        $result = mysqli_query($conn, $query);

                                        if ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['admin'] == 1) {
                                                // Bỏ ghim bài viết
                                                $unpin_query = "UPDATE posts SET ghimbai = 0 WHERE id = $post_id";
                                                if (mysqli_query($conn, $unpin_query)) {
                                                    header("Location: /bai-viet?id=" . $post_id); // Chuyển hướng về trang bài viết
                                                    exit();
                                                } else {
                                                    echo "Error: Failed to unpin post.";
                                                }
                                            } else {
                                                echo "Error: You don't have permission to unpin this post.";
                                            }
                                        } else {
                                            echo "Error: Post not found.";
                                        }
                                    } elseif (isset($_POST['block_comments'])) {
                                        // Kiểm tra quyền khoá bình luận (ví dụ: kiểm tra quyền admin)
                        
                                        // Lấy ID bài viết từ $_GET hoặc $_POST
                                        $post_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['post_id']);

                                        // Thực hiện câu truy vấn SQL để cập nhật cột "trangthai" của bài viết thành 1 (đã khoá bình luận)
                                        $update_query = "UPDATE posts SET trangthai = 1 WHERE id = $post_id";
                                        if (mysqli_query($conn, $update_query)) {
                                            header("Location: /bai-viet?id=" . $post_id); // Chuyển hướng về trang bài viết
                                            exit();
                                        } else {
                                            echo "Error: Failed to block comments.";
                                        }
                                    } elseif (isset($_POST['unlock_comments'])) {
                                        // Kiểm tra quyền khoá bình luận (ví dụ: kiểm tra quyền admin)
                        
                                        // Lấy ID bài viết từ $_GET hoặc $_POST
                                        $post_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['post_id']);

                                        // Thực hiện câu truy vấn SQL để cập nhật cột "trangthai" của bài viết thành 1 (đã khoá bình luận)
                                        $update_query = "UPDATE posts SET trangthai = 0 WHERE id = $post_id";
                                        if (mysqli_query($conn, $update_query)) {
                                            header("Location: /bai-viet?id=" . $post_id); // Chuyển hướng về trang bài viết
                                            exit();
                                        } else {
                                            echo "Error: Failed to block comments.";
                                        }
                                    }
                                }

                                ob_end_flush();
                                ?>
                                <script>
                                    const form = document.querySelector('#form'); const submitBtn = form.querySelector('#btn-cmt'); const submitError = form.querySelector('#notify'); const traloiInput = document.getElementById('traloi');
                                    form.addEventListener('submit', (event) => {
                                        const traloi = traloiInput.value.trim().length;
                                        if (traloi < 1) {
                                            event.preventDefault();
                                            submitError.innerHTML = '<strong>Lỗi:</strong> Bình luận phải có ít nhất 1 ký tự!'; submitError.style.display = 'block'; submitBtn.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                        }
                                    });
                                    traloiInput.addEventListener('keydown', (event) => { if (event.keyCode === 13 && !event.shiftKey) { event.preventDefault(); submitBtn.click(); } });
                                </script>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        </div>
        </div>
        <?php
            }
                                        }
                                        ?>
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