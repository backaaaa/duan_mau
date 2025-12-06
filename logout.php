<?php
session_start();

// Xoá toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang login
header("Location: views/login.php");
exit();
