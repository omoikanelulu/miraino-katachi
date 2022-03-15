<?php
session_start();
session_regenerate_id(true);

$_SESSION['cart'][] = $_POST;

header('Location: ./index.php');
exit();