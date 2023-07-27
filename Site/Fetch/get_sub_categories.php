<?php
include_once '../Database/dbconnect.php';

// Function to fetch subcategories for a given main category from the database
function getSubCategories($mainCategoryId) {
    $dbConn = Connect();
    $query = "SELECT * FROM SubCategory WHERE fk_main = '$mainCategoryId'";
    $result = mysqli_query($dbConn, $query);

    if (!$result) {
        die('Error executing the query: ' . mysqli_error($dbConn));
    }

    $subCategories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $subCategories[] = $row;
    }

    mysqli_close($dbConn);
    return $subCategories;
}

$mainCategoryId = $_GET['mainCategoryId'];
$subCategories = getSubCategories($mainCategoryId);
// Return JSON response
header('Content-Type: application/json');
echo json_encode($subCategories);
?>
