<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');

session_start();
session_regenerate_id(true);

unset($_SESSION['user']);
header('Location:./login.php');
exit();