<h1> Вхід </h1>
<form method = "POST" action="<?php $_SERVER['PHP_SELF']; ?>">
   Введіть e-mail:
    <label>
        <input  type ='email' name ='email'>
    </label> <br>
    Введіть пароль:
    <label>
        <input type ='password' name ='password'>
    </label> <br>

    <input type = 'submit' name = 'login' value="Ввести">
</form>

<?php

var_dump($_SESSION);

var_dump($_POST);