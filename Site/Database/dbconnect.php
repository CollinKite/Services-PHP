<?php
define('DB_USER', 'root');
define('DB_PASSWORD', 'test');
define('DB_HOST', 'localhost');
define('DB_NAME', 'movie_recommendations');

// CONNECT TO MySQL
function Connect()
{
    $dbConn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Failed to connect to MySQL ' . DB_NAME . '::' . mysqli_connect_error());
    return $dbConn;
}
?>
