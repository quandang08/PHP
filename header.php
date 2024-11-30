<?php
require_once "Product_Database.php";
require_once "Category_Database.php";

$product_Database = new Product_Database();
$category_Database = new Category_Database();

$categories = $category_Database->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body,
    html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    section.above-header {
        background-color: #0769DA !important;
        color: #fff;
    }

    .below-header {
        background-color: #0572ED !important;
    }

    ul.nav .nav-item .nav-link {
        color: white;
    }
</style>

<!-- Cart Drawer Css  -->
<style>
/* General styles for Cart Drawer */
.cart-drawer {
    font-family: "Roboto", serif;
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    max-width: 400px;
    height: 100%;
    background-color: #fff;
    box-shadow: -2px 0 8px rgba(0, 0, 0, 0.2);
    z-index: 1050;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
}

.cart-drawer.active {
    transform: translateX(0);
}

/* Header */
.cart-drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.cart-drawer-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.cart-drawer-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Content */
.cart-drawer-content {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
}

/* Cart Items */
.cart-items {
    list-style: none;
    margin: 0;
    padding: 0;
}

.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.cart-item-img {
    width: 50px;
    height: 50px;
    margin-right: 15px;
    object-fit: cover;
    border-radius: 5px;
}

.cart-item-info {
    flex: 1;
}

.cart-item-name {
    font-weight: bold;
    margin-bottom: 5px;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
}

.quantity-btn,
.quantity-input {
    margin: 0;
    padding: 0;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ddd;
    border: none;
    cursor: pointer;
}

.quantity-input {
    width: 40px;
    height: 29px;
    text-align: center;
    border: 1px solid #ccc;
    font-size: 14px;

}

.cart-item-price {
    color: #333;
    font-weight: bold;
}

.cart-item-remove {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #ff5f5f;
    cursor: pointer;
}

/* Cart Summary */
.cart-summary {
    padding: 15px;
    border-top: 1px solid #e9ecef;
    font-size: 1rem;
}

/* Actions */
.cart-actions {
    padding: 15px;
    border-top: 1px solid #e9ecef;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.cart-actions .btn {
    text-align: center;
    padding: 10px;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
}

.btn-view-cart {
    background-color: #0d0d0d;
    color: #fff;
    text-decoration: none;
    font-weight: 600;

}

.btn-view-cart:hover {
    background-color: #0573f0;
    color: #fff;
}

.btn-checkout {
    background-color: #000e04;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}

.btn-checkout:hover {
    background-color: #0573f0;
    color: #fff;
}
</style>
<!-- End Cart Drawer Css  -->
<body>
    <div class="container-fluid">
        <!-- Header -->
        <header id="main-header">
            <!-- Above Header -->
            <section class="above-header bg-light py-2">
                <div class="container d-flex justify-content-between align-items-center">
                    <div class="above-header-left">
                        <p class="mb-0">24/7 Customer service <strong>1-800-234-5678</strong></p>
                    </div>
                    <div class="above-header-right">
                        <nav>
                            <ul class="nav">
                                <li class="nav-item"><a href="#" class="nav-link">Shipping & Return</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Track Order</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Main Header -->
            <div class="ast-main-header-wrap main-header-bar-wrap bg-primary text-white">
                <div class="container py-3">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <a href="#" class="d-inline-block">
                                <img src="https://websitedemos.net/electronic-store-04/wp-content/uploads/sites/1055/2022/03/electronic-store-logo.svg"
                                    alt="Electronic Store" width="150" height="40">
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <form role="search" method="get" class="d-flex">
                                <input type="search" class="form-control me-2" placeholder="Search product..." name="keyword" value="<?= htmlspecialchars($keyword ?? ''); ?>">
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-inline-flex align-items-center">
                                <a href="#" id="open-cart-drawer" class="text-white me-4 d-flex align-items-center">
                                    <i  class="bi bi-cart4 fs-4 me-2" style="cursor: pointer;"></i> 
                                    <span  class="d-none d-sm-inline">Cart</span>
                                </a>

                                <a href="login.php" class="text-white d-flex align-items-center">
                                    <i class="bi bi-person fs-4 me-2"></i> <span class="d-none d-sm-inline">Log In</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Below Header -->
            <nav class="below-header bg-primary py-2">
                <div class="container d-flex justify-content-center">
                    <ul class="nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-white" id="navbarDropdownAllProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                All products
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="danhsachsanpham.php" class="nav-link text-white">Home appliances</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Audio & Video</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Refrigerator</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">New arrivals</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Today's Deal</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Gift Cards</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- End Header -->