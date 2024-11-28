<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
</head>
<style>
    /* Cấu hình chung cho phần container */
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

    /* Cột bên trái (Hình ảnh sản phẩm) */
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

    /* Hiệu ứng hover cho hình ảnh */
    .product-main-image:hover img {
        transform: scale(1.05);
    }

    /* Cột bên phải (Thông tin sản phẩm) */
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

    /* Các kiểu dáng cho thông tin sản phẩm */
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

    /* Nút thêm vào giỏ hàng */
    .add-to-cart-button {
        background-color: #000000;
        color: white;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        border-radius: 5px;
        transition: background-color 0.3s ease-in-out;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .add-to-cart-button:hover {
        background-color: #007bff;
    }

    .add-to-cart-form {
        display: flex;
        align-items: center;
        gap: 20px;
        /* Khoảng cách giữa số lượng và nút Add to Cart */
    }

    /* Cấu hình cho phần điều khiển số lượng */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background-color: #f7f7f7;
        padding: 5px 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: auto;
        min-width: 200px;
        /* Đảm bảo chiều rộng ổn định */
    }

    /* Các nút giảm và tăng đều vuông */
    .quantity-button {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        background-color: #e0e0e0;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        text-align: center;
    }

    /* Nút giảm và tăng khi hover */
    .quantity-button:hover {
        background-color: #007bff;
        color: white;
    }

    /* Ô nhập số lượng */
    .input-quantity {
        text-align: center;
        font-size: 1.6rem;
        width: 60px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        margin: 0;
    }

    /* Hiệu ứng khi focus vào ô nhập số */
    .input-quantity:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Wrapper chứa điều khiển số lượng và nút "Add to cart" */
    .add-to-cart-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: flex-start;
    }

    /* Điều chỉnh phần điều khiển số lượng */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background-color: #f7f7f7;
        padding: 5px 10px;
        /* Điều chỉnh padding */
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 150px;
        /* Giới hạn chiều rộng */
    }

    /* Các nút giảm và tăng */
    .quantity-button {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        background-color: #e0e0e0;
        padding: 8px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    /* Nút giảm và tăng khi hover */
    .quantity-button:hover {
        background-color: #007bff;
        color: white;
    }

    /* Ô nhập số lượng */
    .input-quantity {
        text-align: center;
        font-size: 1.2rem;
        width: 40px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        margin: 0;
    }

    /* Hiệu ứng khi focus vào ô nhập số */
    .input-quantity:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Nút Add to Cart */
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


    /* Các phần tử bổ sung */
    .breadcrumb-navigation a {
        font-size: 1.2rem;
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb-navigation a:hover {
        text-decoration: underline;
    }

    /* Đảm bảo màn hình nhỏ responsive */
    /* Phần điều chỉnh độ rộng của các phần tử trong giao diện */
    @media (max-width: 768px) {
        .product-detail-container {
            flex-direction: column;
            align-items: center;
        }

        .product-main-image,
        .product-info {
            max-width: 100%;
        }

        .add-to-cart-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .quantity-control {
            min-width: 150px;
            /* Điều chỉnh lại chiều rộng khi trên thiết bị nhỏ */
        }
    }
</style>

<body>
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
                <form class="add-to-cart-form" action="https://websitedemos.net/electronic-store-04/product/air-conditioner-5000-btu-efficient-cooling-for-smaller-areas-like-bedrooms-and-guest-rooms/" method="post" enctype="multipart/form-data">
                    <div class="quantity-control">
                        <span class="quantity-button" id="decrease-quantity">-</span>
                        <input type="number" id="quantity-input" class="input-quantity" name="quantity" value="1" aria-label="Product quantity" size="4" min="1" max="" step="1" inputmode="numeric" autocomplete="off">
                        <span class="quantity-button" id="increase-quantity">+</span>
                    </div>
                </form>
                <!-- Nút thêm vào giỏ hàng -->
                <button type="submit" name="add-to-cart" value="611" class="add-to-cart-button">Add to cart</button>
            </div>

            <div class="product-meta">
                <span class="category-label">Category:
                    <a href="https://websitedemos.net/electronic-store-04/product-category/air-conditioner/" rel="tag">Air conditioner</a>
                </span>
            </div>
        </div>
    </div>
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