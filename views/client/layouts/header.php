<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/base-duanmau/assets/client/css/style.css" type="text/css">
</head>
<body>

    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">

        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="#">Đăng nhập</a>
                <a href="#">Câu hỏi thường gặp</a>
            </div>

            <div class="offcanvas__top__hover">
                <span>VNĐ <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>VNĐ</li>
                    <li>USD</li>
                    <li>EUR</li>
                </ul>
            </div>
        </div>

        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="/base-duanmau/assets/client/img/icon/search.png" alt=""></a>
            <a href="#"><img src="/base-duanmau/assets/client/img/icon/heart.png" alt=""></a>
            <a href="#"><img src="/base-duanmau/assets/client/img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price">0 đ</div>
        </div>

        <div id="mobile-menu-wrap"></div>

        <div class="offcanvas__text">
            <p>Miễn phí vận chuyển – đổi trả trong 30 ngày.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">

        <div class="header__top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Miễn phí vận chuyển – đổi trả trong 30 ngày.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">

                                <?php if (isset($_SESSION['user'])): ?>
                                    <span style="color:white;">
                                        Xin chào: <?= htmlspecialchars($_SESSION['user']['fullname']) ?>
                                    </span>
                                    | <a href="index.php?page=logout">Đăng xuất</a>

                                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                        | <a href="index.php?admin=1&page=category">🌐 Trang quản trị</a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <a href="index.php?page=login">Đăng nhập</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="index.php"><img src="/base-duanmau/assets/client/img/lo.png" alt="" width = "150px"></a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li><a href="index.php">Trang chủ</a></li>
                            <li><a href="index.php?page=shop">Sản phẩm</a></li>

                            <li><a href="#">Trang khác</a>
                                <ul class="dropdown">
                                    <li><a href="./about.html">Về chúng tôi</a></li>
                                    <li><a href="./shop-details.html">Chi tiết sản phẩm</a></li>
                                    <li><a href="./shopping-cart.html">Giỏ hàng</a></li>
                                    <li><a href="./checkout.html">Thanh toán</a></li>
                                    <li><a href="./blog-details.html">Chi tiết blog</a></li>
                                </ul>
                            </li>

                            <li><a href="./blog.html">Blog</a></li>
                            <li><a href="./contact.html">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img src="/base-duanmau/assets/client/img/icon/search.png" alt=""></a>
                        <a href="#"><img src="/base-duanmau/assets/client/img/icon/heart.png" alt=""></a>
                        <a href="#"><img src="/base-duanmau/assets/client/img/icon/cart.png" alt=""> <span>0</span></a>
                        <div class="price">0 đ</div>
                    </div>
                </div>

            </div>

            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>

    </header>
    <!-- Header Section End -->
