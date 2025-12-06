<?php require 'layouts/header.php'; ?>

<section class="shop-details">
    <div class="product__details__pic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__details__breadcrumb">
                        <a href="index.php">Home</a>
                        <a href="index.php?page=shop">Shop</a>
                        <span><?= htmlspecialchars($product['ten_san_pham']) ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- nếu muốn thêm list thumbnail sau thì để col-lg-3 bên trái, giờ bỏ tĩnh đi -->
                <div class="col-lg-3 col-md-3"></div>

                <div class="col-lg-6 col-md-9">
                    <div class="product__details__pic__item text-center">
                        <?php
                        $defaultImage = !empty($product['anh_dai_dien'])
                            ? 'uploads/products/' . $product['anh_dai_dien']
                            : '/assets/client/no-image.png';
                        ?>
                        <img id="mainProductImage"
                             src="<?= htmlspecialchars($defaultImage) ?>"
                             alt="<?= htmlspecialchars($product['ten_san_pham']) ?>"
                             style="max-height: 450px; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product__details__content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="product__details__text">
                        <h4><?= htmlspecialchars($product['ten_san_pham']) ?></h4>

                        <h3>
                            <?= number_format($product['gia'], 0, ',', '.') ?> đ
                        </h3>

                        <p><?= nl2br(htmlspecialchars($product['mo_ta'] ?? '')) ?></p>

                        <div class="product__details__option">
                            <!-- Size: bạn có thể làm động sau, tạm để static S/M/L/XL -->
                            <div class="product__details__option__size">
                                <span>Size:</span>
                                <label for="size-s">S
                                    <input type="radio" name="size" id="size-s" value="S">
                                </label>
                                <label for="size-m">M
                                    <input type="radio" name="size" id="size-m" value="M">
                                </label>
                                <label for="size-l">L
                                    <input type="radio" name="size" id="size-l" value="L">
                                </label>
                                <label for="size-xl">XL
                                    <input type="radio" name="size" id="size-xl" value="XL">
                                </label>
                            </div>

                            <!-- Màu: lấy từ biến thể, dùng chữ, click đổi ảnh -->
                            <div class="product__details__option__color">
                                <span>Màu sắc:</span>

                                <?php if (!empty($colors)): ?>
                                    <?php
                                    $index = 0;
                                    foreach ($colors as $c):
                                        $index++;
                                        $imagePath = !empty($c['anh_mau'])
                                            ? 'uploads/variants/' . $c['anh_mau']
                                            : $defaultImage; // nếu không có ảnh màu dùng ảnh đại diện
                                    ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-dark js-color-option <?= $index === 1 ? 'active' : '' ?>"
                                                data-image="<?= htmlspecialchars($imagePath) ?>"
                                                style="margin-right: 6px; margin-bottom: 4px;">
                                            <?= htmlspecialchars($c['mau_sac']) ?>
                                        </button>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Không có biến thể màu</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="product__details__cart__option">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <span class="fa fa-angle-up inc qtybtn"></span>
                                    <input type="text" value="1">
                                    <span class="fa fa-angle-down dec qtybtn"></span>
                                </div>
                            </div>


                            <a href="#" class="primary-btn">Thêm vào giỏ</a>
                        </div>

                        <!-- Các phần wishlist, compare, info... bạn giữ nguyên hoặc lược bớt tùy ý -->
                    </div>
                </div>
            </div>

            <!-- Phần tab mô tả, review,... bạn có thể copy y nguyên từ shop-details.html -->
        </div>
    </div>
</section>

<!-- JS đổi ảnh theo màu -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainImg = document.getElementById('mainProductImage');
    const colorButtons = document.querySelectorAll('.js-color-option');

    colorButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            // active class
            colorButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const img = this.getAttribute('data-image');
            if (img && mainImg) {
                mainImg.src = img;
            }
        });
    });
});

document.querySelectorAll('.product__details__option__size label')
    .forEach(l => {
        l.addEventListener('click', function() {
            document.querySelectorAll('.product__details__option__size label')
                .forEach(x => x.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

<?php require 'layouts/footer.php'; ?>
