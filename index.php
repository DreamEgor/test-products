<?php
require 'CProducts.php';

// Создание объекта класса
$products = new CProducts();

// Получение списка товаров
$productList = $products->getProducts();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список товаров</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Артикул</th>
        <th>Количество</th>
        <th>Дата создания</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($productList as $product): ?>
        <tr data-id="<?= $product['ID'] ?>">
            <td><?= $product['ID'] ?></td>
            <td><?= $product['PRODUCT_NAME'] ?></td>
            <td><?= $product['PRODUCT_PRICE'] ?></td>
            <td><?= $product['PRODUCT_ARTICLE'] ?></td>
            <td>
                <button class="decrease">-</button>
                <span><?= $product['PRODUCT_QUANTITY'] ?></span>
                <button class="increase">+</button>
            </td>
            <td><?= $product['DATE_CREATE'] ?></td>
            <td><button class="hide">Скрыть</button></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('.hide').click(function () {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.post('hide_product.php', { id: id }, function (response) {
                if (response.success) {
                    row.remove();
                } else {
                    alert('Ошибка при скрытии товара.');
                }
            }, 'json');
        });

        $('.increase, .decrease').click(function () {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const span = row.find('span');
            let quantity = parseInt(span.text());
            quantity += $(this).hasClass('increase') ? 1 : -1;

            if (quantity < 0) return;

            $.post('update_quantity.php', { id: id, quantity: quantity }, function (response) {
                if (response.success) {
                    span.text(quantity);
                } else {
                    alert('Ошибка при обновлении количества.');
                }
            }, 'json');
        });
    });
</script>
</body>
</html>
