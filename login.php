<?php
session_start();

if (isset($_SESSION['id'])) {
  header("Location: index");
}

include_once 'layout/head.php';
require_once 'php/action.php';
require_once 'php/key.inc.php';
?>
<style>
  body {
    font-family: "Kanit", sans-serif;
    font-family: "Noto Sans", sans-serif;
    font-family: "Noto Sans Thai", sans-serif;
    font-family: "Poppins", sans-serif;
    font-family: "Prompt", sans-serif;
  }
</style>


<body>
  <main class="vh-100 p-3 bg-primary-addpay">
    <div class="container py-5 py-sm-4 py-md-5">
      <div class="row d-flex align-items-center justify-content-center h-100 bg-white rounded-5 px-md-5 py-md-4 shadow-lg">
        <!-- content -->
        <div class="col-12 col-md-5 text-center">
          <div class="img p-5 p-md-0">
            <img src="image/logorebg.png" class="img-fluid" alt="Logo-Addpay">
          </div>
          <div class="text-center mb-5">
            <p id="Organize-brand" class="m-0">บริษัท แอดเพย์ เซอร์วิสพอยท์ จำกัด</p>
            <label for="Organize-brand">เปลี่ยนทุกไอเดีย ให้เป็นไอที</label>
          </div>
        </div>

        <!-- line -->
        <hr class="ms-lg-4 ms-md-3 d-lg-flex d-md-flex d-none float-center" style="border:  none;
                  border-left:    2px solid hsla(200, 10%, 50%,100);
                  height:         70vh;
                  width:          1px;">

        <!-- login input -->
        <div class="col-12 col-md-6 px-4 py-4 py-md-0">
          <div class="mb-md-3 mb-lg-3 text-center text-md-start" id="title" name="title">
            <h2>เข้าสู่ระบบ</h2>
          </div>

          <form class="container mt-md-2 mt-lg-2" action="php/action.php" method="post">
            <input type="hidden" name="action" value="login">
            <!-- name input -->
            <div class="row">
              <div class="form-floating col-12 mb-3 mb-md-4 ">
                <input type="text" class="form-control border border-start-0 border-top-0 border-end-0 rounded-0" id="inputUsername" name="inputUsername" placeholder="กรอกชื่อผู้ใช้" value="<?php if (isset($_GET['username'])) {
                                                                                                                                                                                                echo decode($_GET['username'], secret_key());
                                                                                                                                                                                              } ?>">
                <label class="ms-2" for="inputUsername"><i class="fa-solid fa-user"></i> ชื่อผู้ใช้</label>
              </div>
              <!-- Password input -->
              <div class="form-floating col-12 mb-3 mb-md-4">
                <input type="password" class="form-control border border-start-0 border-top-0 border-end-0 rounded-0" id="inputPassword" name="inputPassword" placeholder="กรอกพาสเวิร์ด" value="<?php if (isset($_GET['password'])) {
                                                                                                                                                                                                    echo decode($_GET['password'], secret_key());
                                                                                                                                                                                                  } ?>">
                <label class="ms-2" for="inputPassword"><i class="fa-solid fa-unlock"></i> รหัสผ่าน</label>
              </div>
            </div>
            <!-- Submit button -->
            <div class="form-row mb-3 mb-md-4">
              <div class="d-grid gap-2 col-12 mx-auto">
                <button type="submit" name="submit" class="btn p-3 mt-3 text-white rounded-pill fs-5 fw-bold btn-addpay">เข้าสู่ระบบ <i class="fa-solid fa-right-to-bracket"></i></button>
              </div>
            </div>
            <!-- <p class="text-center"> ยังไม่มีบัญชีผู้ใช้ ?
              <a href="register" class="text-decoration-none">สมัครสมาชิก</a>
            </p> -->
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php
  include_once 'view/alert.php';
  ?>
</body>

</html>