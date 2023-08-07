<?php
require_once 'AdminUtil.php';

function createMainCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $name = $data['name'];
    if(empty($name)){
        echo "Category name is empty";
        die();
    }

    $name = mysqli_real_escape_string($conn, $name);
    $query = "INSERT INTO Main_Category (name) VALUES ('$name')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Main Category created successfully";
    } else {
        echo "Error creating main category: " . mysqli_error($conn);
    }
}

function retrieveMainCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['id'])){
        $id = $data['id'];
        $id = mysqli_real_escape_string($conn, $id);
        $query = "SELECT * FROM Main_Category WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 0){
            echo "Category does not exist";
            die();
        }
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        $query = "SELECT * FROM Main_Category";
        $result = mysqli_query($conn, $query);
        $categories = array();
        while($row = mysqli_fetch_assoc($result)){
            $categories[] = $row;
        }
        echo json_encode($categories);
    }
}

function updateMainCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $id = $data['id'];
    $name = $data['name'];
    if(empty($id) || empty($name)){
        echo "ID or name is empty";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $query = "UPDATE Main_Category SET name = '$name' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Main Category updated successfully";
    } else {
        echo "Error updating main category: " . mysqli_error($conn);
    }
}

function deleteMainCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $id = $data['id'];
    if(empty($id)){
        echo "ID is empty";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);

    // Delete all sub-categories linked to this main category
    $subCategoryQuery = "DELETE FROM Sub_Category WHERE main_category_id = '$id'";
    $subCategoryResult = mysqli_query($conn, $subCategoryQuery);
    if(!$subCategoryResult){
        echo "Error deleting linked sub-categories: " . mysqli_error($conn);
        die();
    }

    // Delete the main category
    $mainCategoryQuery = "DELETE FROM Main_Category WHERE id = '$id'";
    $mainCategoryResult = mysqli_query($conn, $mainCategoryQuery);
    if($mainCategoryResult){
        echo "Main Category and linked Sub-Categories deleted successfully";
    } else {
        echo "Error deleting main category: " . mysqli_error($conn);
    }
}
?>
