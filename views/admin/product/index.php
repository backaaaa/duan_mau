



    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Danh sách sản phẩm</h3>
        <a href="index.php?admin=1&page=product&action=create" class="btn btn-primary">
            + Thêm sản phẩm
        </a>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Mô tả</th>
                <th>Biến thể (size - màu - SL)</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $index => $p): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td width="80">
                    <?php if (!empty($p['anh_dai_dien'])): ?>
                        <img src="./uploads/products/<?= htmlspecialchars($p['anh_dai_dien']) ?>" 
                             alt="" class="img-fluid">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['ten_san_pham']) ?></td>
                <td><?= number_format($p['gia']) ?> đ</td>
                <td><?= $p['mo_ta'] ?> </td>
                <td>
                    <?php if (!empty($p['variants'])): ?>
                        <?php
                        // gom nhóm theo màu
                        $grouped = [];
                        foreach ($p['variants'] as $v) {
                            $grouped[$v['mau_sac']][$v['size']] = $v['so_luong'];
                        }
                        ?>

                        <ul class="mb-0">
                        <?php foreach ($grouped as $mau => $sizes): ?>
                            <li>
                                <strong><?= htmlspecialchars($mau) ?></strong>:
                                S = <?= $sizes['S'] ?? 0 ?> /
                                M = <?= $sizes['M'] ?? 0 ?> /
                                L = <?= $sizes['L'] ?? 0 ?> /
                                XL = <?= $sizes['XL'] ?? 0 ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>

                    <?php endif; ?>
                </td>
                <td width="160">
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editProduct<?= $p['id'] ?>">
                        Sửa
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteProduct<?= $p['id'] ?>">
                        Xóa
                    </button>
                </td>
            </tr>

            

        <?php endforeach; ?>
        </tbody>
    </table>

<!-- Modal SỬA -->
<div class="modal fade" id="editProduct<?= $p['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form class="modal-content"
              action="index.php?admin=1&page=product&action=update"
              method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="hidden" name="anh_cu" value="<?= htmlspecialchars($p['anh_dai_dien']) ?>">

            <div class="modal-header">
                <h5 class="modal-title">Sửa sản phẩm: <?= htmlspecialchars($p['ten_san_pham']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- THÔNG TIN SẢN PHẨM -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Danh mục</label>
                        <select name="id_danh_muc" class="form-select">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= $c['id'] == $p['id_danh_muc'] ? 'selected' : '' ?>>
                                    <?= $c['ten_danh_muc'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control"
                               name="ten_san_pham"
                               value="<?= $p['ten_san_pham'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="gia" value="<?= $p['gia'] ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Ảnh đại diện (nếu đổi)</label>
                        <input type="file" class="form-control" name="anh_dai_dien">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" rows="3" class="form-control"><?= $p['mo_ta'] ?></textarea>
                </div>

                <hr>

                <!-- BIẾN THỂ THEO MÀU -->
                <h5 class="mb-3">Biến thể theo từng màu</h5>

                <div id="variant-wrapper-<?= $p['id'] ?>">

                    <?php
                    // Gom theo màu
                    $group = [];
                    foreach ($p['variants'] as $v) {
                        $group[$v['mau_sac']][$v['size']] = $v['so_luong'];
                    }
                    ?>

                    <?php foreach ($group as $mau => $sizes): ?>
                        <div class="variant-item border rounded p-3 mb-3">

                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label>Màu</label>
                                    <input type="text" class="form-control"
                                           name="mau_sac[]"
                                           value="<?= $mau ?>"
                                           required>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label>Size S</label>
                                    <input type="number" name="so_luong_s[]"
                                           class="form-control"
                                           value="<?= $sizes['S'] ?? 0 ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Size M</label>
                                    <input type="number" name="so_luong_m[]"
                                           class="form-control"
                                           value="<?= $sizes['M'] ?? 0 ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Size L</label>
                                    <input type="number" name="so_luong_l[]"
                                           class="form-control"
                                           value="<?= $sizes['L'] ?? 0 ?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label>Size XL</label>
                                    <input type="number" name="so_luong_xl[]"
                                           class="form-control"
                                           value="<?= $sizes['XL'] ?? 0 ?>" required>
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mt-2 removeVariantBtn">
                                Xóa màu
                            </button>

                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- BTN + THÊM MÀU -->
                <button type="button" class="btn btn-outline-primary mt-2"
                        onclick="addVariantGroup('variant-wrapper-<?= $p['id'] ?>')">
                    + Thêm màu
                </button>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>

        </form>
    </div>
</div>

            <!-- Modal XÓA -->
            <div class="modal fade" id="deleteProduct<?= $p['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content"
                          action="index.php?admin=1&page=product&action=delete"
                          method="post">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Xóa sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa <strong><?= htmlspecialchars($p['ten_san_pham']) ?></strong> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
<script>
function addVariantGroup(wrapperId) {
    const wrapper = document.getElementById(wrapperId);
    const html = `
        <div class="variant-item border rounded p-3 mb-3">

            <div class="row mb-2">
                <div class="col-md-3">
                    <label>Màu</label>
                    <input type="text" class="form-control" name="mau_sac[]" required>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-3">
                    <label>Size S</label>
                    <input type="number" name="so_luong_s[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Size M</label>
                    <input type="number" name="so_luong_m[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Size L</label>
                    <input type="number" name="so_luong_l[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Size XL</label>
                    <input type="number" name="so_luong_xl[]" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm mt-2 removeVariantBtn">
                Xóa màu
            </button>

        </div>
    `;
    wrapper.insertAdjacentHTML("beforeend", html);
}

// Xóa block màu
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("removeVariantBtn")) {
        e.target.closest(".variant-item").remove();
    }
});
</script>

