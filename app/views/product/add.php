<div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>
<h1> Додавання товару </h1>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
   Назва товару:
    <label>
        <input  type='text' name='name'>
    </label> <br>
   Ціна товару:
    <label>
        <input type='text' name='price'>
    </label> <br>
    Код товару:
    <label>
        <input type='text' name='sku'>
    </label> <br>
    Кількість товару:
    <label>
        <input type='text' name='qty'>
    </label> <br>
    Опис товару:
    <label>
        <input type='text' name='description'>
    </label> <br>
   
    <input type='submit' name='add' value='Додати товар'>
</form>

<?php
//
//echo "<pre>";
//var_dump($_POST);
//echo "<pre>";
