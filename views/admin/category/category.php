

    <h2 class="text-center mb-4">Danh mục sản phẩm</h2>

    <!-- Nút mở modal thêm -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
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
                        <button class="btn btn-warning btn-sm" 
                                onclick="openEditModal(<?= $cat['id'] ?>, '<?= $cat['ten_danh_muc'] ?>', '<?= $cat['mo_ta'] ?>')">
                            <i class="fa fa-edit"></i>
                        </button>

                        <a href="index.php?admin=category&action=delete&id=<?= $cat['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn chắc muốn xóa danh mục này?')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
