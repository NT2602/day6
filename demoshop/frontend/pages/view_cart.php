<?php session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <?php include_once(__DIR__ . '/../layout/styles.php'); ?>
    <link href="/demoshop/assets/frontend/css/style.css" rel="stylesheet" />
    <style>
        .image {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php include_once(__DIR__ . '/../layout/partials/header.php'); ?>

    <main role="main" class="mb-2">

    </main>
    <?php
    include_once(__DIR__ . '/../../dbconnect.php');
    $conn = connectDb();
    $cart = $_SESSION['cart'] ?? [];
    ?>
    <h1 class="text-center">Your Cart</h1>
    <<div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
        <div id="message">&nbsp;</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table id="tblCart" class="table table-bordered table-hover table-sm mt-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($cart as $item) {
                                $total += $item['price'] * $item['quantity'];
                            ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= number_format($item['price'], 2) ?> VND</td>
                                    <td><input type="number" id="quantity_<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 80px;"></td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 2) ?> VND</td>
                                    <td><img src="/demoshop/assets/<?= $item['image'] ?>" class="image"></td>
                                    <td>
                                        <button class="btn btn-primary btn-update-quantity" data-id="<?= $item['id'] ?>">Update</button>
                                        <button class="btn btn-danger btn-delete-product" data-id="<?= $item['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <a href="/myshop/frontend" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Continue Shopping</a>
                            <a href="/myshop/frontend/pages/checkout.php" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Checkout</a>
                        </tbody>
                    </table>

                    <h3>Total: <?= number_format($total, 2) ?> VND</h3>
                </div>
            </div>
        </div>
        <?php include_once(__DIR__ . '/../layout/partials/footer.php'); ?>
        <?php include_once(__DIR__ . '/../layout/scripts.php'); ?>

</body>
<script>
    $(document).ready(function() {
        function removeProductItem(id) {
            $.ajax({
                url: '/demoshop/frontend/api/delete_cart_item.php',
                method: "POST",
                dataType: 'json',
                data: {
                    id
                },
                success: () => location.reload(),
                error: () => {
                    $('#message').html('<h1>Can not delete item</h1>');
                    $('.alert').removeClass('d-none').addClass('show');
                }
            });
        }

        $('#tblCart').on('click', '.btn-delete-product', function(e) {
            e.preventDefault();
            removeProductItem($(this).data('id'));
        });
        $('.btn-update-quantity').click(function(e) {
            e.preventDefault(); // Đúng chỗ: e được truyền vào callback function

            const id = $(this).data('id');
            const quantity = $('#quantity_' + id).val();

            $.ajax({
                url: '/demoshop/frontend/api/update_cart_item.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    quantity: quantity
                },
                success: function(data) {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra!');
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi gửi yêu cầu.');
                }
            });
        });
        $('.btn-delete-product').click(function() {
            e.preventDefault();

        });


    });
</script>

</html>