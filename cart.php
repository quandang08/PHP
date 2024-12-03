<!-- File cart.php  -->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="public/css/cart.css">
</head>

<body>
    <?php include "header.php" ?>

    <div class="cart-page">
        <h1>Your Cart</h1>
        <div class="cart-wrapper">
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>X</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr data-id="<?= $item['id'] ?>">
                                    <td><button class="remove-btn" data-id="<?= $item['id'] ?>">X</button></td>
                                    <td>
                                        <div class="product-info">
                                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img">
                                            <span><?= htmlspecialchars($item['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="price" data-price="<?= $item['price'] ?>">
                                        <?= number_format($item['price'], 3) ?>₫
                                    </td>
                                    <td>
                                        <input type="number" class="quantity" value="<?= $item['quantity'] ?>" min="1" data-id="<?= $item['id'] ?>">
                                    </td>
                                    <td class="subtotal">
                                        <?= number_format($item['price'] * $item['quantity'], 3) ?>₫
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Your cart is empty!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <h3>Cart totals</h3>
                <?php
                $subtotal = 0;
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach ($_SESSION['cart'] as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                }
                ?>
                <p>Subtotal: <span id="subtotal"><?= number_format($subtotal, 3, ',', '.') ?>₫</span></p>
                <p>Total: <span id="total"><?= number_format($subtotal, 3, ',', '.') ?>₫</span></p>
                <button class="checkout-btn">Proceed to checkout</button>
            </div>
        </div>
    </div>

    <script src="public/js/cart.js"></script>
</body>

</html>
