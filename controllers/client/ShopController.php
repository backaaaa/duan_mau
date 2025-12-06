<?php

class ShopController
{
    public function index()
    {
        require_once './models/Product.php';
        require_once './models/Category.php';

        $productModel  = new ProductModel();
        $categoryModel = new Category();

        $keyword = $_GET['keyword']  ?? '';
        $cateId  = $_GET['cate_id']  ?? '';
        $page    = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;

        $perPage = 12;

        $totalProducts = $productModel->countForClient($keyword, $cateId);
        $totalPages    = max(1, ceil($totalProducts / $perPage));
        if ($page > $totalPages) $page = $totalPages;

        $offset   = ($page - 1) * $perPage;

        $products   = $productModel->getForClient($keyword, $cateId, $perPage, $offset);
        $categories = $categoryModel->all();

        // truyền sang view
        require './views/client/shop.php';
    }

    public function detail()
    {
        require_once './models/Product.php';

        $productModel = new ProductModel();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?page=shop');
            exit;
        }

        // lấy sản phẩm
        $product = $productModel->find($id);   // hàm find bạn đã dùng bên admin
        if (!$product) {
            // tuỳ bạn: cho về shop hoặc show 404
            header('Location: index.php?page=shop');
            exit;
        }

        // lấy biến thể
        $variants = $productModel->getVariantsByProductId($id);

        // gom theo màu để dễ show ngoài view
        $colors = []; // key = tên màu
        foreach ($variants as $v) {
            $colorName = $v['mau_sac'];

            if (!isset($colors[$colorName])) {
                $colors[$colorName] = [
                    'mau_sac' => $colorName,
                    'anh_mau' => $v['anh_mau'], // có thể rỗng
                ];
            }
        }

        // truyền sang view
        require './views/client/product-detail.php';
    }
}
