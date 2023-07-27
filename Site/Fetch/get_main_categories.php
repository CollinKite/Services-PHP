<?php
include_once '../Database/dbconnect.php';


function getAllMainCategories()
{
    $dbConn = Connect();
    $query = "SELECT * FROM MainCategory";
    $result = mysqli_query($dbConn, $query);

    if (!$result) {
        die('Error executing the query: ' . mysqli_error($dbConn));
    }

    $categories = array();
    //mysqli_fetch_assoc means that I can reference the result by column name, instead of index, very nice
    while ($row = mysqli_fetch_assoc($result)) { // Loop through the query results
        $categories[] = $row;
    }

    mysqli_close($dbConn);
    return $categories;
}

// Call the function and return JSON response
header('Content-Type: application/json');
echo json_encode(getAllMainCategories());
?>