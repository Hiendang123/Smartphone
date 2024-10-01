

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .btn-login {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 20px;
        }
        .login-sanpham {
            width: 20%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 8px;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: auto;
            line-height: 20px;
            background-color: white;
        }
        .login {
            margin-left: 20px;
            line-height: 50px;
        }
        .remember {
            margin-left: 30px;
        }
        #email, #pass {
            border: none; /* Loại bỏ viền mặc định */
            border-bottom: 2px solid #000; /* Thêm viền ở phía dưới */
            padding: 5px;
            outline: none; /* Loại bỏ đường viền khi click vào */
        }
        #email:focus, #pass:focus {
            border-bottom: 2px solid #007bff;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="login-sanpham">
        <table cellpadding="5" cellspacing="10" align="center" class="login">
            <h3 style="text-align:center; margin-top:20px; margin-bottom: 40px;">Login</h3>
            <form class="login" action="Validate.php" method="post">
                <tr><th>Email</th><td><input type="text" id="email" name="email"></td></tr>
                <tr><th>Password</th><td><input type="password" id="pass" name="password"></td></tr>
                <tr><td colspan="2" align="center"><input class="remember" type="checkbox" name="remember" value="1" checked>Remember me</td></tr>
                <tr><td colspan="2" align="center"><input type="submit" value="Login" name="login" class="btn-login"></td></tr>
            </form>
        </table>
    </div>
</body>
</html>

<?php
    if(isset($_GET['error'])) {
        echo "<script>
            swal({
                title: 'Lỗi!',
                text: '".$_GET['error']."',
                icon: 'error',
                button: 'OK',
            });
        </script>";
    }
    
    if(isset($_COOKIE['email']) and isset($_COOKIE['pass'])){
        $email = $_COOKIE['email'];
        $pass = $_COOKIE['pass'];
        echo"<script>
            document.getElementById('email').value = '$email';
            document.getElementById('pass').value = '$pass';
        </script>";
}
?>
