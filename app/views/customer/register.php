<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
<h1>Реєстрація</h1>
<h2>Заповніть форму</h2>
<hr>

<label for="first_name"><b>Ім'я</b></label>
<input type="text" placeholder="Введіть Ім'я" name="first_name" required>
<br>

<label for="last_name"><b>Призвіще</b></label>
<input type="text" placeholder="Введіть призвіще" name="last_name" required>
<br>

<label for="telephone"><b>Телефон</b></label>
<input type="text" placeholder="Введіть телефон" name="telephone" required>
<br>

<label for="city"><b>Місто</b></label>
<input type="text" placeholder="Введіть місто" name="city" required>
<br>

<label for="email"><b>Email</b></label>
<input type="text" placeholder="Введіть Email" name="email" required>
<br>

<label for="psw"><b>Пароль</b></label>
<input type="password" placeholder="Введіть пароль" name="password" required>
<br>

<label for="psw-repeat"><b>Повторіть пароль</b></label>
<input type="password" placeholder="Повторіть пароль" name="password-repeat" required>
<br>
<hr>


<input type="submit" name="submit" value="Зареєструватись">
</form>
<?php

var_dump($_SESSION);

var_dump($_POST);