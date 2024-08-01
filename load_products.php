<?php
require_once 'assets/includes/pdo.php';

$query = "SELECT 
    * from products WHERE product_name LIKE '%{$_GET['term']}%'
            LIMIT 0, 5";



echo json_encode($pdo->customQuery($query));
?>
