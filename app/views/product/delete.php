<div class="btn"><?= \Core\Url::getLink('/product/list', 'Повернутись до переліку всіх товарів'); ?></div>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    Ви дійсно бажаєте вилучити товар:  <br>
    <input type='submit' name='delete' value='Так'>
    <input type='submit' name='delete' value='Hі'>
</form>

<!-- перевірка знизу для вирішення -->
<?php
//echo '<pre>';
//var_dump($_POST);
//echo '<pre>';
//var_dump(filter_input(INPUT_GET,'id'));

