<div class="container mt-4">
    <h3>Thêm sản phẩm</h3>

    <form action="index.php?admin=1&page=product&action=store"
          method="post" enctype="multipart/form-data" class="mt-4">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Danh mục</label>
                <select name="id_danh_muc" class="form-select" required>
                    <option value="">--Chọn danh mục--</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= htmlspecialchars($c['ten_danh_muc']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Giá</label>
                <input type="number" name="gia" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="anh_dai_dien" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="3"></textarea>
        </div>

        <hr>
        <h5>Biến thể sản phẩm</h5>

        <div id="variant-box">

            <!-- Một block màu -->
            <div class="variant-row border p-3 rounded mb-3">

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">Màu sắc</label>
                        <input type="text" name="mau_sac[]" class="form-control" placeholder="Ví dụ: Đỏ" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ảnh cho màu này</label>
                        <input type="file" name="anh_mau[]" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-3">
                        <label>Số lượng size S</label>
                        <input type="number" name="so_luong_s[]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Số lượng size M</label>
                        <input type="number" name="so_luong_m[]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Số lượng size L</label>
                        <input type="number" name="so_luong_l[]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Số lượng size XL</label>
                        <input type="number" name="so_luong_xl[]" class="form-control" required>
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Xóa màu</button>
            </div>

        </div>

        <button type="button" class="btn btn-outline-primary mt-2" onclick="addVariant()">
            + Thêm màu
        </button>

        <div class="mt-4">
            <a href="index.php?admin=1&page=product" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        </div>

    </form>
</div>

<script>
function addVariant() {
    const block = `
    <div class="variant-row border p-3 rounded mb-3">

        <div class="row mb-2">
            <div class="col-md-4">
                <label class="form-label">Màu sắc</label>
                <input type="text" name="mau_sac[]" class="form-control" placeholder="Ví dụ: Đỏ" required>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-md-3">
                <label>Số lượng size S</label>
                <input type="number" name="so_luong_s[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Số lượng size M</label>
                <input type="number" name="so_luong_m[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Số lượng size L</label>
                <input type="number" name="so_luong_l[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Số lượng size XL</label>
                <input type="number" name="so_luong_xl[]" class="form-control" required>
            </div>
        </div>

        <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Xóa màu</button>
    </div>
    `;

    document.getElementById("variant-box").insertAdjacentHTML("beforeend", block);

    setRemoveEvent();
}

function setRemoveEvent() {
    document.querySelectorAll(".remove-variant").forEach(btn => {
        btn.onclick = function () {
            this.parentElement.remove();
        };
    });
}

setRemoveEvent();
</script>
