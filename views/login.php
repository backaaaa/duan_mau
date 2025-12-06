<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }
        .auth-box {
            max-width: 420px;
            margin: 70px auto;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
        }
        .logo {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <div class="auth-box">
        <div class="logo">🛍️ MyShop</div>

        <h4 class="text-center mb-4">Đăng nhập</h4>

        <form action="index.php?page=doLogin" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email">
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
            </div>

            <button class="btn btn-primary mt-2">Đăng nhập</button>

            <p class="text-center mt-3">
                Chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a>
            </p>
        </form>
    </div>
</body>
</html>
