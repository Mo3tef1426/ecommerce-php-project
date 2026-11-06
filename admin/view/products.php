<?php
session_start();
require_once '../../config/db.php';

$sql = "select products.* , categories.name as category_name 
from products 
join categories 
ON products.category_id = categories.id 
order by products.id desc
";

$result = mysqli_query($conn, $sql);
include 'header.php';
include 'sidebar.php';
include 'navbar.php';
?>

<div class="container-fluid page-body-wrapper">
    <div class="row w-100 m-0">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">

                    <h3 class="card-title">All Products</h3>

                    <?php include '../../inc/errors.php'; ?>
                    <?php include '../../inc/success.php'; ?>

                    <a href="addProduct.php"
                        class="btn btn-success mb-3">
                        Add Product
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php while ($product = mysqli_fetch_assoc($result)): ?>

                                    <tr>
                                        <td><?= $product['id'] ?></td>

                                        <td>

                                            <img
                                                src="../upload/products/<?= htmlspecialchars($product['image']) ?>"
                                                width="70"
                                                alt="Product">

                                        </td>

                                        <td>
                                            <?= htmlspecialchars($product['title']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($product['category_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($product['price']) ?> EGP
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($product['quantity']) ?>
                                        </td>

                                        <td>
                                            <a href="editProduct.php?id=<?= $product['id'] ?>"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>
                                            <form action="../handle/handleDeleteProduct.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                <button type="submit" name="delete" class="btn btn-danger"

                                                >Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php endwhile; ?>

                                <?php if ($result->num_rows == 0) : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No products found
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>