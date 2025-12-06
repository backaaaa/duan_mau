<?php require 'layouts/header.php'; ?>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="/base-duanmau/assets/client/img/banner/banner-1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections 2030</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="/base-duanmau/assets/client/img/banner/banner-2.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="/base-duanmau/assets/client/img/banner/banner-3.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Shoes Spring 2030</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Mới nhất</li>
                        
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                <?php if (!empty($latestProducts)): ?>
        <?php foreach ($latestProducts as $p): ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product__item">
                        <div class="product__item__pic">
                            <a href="index.php?page=shop-detail&id=<?= $p['id'] ?>">
                                <img src="./uploads/products/<?= htmlspecialchars($p['anh_dai_dien']) ?>"
                                    alt="<?= htmlspecialchars($p['ten_san_pham']) ?>">
                            </a>
                        </div>
                           
                        </div>
                        <div class="product__item__text">
                            <h6><?= htmlspecialchars($p['ten_san_pham']) ?></h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            
                            <h5><?= number_format($p['gia']) ?> đ</h5>
                            
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
    <?php else: ?>
        <p>Hiện chưa có sản phẩm nào.</p>
    <?php endif; ?>
                
            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/base-duanmau/assets/client/img/blog/blog-1.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/base-duanmau/assets/client/img/icon/calendar.png" alt=""> 16 February 2020</span>
                            <h5>What Curling Irons Are The Best Ones</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/base-duanmau/assets/client/img/blog/blog-2.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/base-duanmau/assets/client/img/icon/calendar.png" alt=""> 21 February 2020</span>
                            <h5>Eternity Bands Do Last Forever</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/base-duanmau/assets/client/img/blog/blog-3.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/base-duanmau/assets/client/img/icon/calendar.png" alt=""> 28 February 2020</span>
                            <h5>The Health Benefits Of Sunglasses</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->
<?php require 'layouts/footer.php'; ?>