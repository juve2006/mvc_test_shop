<?php
define('ROOT', getcwd());
define('DS', DIRECTORY_SEPARATOR);
include ROOT . '/app/bootstrap.php';
	echo '<pre>';
	var_dump($_SERVER['REQUEST_URI']);