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
      <div class="col-lg-6 offset-lg-3 pr-5 pl-5">
         <br>
         <br>
         <h4 class="text-center">ĐỔI MẬT KHẨU</h4>
         <?php if ($_login == null) { ?>
            <p>Bạn chưa đăng nhập? Hãy đăng nhập để dùng được chức năng này</p>
         <?php } else {

            $stmt = $conn->prepare("SELECT password, mkc2 FROM account WHERE username=?");
            $stmt->bind_param("s", $_username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $mkc2 = $row['mkc2'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $password = $_POST['password'] ?? '';
               $new_password = $_POST['new_password'] ?? '';
               $new_passwordxacnhan = $_POST['new_password_confirmation'] ?? '';

               if (!empty($mkc2)) {
                  $passwordcap2 = isset($_POST['passwordcap2']) ? $_POST['passwordcap2'] : '';

                  if (!empty($password) && !empty($new_password) && !empty($new_passwordxacnhan) && !empty($passwordcap2)) {
                     // Cập nhật mật khẩu cấp 2 vào database, thông báo
                     if ($password !== $row['password']) {
                        echo "<div class='alert alert-danger'>Sai mật khẩu hiện tại</div>";
                     } elseif ($passwordcap2 !== $mkc2) {
                        echo "<div class='alert alert-danger'>Sai mật khẩu cấp 2</div>";
                     } elseif ($new_password === $password) {
                        echo "<div class='alert alert-danger'>Mật khẩu mới không được giống mật khẩu hiện tại</div>";
                     } elseif ($new_password !== $new_passwordxacnhan) {
                        echo "<div class='alert alert-danger'>Mật khẩu mới không giống nhau</div>";
                     } else {
                        // Cập nhật mật khẩu cấp 2 lên database
                        $stmt = $conn->prepare("UPDATE account SET password=? WHERE username=?");
                        $stmt->bind_param("ss", $new_password, $_username);

                        if ($stmt->execute()) {
                           echo "<div class='alert alert-success'>Cập nhật mật khẩu mới thành công</div>";
                        } else {
                           echo "<div class='alert alert-danger'>Lỗi khi cập nhật mật khẩu cấp 2</div>";
                        }
                     }
                  } else {
                     echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin trong form</div>";
                  }
               } else {
                  if (!empty($password) && !empty($new_password) && !empty($new_passwordxacnhan)) {
                     // Update mật khẩu cấp 2 mới
                     $stmt = $conn->prepare("UPDATE account SET password=? WHERE username=?");
                     $stmt->bind_param("ss", $new_password, $_username);

                     if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Tạo mật khẩu mới thành công</div>";
                        $mkc2 = $new_password; // update the value of mkc2 variable after successful creation
                     } else {
                        echo "<div class='alert alert-danger'>Lỗi khi tạo mật khẩu mới</div>";
                     }
                  } else {
                     echo "<div class='alert alert-danger'>Vui lòng điền đầy đủ thông tin trong form</div>";
                  }
               }
            }
            if (!empty($mkc2)) {
               ?>
               <form method="POST">
                  <div class="mb-3">
                     <label class="font-weight-bold">Mật Khẩu hiện tại:</label>
                     <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu hiện tại"
                        required autocomplete="password">
                  </div>
                  <div class="mb-3">
                     <label class="font-weight-bold">Mật Khẩu Cấp 2:</label>
                     <input type="password" class="form-control" name="passwordcap2" id="passwordcap2"
                        placeholder="Mật khẩu cấp 2" required autocomplete="passwordcap2">
                  </div>
                  <div class="mb-3">
                     <label class="font-weight-bold">Mật Khẩu Mới:</label>
                     <input type="password" class="form-control" name="new_password" id="new_password"
                        placeholder="Mật khẩu mới" required autocomplete="new_password">
                  </div>
                  <div class="mb-3">
                     <label class="font-weight-bold">Xác Nhận Mật Khẩu Mới:</label>
                     <input type="password" class="form-control" name="new_password_confirmation"
                        id="new_password_confirmation" placeholder="Xác nhận mật khẩu mới" required
                        autocomplete="new_password_confirmation">
                  </div>
                  <button class="btn btn-sm btn-main form-control" type="submit">Thực hiện</button>
               </form>
            <?php } else { ?>
               <form method="POST">
                  <div class="mb-3">
                     <label class="font-weight-bold">Mật Khẩu Hiện Tại:</label>
                     <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu hiện tại"
                        required autocomplete="password">
                  </div>
                  <div class="mb-3">
                     <label class="font-weight-bold">Mật Khẩu Mới:</label>
                     <input type="password" class="form-control" name="new_password" id="new_password"
                        placeholder="Mật khẩu mới" required autocomplete="new_password">
                  </div>
                  <div class="mb-3">
                     <label class="font-weight-bold">Nhập Lại Mật Khẩu Mới:</label>
                     <input type="password" class="form-control" name="new_password_confirmation"
                        id="new_password_confirmation" placeholder="Xác nhận mật khẩu mới" required
                        autocomplete="new_password_confirmation">
                  </div>
                  <button class="btn btn-sm btn-main form-control" type="submit">Thực hiện</button>
               </form>
            <?php
            }
         } ?>
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