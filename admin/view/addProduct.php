<?php
session_start();
include '../inc/auth.php';
require_once "../../config/db.php";

$sql = "select id , name from categories order by name";
$result = mysqli_query($conn , $sql);

$categories = mysqli_fetch_all($result , MYSQLI_ASSOC);


include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";

?>

<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="row w-100 m-0">
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
      <div class="card col-lg-4 mx-auto">

        <div class="card-body px-5 py-5">
          <?php include '../../inc/errors.php' ?>
          <?php include '../../inc/success.php' ?>

          <?php 

?>
          <h3 class="card-title text-left mb-3">Add Product</h3>
          <form method="POST"
            action="../handle/handleAddProduct.php"
            enctype="multipart/form-data">

            <!-- Category -->
            <div class="form-group">
              <label>Category</label>

              <select name="cat" class="form-control" required>
                <option>Select Category</option>
                <?php foreach($categories as $category) : ?>
                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                  <?php endforeach ?>
            
              </select>
            </div>

            <!-- Title -->
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title"
                class="form-control" required maxlength="155">
            </div>

            <!-- Description -->
            <div class="form-group">
              <label>Description</label>
              <textarea name="desc"
                class="form-control" required></textarea>
            </div>

            <!-- Price -->
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="price"
                step="0.01" min="0.01"
                class="form-control" required>
            </div>

            <!-- Quantity -->
            <div class="form-group">
              <label>Quantity</label>
              <input type="number" name="quantity"
                min="0" step="1"
                class="form-control" required>
            </div>

            <!-- Image -->
            <div class="form-group">
              <label>Product Image</label>
              <input type="file" name="img"
                accept=".jpg,.jpeg,.png,.webp"
                class="form-control" required>
            </div>

            <button type="submit"
              class="btn btn-primary btn-block">
              Add Product
            </button>

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