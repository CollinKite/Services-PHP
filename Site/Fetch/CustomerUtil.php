<?php
require_once 'AdminUtil.php';

function createCustomer($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $name = $data['name'];
    $email = $data['email'];
    $sub_category_id = $data['sub_category_id'];

    if(empty($name) || empty($email)){
        echo "Name or email is empty";
        die();
    }

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $sub_category_id = mysqli_real_escape_string($conn, $sub_category_id);

    $query = "INSERT INTO Customer (name, email, sub_category_id) VALUES ('$name', '$email', '$sub_category_id')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Customer created successfully";
    } else {
        echo "Error creating customer: " . mysqli_error($conn);
    }
}

function retrieveCustomer($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['id'])){
        $id = $data['id'];
        $id = mysqli_real_escape_string($conn, $id);
        $query = "SELECT Customer.*, Sub_Category.title as sub_category_title FROM Customer LEFT JOIN Sub_Category ON Customer.sub_category_id = Sub_Category.id WHERE Customer.id = '$id'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 0){
            echo "Customer does not exist";
            die();
        }
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        $query = "SELECT Customer.*, Sub_Category.title as sub_category_title FROM Customer LEFT JOIN Sub_Category ON Customer.sub_category_id = Sub_Category.id";
        $result = mysqli_query($conn, $query);
        $customers = array();
        while($row = mysqli_fetch_assoc($result)){
            $customers[] = $row;
        }
        echo json_encode($customers);
    }
}



function updateCustomer($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    $sub_category_id = $data['sub_category_id'];

    if(empty($id) || empty($name) || empty($email)){
        echo "Some fields are empty";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $sub_category_id = mysqli_real_escape_string($conn, $sub_category_id);

    $query = "UPDATE Customer SET name = '$name', email = '$email', sub_category_id = '$sub_category_id' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Customer updated successfully";
    } else {
        echo "Error updating customer: " . mysqli_error($conn);
    }
}

function deleteCustomer($conn) {
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
    $query = "DELETE FROM Customer WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Customer deleted successfully";
    } else {
        echo "Error deleting customer: " . mysqli_error($conn);
    }
}

?>