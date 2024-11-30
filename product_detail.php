<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/product_detail.css">
    <title>Product Detail</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Ẩn các nút tăng giảm mặc định */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Container chính */
    .product-detail-container {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    /* Cột trái - Hình ảnh */
    .product-main-image {
        flex: 1;
        max-width: 600px;
        overflow: hidden;
        border-radius: 10px;
    }

    .product-main-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .product-main-image:hover img {
        transform: scale(1.05);
    }

    /* Cột phải - Thông tin sản phẩm */
    .product-info {
        flex: 1;
        max-width: 600px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-title {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.6rem;
        color: #d9534f;
        font-weight: bold;
    }

    .product-price .original-price {
        text-decoration: line-through;
        color: #777;
    }

    .product-short-description {
        font-size: 1.2rem;
        color: #555;
    }

    .product-short-description ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .product-short-description li {
        margin-bottom: 10px;
    }

    /* Nút điều khiển số lượng */
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-button {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        background-color: #e0e0e0;
        padding: 8px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .quantity-button:hover {
        background-color: #007bff;
        color: white;
    }

    .input-quantity {
        text-align: center;
        font-size: 1.2rem;
        width: 60px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }

    .input-quantity:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Nút "Add to Cart" */
    .add-to-cart-button {
        background-color: #000000;
        color: white;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        border-radius: 5px;
        transition: background-color 0.3s ease-in-out;
        width: 100%;
    }

    .add-to-cart-button:hover {
        background-color: #007bff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .product-detail-container {
            flex-direction: column;
            align-items: center;
        }

        .product-main-image,
        .product-info {
            max-width: 100%;
        }

        .quantity-control {
            min-width: 150px;
        }
    }
</style>

<body>
    <!-- header  -->
    <?php include "header.php" ?>
    <!-- end header  -->

    <div class="product-detail-container">
        <!-- Phần trái: Hình ảnh sản phẩm -->
        <div class="product-main-image">
            <img src="https://websitedemos.net/electronic-store-04/wp-content/uploads/sites/1055/2022/03/electronic-store-product-image-9.jpg" alt="Product Image" width="600" height="600">
        </div>

        <!-- Phần phải: Thông tin sản phẩm -->
        <div class="product-info">
            <nav class="breadcrumb-navigation" aria-label="Breadcrumb">
                <a href="https://websitedemos.net/electronic-store-04">Home</a>&nbsp;/&nbsp;
                <a href="https://websitedemos.net/electronic-store-04/product-category/air-conditioner/">Air conditioner</a>&nbsp;/&nbsp;
                Air Conditioner 5000 BTU, Efficient Cooling for Smaller Areas Like Bedrooms and Guest Rooms
            </nav>
            <h1 class="product-title">Air Conditioner 5000 BTU, Efficient Cooling for Smaller Areas Like Bedrooms and Guest Rooms</h1>
            <p class="product-price">
                <del aria-hidden="true">
                    <span class="original-price">
                        <bdi><span class="currency-symbol">$</span>159.00</bdi>
                    </span>
                </del>
                <ins aria-hidden="true">
                    <span class="discounted-price">
                        <bdi><span class="currency-symbol">$</span>139.00</bdi>
                    </span>
                </ins>
            </p>

            <div class="product-short-description">
                <p><strong>Key features</strong></p>
                <ul>
                    <li>Newest technology</li>
                    <li>Best in class components</li>
                    <li>Dimensions - 69.5 x 75.0 x 169.0</li>
                    <li>Maintenance free</li>
                    <li>12 years warranty</li>
                </ul>
            </div>

            <!-- Điều chỉnh vị trí phần điều khiển số lượng và nút Add to cart -->
            <div class="add-to-cart-wrapper">
                <form class="add-to-cart-form" action="cart.php" method="post">
                    <!-- Input hidden để gửi thông tin sản phẩm -->
                    <input type="hidden" name="product_id" value="1"> <!-- ID sản phẩm -->
                    <input type="hidden" name="product_name" value="Air Conditioner 5000 BTU">
                    <input type="hidden" name="product_price" value="139.00">
                    
                    <!-- Điều chỉnh số lượng -->
                    <div class="quantity-control">
                        <span class="quantity-button" id="decrease-quantity">-</span>
                        <input type="number" id="quantity-input" class="input-quantity" name="quantity" value="1" min="1" aria-label="Product quantity">
                        <span class="quantity-button" id="increase-quantity">+</span>
                    </div>
                    <!-- Nút thêm vào giỏ hàng -->
                    <button type="submit" name="add-to-cart" value="611" class="add-to-cart-button">Add to cart</button>
                </form>
            </div>

            <div class="product-meta">
                <span class="category-label">Category:
                    <a href="https://websitedemos.net/electronic-store-04/product-category/air-conditioner/" rel="tag">Air conditioner</a>
                </span>
            </div>
        </div>
    </div>
    <!-- footer  -->
    <?php include "footer.php" ?>
    <!-- end footer  -->
</body>

</html>
<script>
    document.getElementById('decrease-quantity').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('increase-quantity').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>

<script>
    // JavaScript để tăng giảm số lượng
    const decreaseButton = document.getElementById('decrease-quantity');
    const increaseButton = document.getElementById('increase-quantity');
    const quantityInput = document.getElementById('quantity-input');

    decreaseButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>