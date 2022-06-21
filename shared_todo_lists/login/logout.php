<?php
require_once('../class/util/Security.php');
Security::session();

unset($_SESSION['user'], $_SESSION['err'], $_SESSION['success'], $_SESSION['post'], $_SESSION['data']);
header('Location:./index.php');
exit();
