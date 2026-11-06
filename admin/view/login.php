<?php
session_start(); 
include "../view/header.php";
// include "../view/sidebar.php";
// include "../view/navbar.php";
include '../../helpers/helper.php';
?>


      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">

              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Admin Login</h3>
                <?php include '../../inc/errors.php' ?>
                <form method="POST" action="../handle/handleLogin.php">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control p_input text-white" value="<?= oldValue('email') ?>">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control p_input">
                  </div>
                  <div class="text-center">
                    <button type="submit" name="login" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

<?php 
include "../view/footer.php";
 ?>