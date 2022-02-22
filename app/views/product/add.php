<div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>
<h1> Додавання товару </h1>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
   Назва товару:
    <input  type='text' name='name' value='<?php echo filter_input(INPUT_POST,'name') !== null ? filter_input(INPUT_POST,'name') : ''?>'> <br>
   Ціна товару:
    <input type='text' name='price' value='<?php echo filter_input(INPUT_POST,'price') !== null ? filter_input(INPUT_POST,'price') : ''?>'> <br>
    Код товару:
    <input type='text' name='sku' value='<?php echo filter_input(INPUT_POST,'sku') !== null ? filter_input(INPUT_POST,'sku') : ''?>'> <br>
    Кількість товару:
    <input type='text' name='qty' value='<?php echo filter_input(INPUT_POST,'qty') !== null ? filter_input(INPUT_POST,'qty') : ''?>'> <br>

    <input type='submit' name='add' value='Додати товар'>
</form>

<?php
//
//echo "<pre>";
//var_dump($_POST);
//echo "<pre>";
