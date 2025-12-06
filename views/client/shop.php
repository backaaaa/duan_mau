<?php require 'layouts/header.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <?php
// helper build URL giữ lại keyword & cateId
function shop_build_query($page, $keyword, $cateId) {
    $params = [
        'page' => 'shop',
        'p'    => $page,
    ];
    if ($keyword !== '') $params['keyword'] = $keyword;
    if ($cateId   !== '') $params['cate_id'] = $cateId;

    return '?' . http_build_query($params);
}

// Tính start/end để hiển thị "Showing x–y of z"
$perPage = 12; // phải giống ở controller
$currentPage = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$offset = ($currentPage - 1) * $perPage;
$start  = $totalProducts ? $offset + 1 : 0;
$end    = min($offset + $perPage, $totalProducts);
?>
<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <!-- SEARCH -->
                    <div class="shop__sidebar__search">
                        <form action="" method="get">
                            <input type="hidden" name="page" value="shop">
                            <input type="text" name="keyword" placeholder="Search..."
                                   value="<?= htmlspecialchars($keyword) ?>">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>

                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="accordionExample">
                            <!-- CATEGORIES -->
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                <li>
                                                    <a href="<?= shop_build_query(1, $keyword, '') ?>">
                                                        Tất cả
                                                    </a>
                                                </li>
                                                <?php foreach ($categories as $cate): ?>
                                                    <li>
                                                        <a href="<?= shop_build_query(1, $keyword, $cate['id']) ?>">
                                                            <?= htmlspecialchars($cate['ten_danh_muc']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Các card khác (Branding, Price, Size, Colors, Tags) 
                                 nếu chưa dùng thì bạn có thể để nguyên hoặc xoá bớt -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                <!-- LIST PRODUCT -->
                <div class="row">
                    <?php if (empty($products)): ?>
                        <div class="col-12">
                            <p>Không có sản phẩm nào.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <a href="index.php?page=product-detail&id=<?= $product['id'] ?>">
                                    <div class="product__item__pic set-bg"
                                         data-setbg="./uploads/products/<?= htmlspecialchars($product['anh_dai_dien'] ?? '') ?>">
                                        
                                    </div>
                                    </a>
                                    <div class="product__item__text">
                                        <h6><?= htmlspecialchars($product['ten_san_pham']) ?></h6>
                                        <a href="#" class="add-cart">+ Add To Cart</a>
                                        <!-- rating, nếu chưa có thì để rỗng -->
                                        <div class="rating">
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <h5>
                                            <?= number_format($product['gia'], 0, ',', '.') ?> đ
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- PAGINATION -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__pagination">
                            <?php if ($totalPages > 1): ?>
                                <?php if ($currentPage > 1): ?>
                                    <a href="<?= shop_build_query($currentPage - 1, $keyword, $cateId) ?>">&laquo;</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a class="<?= $i == $currentPage ? 'active' : '' ?>"
                                       href="<?= shop_build_query($i, $keyword, $cateId) ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="<?= shop_build_query($currentPage + 1, $keyword, $cateId) ?>">&raquo;</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div> <!-- end col-lg-9 -->
        </div>
    </div>
</section>

    <!-- Shop Section End -->


    <?php require 'layouts/footer.php'; ?>