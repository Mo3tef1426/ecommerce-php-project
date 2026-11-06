<?php
session_start();

include '../inc/auth.php';

include 'header.php';
include 'sidebar.php';
include 'navbar.php';
?>

<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">

                <div class="card-body px-5 py-5">

                    <h3 class="card-title mb-3">Add Category</h3>

                    <?php include '../../inc/errors.php'; ?>
                    <?php include '../../inc/success.php'; ?>

                    <form method="POST" action="../handle/handleAddCategory.php">

                        <div class="form-group text-white">
                            <label>Category Name</label>
                            <input type="text" name="name"
                                class="form-control p_input">
                        </div>

                        <div class="form-group text-white">
                            <label>Description</label>
                            <textarea name="description"
                                class="form-control"></textarea>
                        </div>

                        <button type="submit" name="addCategory"
                            class="btn btn-primary btn-block">
                            Add Category
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>