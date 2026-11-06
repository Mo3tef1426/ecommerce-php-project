
<?php
require_once 'config/db.php';
$id = $_GET['id'] ?? 0;

$sql = "select products.* , categories.name as category_name 
from products 
join categories 
ON products.category_id = categories.id
where products.id = $id";



$result = mysqli_query($conn  , $sql);

$product = mysqli_fetch_assoc($result); 



include 'inc/header.php' 
?>
    <section id="prodeteails" class="section-p1">

        <div class="single-pro-img">
            <img src="admin/upload/products/<?= $product['image'] ?>" width="100%" id="mainImg" alt="">
   

        </div>
        <div class="single-pro-details">
            <h6>Home / <?= $product['category_name'] ?></h6>
            <h4><?= $product['title'] ?></h4>
            <h2> <?= $product['price'] ?>EGP</h2>
            <p>Available Qty : <?= $product['quantity'] ?></p>
        
                <form action="handle/handleAddToCart.php" method="POST">
                    <input type="hidden"
                        name="id"
                        value="<?= $product['id'] ?>">
                    <input type="number"
                        name="quantity"
                        value="1"
                        min="1"
                        max="<?= $product['quantity']?>">
                    <button type="submit" class="normal">
                        Add To Cart
                    </button>
                </form>
            
                <p>Out of Stock</p>
            
            <h4>Product Details</h4>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo animi voluptate dolor aut sed voluptatibus eveniet vel eius perspiciatis natus ipsa consequatur aliquam fugiat quod, inventore deleniti voluptates veritatis magni doloremque rerum sit voluptas adipisci! Eum minus assumenda quaerat repudiandae libero fuga maxime minima doloremque modi numquam expedita, blanditiis iure.</span>
        </div>
    </section>

<?php include 'inc/footer.php' ?>