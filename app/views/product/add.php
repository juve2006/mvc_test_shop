<div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
   Назва товару: <input  type='text' name='product_name' value=''> <br>
   Ціна товару: <input type='text' name='product_price' value=''> <br>
    Код товару: <input type='text' name='product_sku' value=''> <br>
    Кількість товару: <input type='text' name='product_qty' value=''> <br>
    <input type='submit' name='button_add' value='Добавити товар'>
</form>


<?php
    if (isset($_POST['button_add'])) {

}
    /* щоб добавивися в бд тут або в модель перенести
TODO
*/