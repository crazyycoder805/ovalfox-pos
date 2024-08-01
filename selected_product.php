<?php
require_once 'assets/includes/pdo.php';

$query = "SELECT * from products WHERE id = {$_POST['id']}";



echo json_encode($pdo->customQuery($query));
?>
