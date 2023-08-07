<?php
require_once 'AdminUtil.php';

function createSubCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $title = $data['title'];
    $desc = $data['desc'];
    $cost = $data['cost'];
    $main_category_id = $data['main_category_id'];

    if(empty($title) || empty($desc) || empty($cost) || empty($main_category_id)){
        echo "Some fields are empty";
        die();
    }

    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);
    $cost = mysqli_real_escape_string($conn, $cost);
    $main_category_id = mysqli_real_escape_string($conn, $main_category_id);

    $query = "INSERT INTO Sub_Category (title, cost, main_category_id, `desc`) VALUES ('$title', '$cost', '$main_category_id', '$desc')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Sub Category created successfully";
    } else {
        echo "Error creating sub category: " . mysqli_error($conn);
    }
}

function retrieveSubCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if(isset($data['id'])){
        $id = mysqli_real_escape_string($conn, $data['id']);
        
        // Join with Main_Category to get the main category name
        $query = "SELECT Sub_Category.*, Main_Category.name as main_category_name 
                  FROM Sub_Category 
                  JOIN Main_Category ON Sub_Category.main_category_id = Main_Category.id 
                  WHERE Sub_Category.id = '$id'";
        
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) == 0){
            echo "Sub Category does not exist";
            die();
        }
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        // Join with Main_Category to get the main category name for all sub-categories
        $query = "SELECT Sub_Category.*, Main_Category.name as main_category_name 
                  FROM Sub_Category 
                  JOIN Main_Category ON Sub_Category.main_category_id = Main_Category.id";
        
        $result = mysqli_query($conn, $query);
        $subCategories = array();
        
        while($row = mysqli_fetch_assoc($result)){
            $subCategories[] = $row;
        }
        echo json_encode($subCategories);
    }
}

function updateSubCategory($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $id = $data['id'];
    $title = $data['title'];
    $desc = $data['desc'];
    $cost = $data['cost'];
    $main_category_id = $data['main_category_id'];

    if(empty($id) || empty($title) || empty($desc) || empty($cost) || empty($main_category_id)){
        echo "Some fields are empty";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);
    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);
    $cost = mysqli_real_escape_string($conn, $cost);
    $main_category_id = mysqli_real_escape_string($conn, $main_category_id);

    $query = "UPDATE Sub_Category SET title = '$title', `desc` = '$desc', cost = '$cost', main_category_id = '$main_category_id' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Sub Category updated successfully";
    } else {
        echo "Error updating sub category: " . mysqli_error($conn);
    }
}


function deleteSubCategory($conn) {
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

    // Delete all entries in the Customers table that link to this sub-category
    $query = "DELETE FROM Customer WHERE sub_category_id = '$id'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Error deleting customers linked to sub category: " . mysqli_error($conn);
        die();
    }

    // Delete the sub-category
    $query = "DELETE FROM Sub_Category WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Sub Category deleted successfully";
    } else {
        echo "Error deleting sub category: " . mysqli_error($conn);
    }
}

?>
