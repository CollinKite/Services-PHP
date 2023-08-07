<?php
require_once '../Database/dbconnect.php';
require_once 'CustomerUtil.php';
$connection = Connect();
updateCustomer($connection);
?>
