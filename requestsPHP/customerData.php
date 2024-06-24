<?php 
session_start();
require_once '../assets/includes/pdo.php';

    $onecus = $pdo->read("sales_2", ['id' => $_POST['cusId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
            ?>
<tr>

    <td><?php echo $onecus[0]['customer_name']; ?></td>


</tr>
