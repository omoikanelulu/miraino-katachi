<?php
require_once('../class/util/Security.php');
Security::session();

unset($_SESSION['user'], $_SESSION['err']);
header('Location:./index.php');
exit();
