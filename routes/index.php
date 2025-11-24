<?php


// Lấy tham số router
$admin = $_GET['admin'] ?? null;
$page = $_GET['page'] ?? null;

// Nếu là admin
if ($admin) {

    // // Kiểm tra quyền truy cập admin
    // if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    //     echo "Bạn không có quyền truy cập khu vực quản trị!";
    //     exit;
    // }

    switch ($page) {

        case "dashboard":
            require_once "./controllers/admin/DashboardController.php";
            $ctl = new DashboardController();
            $ctl->index();
            break;

        case "category":
            require_once "./controllers/admin/CategoryController.php";
            $ctl = new CategoryController();

            $action = $_GET["action"] ?? "index";

            switch ($action) {
                case "index": $ctl->index(); break;
                case "store": $ctl->store(); break;
                case "update": $ctl->update(); break;
                case "delete": $ctl->delete(); break;
            }
            break;

        case "product":
    require_once "./controllers/admin/ProductController.php";
    $ctl = new ProductController();

    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'create':
            $ctl->create();
            break;

        case 'store':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ctl->store();
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ctl->update();
            }
            break;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ctl->delete();
            }
            break;

        default:
            $ctl->index(); // trang liệt kê sản phẩm
            break;
    }
    break;

        case "orders":
            require_once "./controllers/admin/OrderController.php";
            $ctl = new OrderController();
            $ctl->index();
            break;

        default:
            echo "404 - Admin Page Not Found!";
            break;
    }

    exit;
}

// // Nếu không phải admin → đến CLIENT
// switch ($page) {

//     case "shop":
//         require_once "./controllers/client/ShopController.php";
//         $ctl = new ShopController();
//         $ctl->index();
//         break;

//     case "cart":
//         require_once "./controllers/client/CartController.php";
//         $ctl = new CartController();
//         $ctl->index();
//         break;

//     case "contact":
//         require_once "./controllers/client/ContactController.php";
//         $ctl = new ContactController();
//         $ctl->index();
//         break;

//     default:
//         require_once "./controllers/client/HomeController.php";
//         $ctl = new HomeController();
//         $ctl->index();
//         break;
// }
