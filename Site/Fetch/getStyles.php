<?php
require_once '../Database/dbconnect.php';
require_once 'StyleUtil.php';
$connection = Connect();
getStyles($connection);
?>
