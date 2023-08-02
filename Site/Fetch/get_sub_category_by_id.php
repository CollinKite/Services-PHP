<?php
// Assuming you have the database connection code in dbconnect.php
include_once '../Database/dbconnect.php';

// Function to fetch subcategory data by category ID from the database
function getSubCategoryById($categoryId)
{
    $dbConn = Connect();

    // Escape the category ID to prevent SQL injection
    $categoryId = mysqli_real_escape_string($dbConn, $categoryId);

    $query = "SELECT * FROM Sub_Category WHERE id = $categoryId";

    $result = mysqli_query($dbConn, $query);

    if (!$result) {
        die('Error executing the query: ' . mysqli_error($dbConn));
    }

    // Assuming the ID is unique, fetch the single row result
    $subcategory = mysqli_fetch_assoc($result);

    mysqli_close($dbConn);

    return $subcategory;
}

$subCategoryId = $_GET['category'];
$subCategory = getSubCategoryById($subCategoryId);
// Return JSON response
header('Content-Type: application/json');
echo json_encode($subCategory);
?>
