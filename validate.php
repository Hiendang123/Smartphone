<?php
// Thông tin đăng nhập admin
$adminEmail = "admin@vtc.com";
$adminPass = "1008";

// Thông tin đăng nhập người dùng
$users = [
    ['email' => 'hiendang@vtc.com', 'password' => '123456'],
    ['email' => 'hiendang123@vtc.com', 'password' => '123456']
];

if (isset($_POST['login'])) {
    // Kiểm tra xem email và password có được nhập vào không.
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Vui lòng nhập email và mật khẩu.";
        header("Location: login.php?error=" . urlencode($error));
        exit();
    } else {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        // Kiểm tra thông tin đăng nhập cho admin
        if ($email == $adminEmail && $pass == $adminPass) {
            // Nếu thông tin đăng nhập hợp lệ, kiểm tra xem người dùng có chọn "Remember me" không
            if (isset($_POST['remember'])) {
                // Nếu chọn "Remember me", lưu email và mật khẩu vào cookie
                setcookie('email', $email, time() + 86400); // Lưu email vào cookie trong 1 ngày
                setcookie('pass', $pass, time() + 86400);   // Lưu mật khẩu vào cookie trong 1 ngày
            }
            
            // Bắt đầu phiên làm việc (session) để lưu thông tin người dùng
            session_start();
            
            // Lưu email của quản trị viên vào biến phiên
            $_SESSION['email'] = $email;
            
            // Chuyển hướng người dùng đến trang quản trị admin
            header('Location: Admin.php'); // Chuyển hướng đến Admin.php
            exit(); // Dừng thực thi mã sau khi chuyển hướng để không thực hiện các lệnh sau
        }

        // Kiểm tra thông tin đăng nhập cho người dùng
        $isUserValid = false;
        foreach ($users as $user) {
            if ($email == $user['email'] && $pass == $user['password']) {
                $isUserValid = true;
                break;
            }
        }

        // Nếu là người dùng hợp lệ
        if ($isUserValid) {
            if (isset($_POST['remember'])) {
                setcookie('email', $email, time() + 60 * 60 * 7);
                setcookie('pass', $pass, time() + 60 * 60 * 7);
            }
            session_start();
            $_SESSION['email'] = $email;
            header('Location: welcome.php'); // Chuyển hướng đến welcome.php
            exit();
        } else {
            $error = "Email hoặc mật khẩu không hợp lệ.";
            header("Location: login.php?error=" . urlencode($error)); // Chuyển hướng về login với thông báo lỗi
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
