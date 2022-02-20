<div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
   Назва товару: <input  type='text' name='name' value=''> <br>
   Ціна товару: <input type='text' name='price' value=''> <br>
    Код товару: <input type='text' name='sku' value=''> <br>
    Кількість товару: <input type='text' name='qty' value=''> <br>
    <input type='submit' name='button_add' value='Додати товар'>
</form>


