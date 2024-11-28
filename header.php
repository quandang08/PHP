<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/style.css">
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
                                <a href="cart.php" class="text-white me-4 d-flex align-items-center">
                                    <i class="bi bi-cart4 fs-4 me-2"></i> <span class="d-none d-sm-inline">Cart</span>
                                </a>
                                <a href="/login" class="text-white d-flex align-items-center">
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