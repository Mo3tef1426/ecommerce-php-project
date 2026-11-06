<?php
session_start();
require_once '../../config/db.php';

//get all categories
$sql = "select * from categories order by id desc";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);


// echo "<pre>";
// print_r($data);
// echo "</pre>";

// echo count($data);
include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";


?>



<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">

                <div class="card-body px-5 py-5">
                    <h3 class="card-title text-left mb-3">All Categories</h3>


                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">desc</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($data) > 0) :  ?>
                                <?php foreach ($data as $category) : ?>
                                    <tr>
                                        <th scope="row"><?= $category['id'] ?></th>
                                        <td><?= $category['name'] ?></td>
                                        <td><?= $category['description'] ?></td>

                                        <td class="text-end">
                                            <a
                                                class="btn btn-sm btn-outline-primary me-2"
                                                href="editCategory.php">
                                                Edit
                                            </a>
                                            <a
                                                class="btn btn-sm btn-outline-danger me-2"
                                                href="deleteCategory.php">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>

                                <tr>
                                    <td colspan="3" class="text-center">
                                        No categories found
                                    </td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>

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