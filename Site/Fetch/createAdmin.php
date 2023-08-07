<?php
    include_once 'AdminUtil.php';
    include_once '../Database/dbconnect.php';
    $conn = Connect();
    createAdmin($conn);
?>