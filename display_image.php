<?php
require_once 'assets/includes/pdo.php';


$table = $_GET['t'];
$columnImage = $_GET['i'];
$columnType = $_GET['it'];
$id = $_GET['id'];

$pdo->outputImage($table, $id, "id", [$columnImage], $columnType);








