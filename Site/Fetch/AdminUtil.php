<?php

//Returns true or false if the token is valid
function verifyAdminToken($conn){
    if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
    }
    else{
        $token = "";
    }
    //check if token is empty
    if(empty($token)){
        return false;
    }

    //sanitize token
    // $token = mysqli_real_escape_string($conn, $token);

    //query to check if token is valid
    $query = "SELECT * FROM users WHERE token = '$token'";
    $result = mysqli_query($conn, $query);

    //if token is valid, return true
    if(mysqli_num_rows($result) == 1){
        return true;
    }
    else{
        return false;
    }
}

function createAdmin($conn){
    // get json input and decode it
    $data = json_decode(file_get_contents("php://input"), true);
    $validToken = verifyAdminToken($conn);

    //if token is not valid, return error
   if(!$validToken){
        echo "Invalid token";
        die();
    }

    //get username and password from post request
    $username = $data['username'];
    $password = $data['password'];

    //check if username and password are empty
    if(empty($username) || empty($password)){
        echo "Username or password is empty";
        die();
    }

    //santize inputs
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    //query to check if username already exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        echo "Username already exists";
        die();
    }

    //generate unique token
    $token = bin2hex(random_bytes(16));

    //query to insert new admin into database
    $query = "INSERT INTO users (username, password, token) VALUES ('$username', '$password', '$token')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Admin created successfully";
    } else {
        echo "Error creating admin: " . mysqli_error($conn);
    }
}

function retriveAdmin($conn){
    // get json input and decode it
    $data = json_decode(file_get_contents("php://input"), true);
    $validToken = verifyAdminToken($conn);

    //if token is not valid, return error
    // if(!$validToken){
    //     echo "Invalid token";
    //     die();
    // }

    //check if there was a username in the get request
    if(isset($data['username'])){
        $username = $data['username'];
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 0){
            echo "Username does not exist";
            die();
        }
        echo json_encode(mysqli_fetch_assoc($result));
    }
    //if there was no username in the get request, return all admins
    else{
        $query = "SELECT * FROM users";
        $result = mysqli_query($conn, $query);
        $admins = array();
        while($row = mysqli_fetch_assoc($result)){
            $admins[] = $row;
        }
        echo json_encode($admins);
    }
}

function updateAdmin($conn){
    // get json input and decode it
    $data = json_decode(file_get_contents("php://input"), true);
    $validToken = verifyAdminToken($conn);

    //if token is not valid, return error
    if(!$validToken){
        echo "Invalid token";
        die();
    }

    $old_username = $data['old_username'];
    $new_username = $data['new_username'];
    $new_password = $data['new_password'];

    //check if old username, new username, and new password are empty
    if(empty($old_username) || empty($new_username) || empty($new_password)){
        echo "Username or password is empty";
        die();
    }

    //santize inputs
    $old_username = mysqli_real_escape_string($conn, $old_username);
    $new_username = mysqli_real_escape_string($conn, $new_username);
    $new_password = mysqli_real_escape_string($conn, $new_password);

    //query to check if old username exists
    $query = "SELECT * FROM users WHERE username = '$old_username'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 0){
        echo "Username does not exist";
        die();
    }

    //query to update username and password
    $query = "UPDATE users SET username = '$new_username', password = '$new_password' WHERE username = '$old_username'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Admin updated successfully";
    } else {
        echo "Error updating admin: " . mysqli_error($conn);
    }


}

function deleteAdmin($conn){
    // get json input and decode it
    $data = json_decode(file_get_contents("php://input"), true);

    //if token is not valid, return error
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $username = $data['username'];

    //check if username is empty
    if(empty($username)){
        echo "Username is empty";
        die();
    }

    //santize inputs
    $username = mysqli_real_escape_string($conn, $username);

    //query to check if username exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 0){
        echo "Username does not exist";
        die();
    }

    //query to delete admin
    $query = "DELETE FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Admin deleted successfully";
    } else {
        echo "Error deleting admin: " . mysqli_error($conn);
    }
}

function checkLogin($conn){
    // get json input and decode it
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $password = $data['password'];

    //check if username and password are empty
    if(empty($username) || empty($password)){
        echo "Username or password is empty";
        die();
    }
    //santize inputs
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    //query to check if username and password are correct
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    //if username and password are correct, return the token
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $token = $row['token'];
        session_start();
        $_SESSION['token'] = $token;
        // Return JavaScript code for redirection
        echo '<script type="text/javascript">';
        echo 'window.location.href = "https://google.com";'; // Replace "dashboard.php" with the URL of the new page
        echo '</script>';
        exit; // Make sure to exit after echoing the JavaScript code

    } else {
        echo "Username or password is incorrect";
    }
}
?>