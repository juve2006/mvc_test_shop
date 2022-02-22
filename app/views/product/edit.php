<?php

$product = $this->get('product');

?>
    <div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>
    <h1> Редагування товару </h1>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <p>Назва товару <input name="name" type="text" value="<?php echo $product['name']; ?>"></p>
        <p>Код товару<input name="sku" type="text" value="<?php echo $product['sku']; ?>"></p>
        <p>Ціна товару <input name="price" type="text" value="<?php echo $product['price']; ?>"></p>
        <p>Кількість товару <input name="qty" type="text" value="<?php echo $product['qty']; ?>"></p>

        <input type='submit' name='edit' value='Редагувати товар'>
    </form>

<?php
//
//echo "<pre>";
//var_dump($_POST);
//echo "<pre>";
