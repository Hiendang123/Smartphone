<?php
session_start();

// Lấy dữ liệu sản phẩm từ session
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];

// Sắp xếp sản phẩm theo đánh giá (tăng dần) để dễ dàng lấy 5 sản phẩm nổi bật
usort($products, function($a, $b) {
    return (int)filter_var($b['evaluate'], FILTER_SANITIZE_NUMBER_INT) - (int)filter_var($a['evaluate'], FILTER_SANITIZE_NUMBER_INT);
});

// Lấy 5 sản phẩm nổi bật nhất
$featuredProducts = array_slice($products, 0, 5);
// Lấy những sản phẩm còn lại (từ thứ 6 trở đi)
$newProducts = array_slice($products, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>Sản phẩm</title>
    <style>
        
/* Thêm vào file CSS của bạn */
.products {
  display: flex;
  flex-wrap: wrap; /* Cho phép các sản phẩm xuống dòng nếu không đủ chỗ */
  justify-content: space-between; /* Căn giữa các sản phẩm */
  margin: 0 -10px; /* Giảm khoảng cách bên ngoài cho các sản phẩm */
}

.card {
  flex: 1 1 calc(20% - 20px); /* Điều chỉnh tỷ lệ cho từng sản phẩm, 5 sản phẩm trên một hàng */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Thêm bóng cho sản phẩm */
  margin: 10px; /* Khoảng cách giữa các sản phẩm */
  padding: 15px; /* Padding bên trong sản phẩm */
  text-align: center; /* Căn giữa văn bản */
  border-radius: 5px; /* Bo tròn góc sản phẩm */
  background-color: #fff; /* Màu nền cho sản phẩm */
}

.card img {
  max-width: 100%; /* Đảm bảo ảnh không vượt quá kích thước sản phẩm */
  height: auto; /* Đảm bảo tỷ lệ ảnh */
  border-radius: 5px; /* Bo tròn góc ảnh */
}

    </style>
</head>
<body>
    <!-- Header menu -->
    <header>
        <div class="container">
            <h1>SMARTPHONE</h1>
            <div class="timkiem">
                <div class="group">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                    <g>
                    <path
                        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
                    ></path>
                    </g>
                </svg>
                <input class="input" type="search" placeholder="Nhập từ khóa cần tìm kiếm..." />
                </div>
                <div class="tukhoa">
                <p style="font-weight: bold;">Từ khóa:</p>
                <p>SamSung </p>
                <p>iPhone</p>
                <p>Huawei</p>
                <p>Oppo</p>
                <p>Mobi</p>
            </div>
            </div>
            <div class="dangnhap">
                <i class="fa-solid fa-cart-shopping"></i><a class="giohang" href="" style="font-weight: bold; font-size: 18px;">Giỏ hàng</a>
                <i class="fa-solid fa-user"></i><a class="taikhoan" href="login.php" style="font-weight: bold; font-size: 18px;">Đăng xuất</a>
            </div>
        </div>
    </header>
    <section>
        <div class="spnoibat">
            <h2 class="tieude"><i class="fa-solid fa-star"></i>Nổi bật nhất<i class="fa-solid fa-star"></i></h2>
            <div class="products">
                <tbody>
                    <?php foreach ($featuredProducts as $product): ?>
                        <div class="card">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                            <h3><?= $product['name'] ?></h3>
                            <p>Giá: <?= $product['price'] ?></p>
                            <p>Đánh giá: <?= $product['evaluate'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </div>
        </div>
    </section>
    
    <section>
        <div class="spmoi">
            <h2 class="tieude2"><i class="fa-solid fa-star"></i>Sản phẩm mới<i class="fa-solid fa-star"></i></h2>
            <div class="products">
                <tbody>
                    <?php foreach ($newProducts as $product): ?>
                        <div class="card">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                            <h3><?= $product['name'] ?></h3>
                            <p>Giá: <?= $product['price'] ?></p>
                            <p>Đánh giá: <?= $product['evaluate'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </div>
        </div>
    </section>
</body>
</html>

