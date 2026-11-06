<?php
include 'inc/header.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('location:shop.php');
    exit();
}


if (isset($_POST['confirm_order'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $postalCode = trim($_POST['postal_code']);
    $phone = trim($_POST['phone']);
    $paymentType = $_POST['payment_type'];


    $errors = [];


    if (
        empty($name) ||
        empty($email) ||
        empty($address) ||
        empty($city) ||
        empty($postalCode) ||
        empty($phone)
    ) {
        $errors[] = "All fields are required";
    }


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format";
    }

    if (empty($errors)) {

        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['cart_quantity'];
        }
        $order = [
            'customer' => [
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postalCode,
                'phone' => $phone,
                'payment_type' => $paymentType
            ],
            'products' => $_SESSION['cart'],
            'total' => $total
        ];


        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = [];
        }

        $_SESSION['order'] = $order;
        unset($_SESSION['cart']);

        $_SESSION['success'][] = 'order confirmed';
        header('location:shop.php');
        exit();
    }
}




?>



<section id="cart-add" class="section-p1">

    <div id="coupon">

        <h3>Coupon</h3>

        <input
            type="text"
            name="coupon"
            placeholder="Enter coupon code">

        <button class="normal">
            Apply
        </button>

    </div>


    <div id="subTotal">

        <h3>Confirm Order</h3>


        <form class="col-4" action="confirmOrder.php" method="POST">


            <label>Name</label>
            <input
                type="text"
                name="name">


            <label>Email</label>
            <input
                type="email"
                name="email">


            <label>Address</label>
            <input
                type="text"
                name="address">


            <label>City</label>
            <input
                type="text"
                name="city">


            <label>Postal Code</label>
            <input
                type="number"
                name="postal_code">


            <label>Phone</label>
            <input
                type="text"
                name="phone">


            <label>Payment Type</label>

            <select name="payment_type">

                <option value="Cash_on_Delivery">
                    Cash on Delivery
                </option>

                <option value="Credit_Card">
                    Credit Card
                </option>

                <option value="Fawry">
                    Fawry
                </option>

            </select>


            <button
                class="normal"
                type="submit"
                name="confirm_order">
                Proceed To Checkout
            </button>


        </form>


    </div>

</section>


<?php include 'inc/footer.php'; ?>