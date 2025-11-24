<?php

require_once './models/Product.php';
require_once './models/Category.php'; // nếu tên khác thì sửa lại

class ProductController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new Category();
    }

    // Danh sách sản phẩm
    public function index()
    {
        $products = $this->productModel->all();

        // gán thêm variants cho từng product
        foreach ($products as &$p) {
            $p['variants'] = $this->productModel->getVariantsByProduct($p['id']);
        }

        $categories = $this->categoryModel->all();

        // Gửi đường dẫn view vào layout
        $view = "./views/admin/product/index.php";
        require "./views/admin/layout.php";
    }

    // Form thêm
    public function create()
    {
        $categories = $this->categoryModel->all();
        $view = "./views/admin/product/create.php";
        // chỉ định modal nằm ngoài layout
        $modal = "./views/admin/product/edit_modal.php";
        require "./views/admin/layout.php";
        
    }

    // Xử lý thêm
    public function store()
{
    // Xử lý ảnh
    $anh = "";
    if (!empty($_FILES['anh_dai_dien']['name'])) {
        $fileName = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
        $uploadPath = './uploads/products/' . $fileName;

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $uploadPath)) {
            $anh = $fileName;
        }
    }

    // Dữ liệu SP
    $data = [
        'id_danh_muc'  => $_POST['id_danh_muc'] ?? null,
        'ten_san_pham' => $_POST['ten_san_pham'] ?? '',
        'gia'          => $_POST['gia'] ?? 0,
        'anh_dai_dien' => $anh,
        'mo_ta'        => $_POST['mo_ta'] ?? '',
    ];

    // ==========================
    // LẤY BIẾN THỂ THEO MÀU -> 4 SIZE
    // ==========================

    $colors = $_POST['mau_sac']      ?? [];
    $s_s    = $_POST['so_luong_s']   ?? [];
    $s_m    = $_POST['so_luong_m']   ?? [];
    $s_l    = $_POST['so_luong_l']   ?? [];
    $s_xl   = $_POST['so_luong_xl']  ?? [];

    $variants = [];

    for ($i = 0; $i < count($colors); $i++) {

        $color = trim($colors[$i]);
        if ($color === "") continue; // bỏ dòng rỗng

        // mỗi màu = 4 dòng variant
        $variants[] = ['size' => 'S',  'mau_sac' => $color, 'so_luong' => (int)$s_s[$i]];
        $variants[] = ['size' => 'M',  'mau_sac' => $color, 'so_luong' => (int)$s_m[$i]];
        $variants[] = ['size' => 'L',  'mau_sac' => $color, 'so_luong' => (int)$s_l[$i]];
        $variants[] = ['size' => 'XL', 'mau_sac' => $color, 'so_luong' => (int)$s_xl[$i]];
    }

    // Lưu SP + biến thể
    $this->productModel->createWithVariants($data, $variants);

    header('Location: index.php?admin=1&page=product');
    exit;
}

    // Xử lý update từ modal
   public function update()
{
    $id = $_POST['id'];

    // Xử lý ảnh
    $anh = $_POST['anh_cu'];

    if (!empty($_FILES['anh_dai_dien']['name'])) {
        $fileName = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
        $uploadPath = './uploads/products/' . $fileName;

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $uploadPath)) {
            $anh = $fileName;
        }
    }

    $data = [
        'id_danh_muc'  => $_POST['id_danh_muc'],
        'ten_san_pham' => $_POST['ten_san_pham'],
        'gia'          => $_POST['gia'],
        'anh_dai_dien' => $anh,
        'mo_ta'        => $_POST['mo_ta'],
    ];

    // Lấy biến thể
    $colors = $_POST['mau_sac']      ?? [];
    $s_s    = $_POST['so_luong_s']   ?? [];
    $s_m    = $_POST['so_luong_m']   ?? [];
    $s_l    = $_POST['so_luong_l']   ?? [];
    $s_xl   = $_POST['so_luong_xl']  ?? [];

    $variants = [];

    for ($i = 0; $i < count($colors); $i++) {

        $color = trim($colors[$i]);
        if ($color === "") continue;

        $variants[] = ['size' => 'S',  'mau_sac' => $color, 'so_luong' => (int)$s_s[$i]];
        $variants[] = ['size' => 'M',  'mau_sac' => $color, 'so_luong' => (int)$s_m[$i]];
        $variants[] = ['size' => 'L',  'mau_sac' => $color, 'so_luong' => (int)$s_l[$i]];
        $variants[] = ['size' => 'XL', 'mau_sac' => $color, 'so_luong' => (int)$s_xl[$i]];
    }

    // Cập nhật
    $this->productModel->updateWithVariants($id, $data, $variants);

    header('Location: index.php?admin=1&page=product');
    exit;
}


    // Xóa (từ modal confirm)
    public function delete()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->productModel->deleteWithVariants($id);
        }

        header('Location: index.php?admin=1&page=product');
        exit;
    }
}
