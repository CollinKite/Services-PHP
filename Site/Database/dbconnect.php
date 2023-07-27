<?php
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', 'Your_password123');
DEFINE('DB_HOST', 'db');
DEFINE('DB_NAME', 'CSC270');

// CONNECT TO MySQL
function Connect()
{
    $dbConn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Failed to connect to MySQL ' . DB_NAME . '::' . mysqli_connect_error());
    return $dbConn;
}
?>
