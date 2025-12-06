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

    // gán thêm variants cho từng product nhưng KHÔNG dùng tham chiếu
    foreach ($products as $key => $p) {
        $products[$key]['variants'] = $this->productModel->getVariantsByProduct($p['id']);
    }

    $categories = $this->categoryModel->all();

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
    $filesColor = $_FILES['anh_mau'] ?? null;


    $variants = [];

    for ($i = 0; $i < count($colors); $i++) {

        $color = trim($colors[$i]);
        if ($color === "") continue; // bỏ dòng rỗng

        // xử lý upload ảnh cho màu thứ $i
        $colorImage = '';

        if ($filesColor && !empty($filesColor['name'][$i])) {
            $fileName = time() . '_' . $i . '_' . basename($filesColor['name'][$i]);
            $uploadPath = './uploads/variants/' . $fileName;

            // nhớ tạo thư mục uploads/variants trước
            if (move_uploaded_file($filesColor['tmp_name'][$i], $uploadPath)) {
                $colorImage = $fileName;
            }
        }

        // mỗi màu = 4 dòng variant, nhưng dùng chung 1 ảnh
        $variants[] = [
            'size'      => 'S',
            'mau_sac'   => $color,
            'anh_mau'   => $colorImage,
            'so_luong'  => (int)($s_s[$i] ?? 0),
        ];
        $variants[] = [
            'size'      => 'M',
            'mau_sac'   => $color,
            'anh_mau'   => $colorImage,
            'so_luong'  => (int)($s_m[$i] ?? 0),
        ];
        $variants[] = [
            'size'      => 'L',
            'mau_sac'   => $color,
            'anh_mau'   => $colorImage,
            'so_luong'  => (int)($s_l[$i] ?? 0),
        ];
        $variants[] = [
            'size'      => 'XL',
            'mau_sac'   => $color,
            'anh_mau'   => $colorImage,
            'so_luong'  => (int)($s_xl[$i] ?? 0),
        ];
    }


    // Lưu SP + biến thể
    $this->productModel->createWithVariants($data, $variants);

    header('Location: index.php?admin=1&page=product');
    exit;
}

    // Xử lý update từ modal
public function update()
{
    $id = (int)$_POST['id'];

    // ========== 1. ẢNH ĐẠI DIỆN ==========
    $anh = $_POST['anh_cu'] ?? '';

    if (!empty($_FILES['anh_dai_dien']['name'])) {
        $fileName   = time() . "_" . basename($_FILES['anh_dai_dien']['name']);
        $uploadPath = './uploads/products/' . $fileName;

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $uploadPath)) {
            $anh = $fileName;
        }
    }

    // dữ liệu sản phẩm
    $data = [
        'id_danh_muc'  => $_POST['id_danh_muc'],
        'ten_san_pham' => $_POST['ten_san_pham'],
        'gia'          => $_POST['gia'],
        'anh_dai_dien' => $anh,
        'mo_ta'        => $_POST['mo_ta'],
    ];

    // ========== 2. BIẾN THỂ + ẢNH MÀU ==========
    $colors  = $_POST['mau_sac']     ?? [];
    $s_s     = $_POST['so_luong_s']  ?? [];
    $s_m     = $_POST['so_luong_m']  ?? [];
    $s_l     = $_POST['so_luong_l']  ?? [];
    $s_xl    = $_POST['so_luong_xl'] ?? [];

    // ảnh màu cũ (hidden)
    $oldColorImages = $_POST['anh_mau_cu'] ?? [];

    // file ảnh màu mới
    $filesColor = $_FILES['anh_mau'] ?? null;

    $variants = [];

    for ($i = 0; $i < count($colors); $i++) {

        $color = trim($colors[$i] ?? '');
        if ($color === '') continue;

        // ---- xử lý ảnh cho màu thứ $i ----
        // mặc định dùng ảnh cũ
        $colorImage = $oldColorImages[$i] ?? '';

        // nếu có upload ảnh mới -> thay
        if ($filesColor && !empty($filesColor['name'][$i])) {
            // nhớ tạo sẵn thư mục ./uploads/variants/
            $fileName   = time() . '_' . $i . '_' . basename($filesColor['name'][$i]);
            $uploadPath = './uploads/variants/' . $fileName;

            if (move_uploaded_file($filesColor['tmp_name'][$i], $uploadPath)) {
                $colorImage = $fileName;
            }
        }

        // mỗi màu -> 4 size, dùng chung 1 ảnh màu
        $variants[] = [
            'size'     => 'S',
            'mau_sac'  => $color,
            'anh_mau'  => $colorImage,
            'so_luong' => (int)($s_s[$i] ?? 0),
        ];
        $variants[] = [
            'size'     => 'M',
            'mau_sac'  => $color,
            'anh_mau'  => $colorImage,
            'so_luong' => (int)($s_m[$i] ?? 0),
        ];
        $variants[] = [
            'size'     => 'L',
            'mau_sac'  => $color,
            'anh_mau'  => $colorImage,
            'so_luong' => (int)($s_l[$i] ?? 0),
        ];
        $variants[] = [
            'size'     => 'XL',
            'mau_sac'  => $color,
            'anh_mau'  => $colorImage,
            'so_luong' => (int)($s_xl[$i] ?? 0),
        ];
    }

    // ========== 3. CẬP NHẬT DB ==========
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

    public function get()
    {
        $id = $_GET['id'];
        $product  = $this->productModel->find($id);
        $variants = $this->productModel->getVariantsByProductId($id);

        echo json_encode([
            'product' => $product,
            'variants' => $variants
        ]);
        exit;
    }


}
