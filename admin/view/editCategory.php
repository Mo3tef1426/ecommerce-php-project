<?php
session_start();

include '../inc/auth.php';

include 'header.php';
include 'sidebar.php';
include 'navbar.php';
?>

<div class="container-fluid page-body-wrapper">
    <div class="row w-100 m-0">
        <div class="content-wrapper">
            <div class="card col-lg-6 mx-auto">

                <div class="card-body">

                    <h3 class="card-title">Edit Category</h3>

                    <?php include '../../inc/errors.php'; ?>
                    <?php include '../../inc/success.php'; ?>

                    <form method="POST"
                          action="../handle/handleEditCategory.php">

                        <input type="hidden"
                               name="id"
                               value="">

                        <div class="form-group">
                            <label>Category Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   maxlength="100"
                                   value="">
                        </div>

                        <div class="form-group">
                            <label>Description</label>

                            <textarea name="description"
                                      class="form-control"></textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Update Category
                        </button>

                        <a href="listCategory.php"
                           class="btn btn-secondary">
                            Back
                        </a>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
