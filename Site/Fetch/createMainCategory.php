<?php
require_once '../Database/dbconnect.php';
require_once 'MainUtil.php';
$connection = Connect();
createMainCategory($connection);
?>
