<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');

$conn = connectDb();
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID sản phẩm không hợp lệ.');
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT id, name, price, description, stock_quantity, image_url, category FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die('Không tìm thấy sản phẩm.');
}

// Giả định có danh sách ảnh phụ (ở đây chỉ dùng lại ảnh chính để minh họa)
$productImages = [
    $product['image_url'],
    $product['image_url'],
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <?php include_once('../layout/styles.php'); ?>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .preview-pic img {
            max-height: 600px;
            object-fit: contain;
        }

        .preview-thumbnail img {
            max-height: 70px;
        }

        .product-title,
        .price,
        .sizes,
        .colors {
            text-transform: uppercase;
            font-weight: bold;
        }

        .checked {
            color: #ff9f1a;
        }

        .add-to-cart,
        .like {
            background: #ff9f1a;
            padding: 1.2em 1.5em;
            border: none;
            text-transform: uppercase;
            font-weight: bold;
            color: #fff;
            transition: background .3s ease;
        }

        .add-to-cart:hover,
        .like:hover {
            background: #b36800;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <?php include_once('../layout/partials/header.php'); ?>
    <main role="main" class="container mt-4">
        <div class="container">
            <br>
            <br>
        </div>
        <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
            <div id="message">&nbsp;</div>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div style="height: 100px;"></div>

        <!-- Product Detail Card -->
        <div class="card mb-4">
            <div class="row">
                <!-- LEFT: Hình ảnh -->
                <div class="col-md-5 text-center p-4">
                    <div class="preview-pic mb-3">
                        <img src="/demoshop/assets/shared/img/<?= htmlspecialchars($product['image_url']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="img-fluid">
                    </div>

                    <ul class="preview-thumbnail nav nav-tabs justify-content-center">
                        <?php foreach ($productImages as $img): ?>
                            <li class="mx-1">
                                <img src="/demoshop/assets/shared/img/<?= htmlspecialchars($img) ?>"
                                    alt="thumbnail"
                                    class="img-thumbnail">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- RIGHT: Thông tin sản phẩm -->
                <div class="col-md-7 p-4 details">
                    <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                    <div class="rating mb-2">
                        <div class="stars">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <span class="review-no">999 lượt đánh giá</span>
                    </div>
                    <p class="product-description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    <h4 class="price">Giá: <span><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</span></h4>
                    <h5 class="sizes">sizes:
                        <span class="size">S</span>
                        <span class="size">M</span>
                        <span class="size">L</span>
                        <span class="size">XL</span>
                    </h5>
                    <h5 class="colors">colors:
                        <span class="color orange"></span>
                        <span class="color green"></span>
                        <span class="color blue"></span>
                    </h5>

                    <div class="form-group mb-3">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" class="form-control w-50" id="quantity" name="quantity" min="1" value="1">
                    </div>

                    <div class="action">
                        <button class="add-to-cart btn" id="btnAddCart">Thêm vào giỏ</button>
                        <a class="like btn btn-outline-secondary" href="#"><span class="fa fa-heart"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chi tiết mô tả -->
        <div class="card">
            <div class="container-fluid p-4">
                <h3 class="mb-3">Mô tả chi tiết</h3>
                <div class="row">
                    <div class="col">
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once('../layout/partials/footer.php'); ?>
    <?php include_once('../layout/scripts.php'); ?>

    <script>
        function handleAddCart() {
            var data = {
                id: <?= $product['id'] ?>,
                name: "<?= htmlspecialchars($product['name']) ?>",
                price: <?= $product['price'] ?>,
                image: "<?= htmlspecialchars($product['image_url']) ?>",
                category: "<?= $product['category'] ?>",
                quantity: $('#quantity').val()
            };

            $.ajax({
                url: '/demoshop/frontend/api/addCart.php',
                method: "POST",
                dataType: 'json',
                data: data,
                success: function(response) {
                    var htmlString = `✅ Sản phẩm đã được thêm! <a href="/demoshop/frontend/pages/viewCart.php">Xem giỏ hàng</a>`;
                    $('#message').html(htmlString);
                    $('#alert-container').removeClass('d-none').addClass('show');
                },
                error: function() {
                    var htmlString = `<h5>❌ Không thể thêm vào giỏ hàng.</h5>`;
                    $('#message').html(htmlString);
                    $('#alert-container').removeClass('d-none').addClass('show');
                }
            });
        }

        $('#btnAddCart').click(function(e) {
            e.preventDefault();
            handleAddCart();
        });
    </script>
</body>

</html>