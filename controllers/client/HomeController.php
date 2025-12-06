<?php

class HomeController
{
    public function index()
    {
        require_once './models/Product.php';

        $productModel = new ProductModel();

        // Lấy 8 sản phẩm mới nhất
        $latestProducts = $productModel->getLatest(8);

        // Truyền sang view trang chủ
        require './views/client/index.php';
    }
}
