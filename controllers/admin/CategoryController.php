<?php
require_once './models/Category.php';

class CategoryController {

    private $category;

    public function __construct() {
        $this->category = new Category();
    }

    // Danh sách
    public function index() {
        $categories = $this->category->all();

        // Gửi đường dẫn view vào layout
        $cate = "./views/admin/category/category.php";
        require "./views/admin/layout.php";
    }


    // Lưu thêm
    public function store() {
    $ten = trim($_POST['ten_danh_muc']);
    $mo_ta = trim($_POST['mo_ta']);

    // Validate rỗng
    if ($ten === "" || $mo_ta === "") {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
        header("Location: index.php?admin=1&page=category
");
        exit;
    }

    // Validate trùng
    $exists = $this->category->findByName($ten);
    if ($exists) {
        $_SESSION['error'] = "Tên danh mục đã tồn tại!";
        header("Location: index.php?admin=1&page=category
");
        exit;
    }

    // OK -> thêm
    $this->category->create([
        'ten_danh_muc' => $ten,
        'mo_ta' => $mo_ta
    ]);

    $_SESSION['success'] = "Thêm danh mục thành công!";
    header("Location: index.php?admin=1&page=category
");
}


    // Lưu sửa
    public function update() {
    $id = $_POST['id'];
    $ten = trim($_POST['ten_danh_muc']);
    $mo_ta = trim($_POST['mo_ta']);

    if ($ten === "" || $mo_ta === "") {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
        header("Location: index.php?admin=1&page=category
");
        exit;
    }

    // Check trùng nhưng phải loại chính nó
    $exists = $this->category->findByName($ten);
    if ($exists && $exists['id'] != $id) {
        $_SESSION['error'] = "Tên danh mục đã tồn tại!";
        header("Location: index.php?admin=1&page=category
");
        exit;
    }

    // Update
    $this->category->updateCategory($id, [
        'ten_danh_muc' => $ten,
        'mo_ta' => $mo_ta
    ]);

    $_SESSION['success'] = "Cập nhật danh mục thành công!";
    header("Location: index.php?admin=1&page=category
");
}


    // Xóa
    public function delete() {
    $id = $_GET['id'];
    $this->category->deleteCategory($id);
    $_SESSION['success'] = "Xóa thành công!";
    header("Location: index.php?admin=1&page=category
");
}
}
