

    <h2 class="text-center mb-4">Danh mục sản phẩm</h2>

    <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addModal">
        <i class="fa fa-plus"></i> Thêm danh mục
    </button>



    <table class="table table-bordered table-hover" id="categoryTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th width="120px">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= $cat['ten_danh_muc'] ?></td>
                    <td><?= $cat['mo_ta'] ?></td>
                    <td><?= $cat['ngay_tao'] ?></td>
                    <td><?= $cat['ngay_cap_nhat'] ?></td>

                    <td>
                        <!-- Nút SỬA: mở modal sửa -->
                        <button type="button"
                                class="btn btn-sm btn-warning btn-edit-category"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal"
                                data-id="<?= $cat['id'] ?>"
                                data-name="<?= htmlspecialchars($cat['ten_danh_muc'], ENT_QUOTES, 'UTF-8') ?>"
                                data-desc="<?= htmlspecialchars($cat['mo_ta'], ENT_QUOTES, 'UTF-8') ?>">
                            Sửa
                        </button>

                        <a href="index.php?admin=1&page=category&action=delete&id=<?= $cat['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn chắc muốn xóa danh mục này?')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

<!-- Modal THÊM DANH MỤC -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content"
              action="index.php?admin=1&page=category&action=store"
              method="post">

            <div class="modal-header">
                <h5 class="modal-title">Thêm danh mục mới</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tên danh mục</label>
                    <input type="text" name="ten_danh_muc"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta" class="form-control"
                              rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">Đóng</button>
                <button type="submit"
                        class="btn btn-primary">Lưu</button>
            </div>

        </form>
    </div>
</div>

<!-- Modal SỬA -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content"
              action="index.php?admin=1&page=category&action=update"
              method="post">

            <div class="modal-header">
                <h5 class="modal-title">Sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- id ẩn -->
                <input type="hidden" name="id" id="edit-id">

                <div class="mb-3">
                    <label class="form-label">Tên danh mục</label>
                    <input type="text" name="ten_danh_muc"
                           id="edit-name"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="mo_ta"
                              id="edit-desc"
                              class="form-control"
                              rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>

        </form>
    </div>
</div>
<script>
    document.querySelectorAll('.btn-edit-category').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const name = this.dataset.name;
            const desc = this.dataset.desc;

            document.getElementById('edit-id').value   = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-desc').value = desc;
        });
    });

    
</script>
