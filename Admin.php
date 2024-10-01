<?php
session_start();

// Khởi tạo mảng sản phẩm
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        ["id" => 1, "name" => 'Nokia 105 DS Pro 4G', "price" => '990.000', "evaluate" => '999 đánh giá', "image" => './img/Nokia.jpg'],
        ["id" => 2, "name" => 'OPPO A3 8GB 256GB', "price" => '6.450.000', "evaluate" => '1.420 đánh giá', "image" => './img/OppoA3.jpg'],
        ["id" => 3, "name" => 'Xiaomi Poco M6 Pro 12GB 512GB', "price" => '6.990.000', "evaluate" => '512 đánh giá', "image" => './img/XiaomiPoco.png'],
        ["id" => 4, "name" => 'Vivo Y03 4GB 64GB', "price" => '2.990.000', "evaluate" => '420 đánh giá', "image" => './img/VivoY03.jpg'],
        ["id" => 5, "name" => 'Samsung Galaxy Z Flip4 5G 128GB', "price" => '11.990.000', "evaluate" => '2.620 đánh giá', "image" => './img/SamsungZFlip.jpg'],
        ["id" => 6, "name" => 'iPhone 16 Pro Max 256GB', "price" => '34.990.000', "evaluate" => '10.400 đánh giá', "image" => './img/iphone16.png'],
        ["id" => 7, "name" => 'Honor X9B 5G 12GB-256GB', "price" => '7.990.000', "evaluate" => '526 đánh giá', "image" => './img/Honor.jpg'],
        ["id" => 8, "name" => 'TECNO POVA 6 8GB-256GB', "price" => '5.890.000', "evaluate" => '932 đánh giá', "image" => './img/Tecno.png'],
        ["id" => 9, "name" => 'Realme C61 6GB 128GB', "price" => '3.990.000', "evaluate" => '1.000 đánh giá', "image" => './img/realme.jpg'],
        ["id" => 10, "name" => 'Masstel Fami 60S 4G', "price" => '700.000', "evaluate" => '99 đánh giá', "image" => './img/masstel.png'],
    ];
}

// Mảng sản phẩm đã xóa
if (!isset($_SESSION['deleted_products'])) {
    $_SESSION['deleted_products'] = [];
}

$products = $_SESSION['products'];
$deletedProducts = $_SESSION['deleted_products'];

// Hàm xóa sản phẩm
function deleteProduct(&$products, $idToDelete) {
    foreach ($products as $key => $product) {
        if ($product['id'] == $idToDelete) {
            unset($products[$key]);
            return $product;
        }
    }
    return null;
}

// Hàm khôi phục sản phẩm
function restoreProduct(&$deletedProducts, $idToRestore) {
    foreach ($deletedProducts as $key => $product) {
        if ($product['id'] == $idToRestore) {
            unset($deletedProducts[$key]);
            return $product;
        }
    }
    return null;
}

// Tìm kiếm
$searchResults = $products;
if (isset($_POST['submit_search'])) {
    $search = trim($_POST['search']);
    if (!empty($search)) {
        $searchResults = array_filter($products, function ($product) use ($search) {
            return stripos($product['name'], $search) !== false ||
                   strpos($product['price'], $search) !== false ||
                   strpos($product['evaluate'], $search) !== false;
        });
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $deletedProduct = deleteProduct($products, $idToDelete);
    if ($deletedProduct) {
        $_SESSION['deleted_products'][] = $deletedProduct;
    }
    $_SESSION['products'] = array_values($products);
    header('Location: Admin.php');
    exit();
}

// Xử lý khôi phục sản phẩm
if (isset($_GET['restore'])) {
    $idToRestore = $_GET['restore'];
    $restoredProduct = restoreProduct($deletedProducts, $idToRestore);
    if ($restoredProduct) {
        $_SESSION['products'][] = $restoredProduct;
    }
    $_SESSION['deleted_products'] = array_values($deletedProducts);
    header('Location: Admin.php');
    exit();
}

// Xử lý sửa sản phẩm
$editProduct = null;
if (isset($_GET['edit'])) {
    $idToEdit = $_GET['edit'];
    foreach ($products as $product) {
        if ($product['id'] == $idToEdit) {
            $editProduct = $product;
            break;
        }
    }
}

if (isset($_POST['save'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['products'] as &$product) {
        if ($product['id'] == $id) {
            $product['name'] = $_POST['name'];
            $product['price'] = $_POST['price'];
            $product['evaluate'] = $_POST['evaluate'];
            $product['image'] = $_POST['image'];
            break;
        }
    }
    header('Location: Admin.php');
    exit();
}

if (isset($_POST['cancel'])) {
    header('Location: Admin.php');
    exit();
}

// Xử lý thêm sản phẩm
if (isset($_POST['add_product'])) {
    $newProduct = [
        "id" => count($_SESSION['products']) + 1, // Tạo ID tự động
        "name" => $_POST['name'],
        "price" => $_POST['price'],
        "evaluate" => $_POST['evaluate'],
        "image" => $_POST['image']
    ];
    $_SESSION['products'][] = $newProduct; // Thêm sản phẩm mới vào mảng
    header('Location: Admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Danh sách sản phẩm</title>
    <style>
        .form-edit, .form-add {
            width: 30%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 8px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: auto;
            line-height: 20px;
            background-color: white;
        }
        .tieude {
            text-align: center;
            margin-bottom: 20px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Danh sách sản phẩm</h1>

    <!-- Form tìm kiếm -->
    <form action="Admin.php" method="POST">
        <input class="timsp" type="text" name="search" placeholder="Nhập từ khóa tìm kiếm">
        <button class="btn" type="submit" name="submit_search">Tìm kiếm</button>
        <button class="them-btn" type="submit" name="add">Thêm sản phẩm</button>
        <a href="Admin.php"><button class="hien-btn" type="button">Hiển thị tất cả sản phẩm</button></a>
        <a href="login.php"><button class="hien-btn" type="button">Đăng xuất</button></a>
    </form>

    <!-- Hiển thị kết quả tìm kiếm -->
    <div class="products">
        <table class="bang">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Đánh giá</th>
                <th>Ảnh</th>
                <th>Tác vụ</th>
            </tr>
            <?php if (!empty($searchResults)) : ?>
                <?php foreach ($searchResults as $product) : ?>
                <tr>
                    <td><?= $product["id"] ?></td>
                    <td><?= $product["name"] ?></td>
                    <td><?= $product["price"] ?></td>
                    <td><?= $product["evaluate"] ?></td>
                    <td><img src="<?= $product["image"] ?>" alt=""></td>
                    <td>
                        <button class="suabtn"><a class="sua" href="Admin.php?edit=<?= $product["id"] ?>">Sửa</a></button>
                        <button class="xoabtn"><a class="xoa" href="Admin.php?delete=<?= $product["id"] ?>">Xóa</a></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có sản phẩm nào!</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

<!-- Hiển thị form thêm sản phẩm -->
<?php if (isset($_POST['add'])) : ?>
<div class="form-add" id="form-add">
    <h2 class="tieude">Thêm sản phẩm</h2>
    <form class="form-them " action="Admin.php" method="POST" onsubmit="return validateForm('form-add');">
        <label for="name">Tên sản phẩm: </label>
        <input type="text" id="namesanpham" name="name" required> <br>
        <label for="price">Giá: </label>
        <input type="text" id="giasanpham" name="price" required> <br>
        <label for="evaluate">Đánh giá: </label>
        <input type="text" id="danhgiasanpham" name="evaluate" required> <br>
        <label for="image">Ảnh: </label>
        <input type="text" id="anh" name="image" required> <br>
        <button class="btn-save" type="submit" name="add_product">Thêm</button>
        <button type="button" class="btn-cancel" onclick="cancelForm('form-add');">Hủy</button>
    </form>
</div>
<?php endif; ?>

<!-- Hiển thị form sửa sản phẩm -->
<?php if ($editProduct) : ?>
<div class="form-edit" id="form-edit">
    <h2 class="tieude">Sửa sản phẩm</h2>
    <form class="form-sua" action="Admin.php" method="POST">
    <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
            <label for="name">Tên sản phẩm: </label>
            <input type="text" id="namesanpham" name="name" value="<?= $editProduct['name'] ?>"> <br>
            <label for="price">Giá: </label>
            <input type="text" id="giasanpham" name="price" value="<?= $editProduct['price'] ?>"> <br>
            <label for="evaluate">Đánh giá: </label>
            <input type="text" id="danhgiasanpham" name="evaluate" value="<?= $editProduct['evaluate'] ?>"> <br>
            <label for="image">Ảnh: </label>
            <input type="text" id="anh" name="image" value="<?= $editProduct['image'] ?>"> <br>
            <button class="btn-save" type="submit" name="save">Lưu</button>
            <button class="btn-cancel" type="submit" name="cancel" onclick="cancelForm('form-add');">Hủy</button>
    </form>
</div>
<?php endif; ?>

<script>
function cancelForm(formId) {
    // Xóa thông tin trong form
    document.getElementById(formId).querySelector('form').reset();

    // Ẩn form
    document.getElementById(formId).style.display = 'none';
}
</script>


    <h2>Danh sách sản phẩm đã xóa</h2>
    <div class="deleted-products">
        <table class="bang">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Đánh giá</th>
                <th>Ảnh</th>
                <th>Tác vụ</th>
            </tr>
            <?php if (!empty($deletedProducts)) : ?>
                <?php foreach ($deletedProducts as $product) : ?>
                <tr>
                    <td><?= $product["id"] ?></td>
                    <td><?= $product["name"] ?></td>
                    <td><?= $product["price"] ?></td>
                    <td><?= $product["evaluate"] ?></td>
                    <td><img src="<?= $product["image"] ?>" alt=""></td>
                    <td>
                        <button class="restore-btn"><a class="restore" href="Admin.php?restore=<?= $product["id"] ?>">Khôi phục</a></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có sản phẩm nào đã xóa!</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
