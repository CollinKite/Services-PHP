<?php
require_once '../Database/dbconnect.php';
require_once 'CustomerUtil.php';
$connection = Connect();
deleteCustomer($connection);
?>
