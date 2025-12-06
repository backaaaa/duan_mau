<?php

$admin = $_GET['admin'] ?? null;
$page  = $_GET['page'] ?? null;

# ==========================
#    ADMIN AREA – CHECK ROLE
# ==========================
if ($admin) {

    if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
        echo "Bạn không có quyền truy cập khu vực quản trị!";
        exit;
    }

    switch ($page) {

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
            $action = $_GET["action"] ?? "index";

            switch ($action) {
                case "create": $ctl->create(); break;
                case "store": $ctl->store(); break;
                case "update": $ctl->update(); break;
                case "delete": $ctl->delete(); break;
                default: $ctl->index(); break;
            }
            break;

        case "get":
            $ctl->get();
            break;
            
        default:
            echo "404 - Admin Page Not Found!";
            break;
    }

    exit;
}


# =============================
#        AUTH ROUTES
# =============================
switch ($page) {

    case "login":
        require "./controllers/AuthController.php";
        (new AuthController())->showLogin();
        break;

    case "doLogin":
        require "./controllers/AuthController.php";
        (new AuthController())->login();
        break;

    case "register":
        require "./controllers/AuthController.php";
        (new AuthController())->showRegister();
        break;

    case "doRegister":
        require "./controllers/AuthController.php";
        (new AuthController())->register();
        break;

    case "logout":
        require "./controllers/AuthController.php";
        (new AuthController())->logout();
        break;

        // 💥 SHOP PAGE CLIENT
    case "shop":
        require "./controllers/client/ShopController.php";
        (new ShopController())->index();
        break;

    
    case "product-detail":
        require "./controllers/client/ShopController.php";
        (new ShopController())->detail();
        break;

    default:
        require "./controllers/client/HomeController.php";
        (new HomeController())->index();
        break;
}

