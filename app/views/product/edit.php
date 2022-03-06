<?php

$product = $this->get('product');

?>
    <div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>
    <h1> Редагування товару </h1>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <p>Назва товару <label>
                <input name="name" type="text" value="<?php echo $product['name']; ?>">
            </label></p>
        <p>Код товару <label>
                <input name="sku" type="text" value="<?php echo $product['sku']; ?>">
            </label></p>
        <p>Ціна товару <label>
                <input name="price" type="text" value="<?php echo $product['price']; ?>">
            </label></p>
        <p>Кількість товару <label>
                <input name="qty" type="text" value="<?php echo $product['qty']; ?>">
            </label></p>
         Опис товару <label>
            <textarea name="description" rows="3" cols="50" maxlength="255"> <?php echo htmlspecialchars_decode($product['description']);?> </textarea>
        </label>

        <input type='submit' name='edit' value='Редагувати товар'>
    </form>

<?php
//
//echo "<pre>";
//var_dump($_POST);
//echo "<pre>";
