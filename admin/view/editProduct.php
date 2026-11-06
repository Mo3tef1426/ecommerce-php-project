<?php
session_start();
include '../inc/auth.php';
require_once '../../config/db.php';


$id = (int) $_GET['id'];

$sql = "select * from products where id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: products.php");
    exit();
}

$categories = mysqli_query(
    $conn,
    'select * from categories'
);



include 'header.php';
include 'sidebar.php';
include 'navbar.php';
?>

<div class="container-fluid page-body-wrapper">
    <div class="row w-100 m-0">
        <div class="content-wrapper">

            <div class="card col-lg-6 mx-auto">
                <div class="card-body">

                    <h3 class="card-title">Edit Product</h3>

                    <?php include '../../inc/errors.php'; ?>
                    <?php include '../../inc/success.php'; ?>

                    <form method="POST"
                        action="../handle/handleEditProduct.php"
                        enctype="multipart/form-data">

                        <input type="hidden"
                            name="id"
                            value="<?= $product['id'] ?>">

                        <!-- Category -->
                        <div class="form-group">
                            <label>Category</label>

                            <select name="cat" class="form-control">
                                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                                    <option value="<?= $category['id'] ?>"
                                        <?php
                                        if ($category['id'] === $product['category_id']) {
                                            echo "selected";
                                        }
                                        ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="form-group">
                            <label>Title</label>

                            <input type="text"
                                name="title"
                                class="form-control"
                                maxlength="155"
                                value="<?= htmlspecialchars($product['title']) ?>">
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label>Description</label>

                            <textarea name="desc"
                                class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label>Price</label>

                            <input type="number"
                                name="price"
                                step="0.01"
                                min="0.01"
                                class="form-control"
                                value="<?= $product['price'] ?>">
                        </div>

                        <!-- Quantity -->
                        <div class="form-group">
                            <label>Quantity</label>

                            <input type="number"
                                name="quantity"
                                min="0"
                                step="1"
                                class="form-control"
                                value="<?= $product['quantity'] ?>">
                        </div>

                        <!-- Image -->
                        <?php if ($product['image']): ?>
                            <div class="form-group">
                                <label>Current Image</label>
                                <div class="mb-3">
                                    <img
                                        src="../upload/products/<?= $product['image'] ?>"
                                        width="120"
                                        alt="Product Image">
                                </div>
                            <?php endif ?>

                            <label>New Image (Optional)</label>

                            <input type="file"
                                name="img"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control">
                            </div>

                            <button type="submit"
                                class="btn btn-primary">
                                Update Product
                            </button>

                            <a href="products.php"
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