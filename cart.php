<?php
include 'inc/header.php';

$cart = $_SESSION['cart'] ?? [];
$subTotal = 0 ;
?>
<?php include 'inc/errors.php' ?>
<?php include 'inc/success.php' ?>
<section id="cart" class="section-p1">

    <table width="100%">

        <thead>
            <tr>
                <td>Remove</td>
                <td>Image</td>
                <td>Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Subtotal</td>
            </tr>
        </thead>


        <tbody>






            <?php if (!empty($cart)): ?>
                <?php foreach ($cart as $id => $item) : ?>
                    <?php 
                        
                    $itemTotal = $item['price'] * $item['cart_quantity'];
                    $subTotal += $itemTotal ;      
                    ?>
                    <tr>
                        <td>
                            <form action="handle/handleDeleteCart.php" method="POST">

                                <input type="hidden"
                                    name="id"
                                    value="<?= $id ?>">

                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Remove this product?')">
                                    <i class="far fa-times-circle"></i>
                                </button>

                            </form>
                        </td>

                        <td>
                            <img
                                src="admin/upload/products/<?= $item['image'] ?>"
                                width="80">
                        </td>


                        <td>
                            <?= $item['title'] ?>
                        </td>


                        <td>
                            <?= number_format($item['price'] , 2) ?>
                        </td>


                        <td>


                            <?= $item['cart_quantity'] ?>
                        </td>

                        <td>
                            <?= number_format($itemTotal , 2 ) ?>
                        </td>


                    </tr>
                <?php endforeach ?>
            <?php else: ?>

                <tr>
                    <td colspan="6">
                        Cart Is Empty
                    </td>
                </tr>
            <?php endif; ?>


        </tbody>


    </table>

</section>


<section id="cart-add" class="section-p1">

    <div id="coupon">

        <h3>Coupon</h3>

        <input type="text" placeholder="Enter coupon code">

        <button class="normal">
            Apply
        </button>

    </div>


    <div id="subTotal">

        <h3>Cart totals</h3>

        <table>

            <tr>
                <td>Subtotal</td>
                <td><?= number_format($subTotal , 2 ) ?></td>
            </tr>


            <tr>
                <td>Shipping</td>
                <td>$0.00</td>
            </tr>


            <tr>
                <td>Tax</td>
                <td>$0.00</td>
            </tr>


            <tr>
                <td>
                    <strong>Total</strong>
                </td>

                <td>
                    <strong>
<?= number_format($subTotal  , 2 )?>
                    </strong>
                </td>
            </tr>

        </table>


        <a href="confirmOrder.php" class="btn btn-primary normal">proceed to checkout</a>


    </div>

</section>


<?php include 'inc/footer.php' ?>