<?php
    include_once 'AdminUtil.php';
    include_once '../Database/dbconnect.php';
    $conn = Connect();
    updateAdmin($conn);
?>