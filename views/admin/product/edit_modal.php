<!-- MODAL SỬA SẢN PHẨM -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <form action="index.php?admin=1&page=product&action=update" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="editProductId">
                <input type="hidden" name="anh_cu" id="editAnhCu">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title">Sửa sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- DANH MỤC + TÊN -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Danh mục</label>
                            <select name="id_danh_muc" id="editDanhMuc" class="form-select" required></select>
                        </div>
                        <div class="col-md-8">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="ten_san_pham" id="editTen" class="form-control" required>
                        </div>
                    </div>

                    <!-- GIÁ + ẢNH -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Giá</label>
                            <input type="number" name="gia" id="editGia" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label>Ảnh đại diện (nếu muốn đổi)</label>
                            <input type="file" name="anh_dai_dien" class="form-control">
                        </div>
                    </div>

                    <!-- MÔ TẢ -->
                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="mo_ta" id="editMoTa" class="form-control" rows="3"></textarea>
                    </div>

                    <hr>

                    <!-- BIẾN THỂ -->
                    <h5>Biến thể theo từng màu</h5>
                    <div id="variantEditWrapper"></div>

                    <button type="button" class="btn btn-outline-primary mt-3" id="addVariantEditBtn">
                        + Thêm màu
                    </button>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
// Tạo block màu + 4 size
function createVariantRowEdit(data = null) {
    return `
        <div class="variant-item border rounded p-3 mb-3">

            <div class="row mb-2">
                <div class="col-md-3">
                    <label>Màu</label>
                    <input type="text" class="form-control" name="mau_sac[]" 
                        value="${data ? data.mau_sac : ''}" required>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-3">
                    <label>Số lượng size S</label>
                    <input type="number" class="form-control" name="so_luong_s[]" 
                        value="${data ? data.so_s : ''}" required>
                </div>

                <div class="col-md-3">
                    <label>Số lượng size M</label>
                    <input type="number" class="form-control" name="so_luong_m[]" 
                        value="${data ? data.so_m : ''}" required>
                </div>

                <div class="col-md-3">
                    <label>Số lượng size L</label>
                    <input type="number" class="form-control" name="so_luong_l[]" 
                        value="${data ? data.so_l : ''}" required>
                </div>

                <div class="col-md-3">
                    <label>Số lượng size XL</label>
                    <input type="number" class="form-control" name="so_luong_xl[]" 
                        value="${data ? data.so_xl : ''}" required>
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">
                Xóa màu
            </button>

        </div>
    `;
}

// Thêm màu
document.getElementById("addVariantEditBtn").onclick = () => {
    document.getElementById("variantEditWrapper")
        .insertAdjacentHTML("beforeend", createVariantRowEdit());
};

// Xóa màu
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("remove-variant")) {
        e.target.closest(".variant-item").remove();
    }
});
</script>
