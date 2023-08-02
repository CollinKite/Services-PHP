<?php
$page = "Admin Panel";
include_once "Frame/header.php";
include_once 'Fetch/AdminUtil.php';

//get session token
$token = $_SESSION['token'];

verifyAdminToken($token);

//if token is not valid, return error
if(!$validToken){
    echo "Invalid Login, logout and login again";
    die();
}
else {
 ?>
    <h1>Admin Panel</h1>
    <div id="Admins"></div>
    <div id="Catagories"></div>
    <div id="SubCatagories"></div>
    <div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Fetch all admins
            $.ajax({
                url: "/fetch/getAdmins.php",
                method: "GET",
                success: function(response) {
                    let admins = JSON.parse(response);
                    admins.forEach(function(admin){
                        let adminElement = "<p class='admin' data-username='" + admin.username + "'>" + admin.username + 
                            "<button class='edit'>Edit</button>" +
                            "<button class='delete'>Delete</button>" +
                        "</p>";
                        $("#Admins").append(adminElement);
                    });

                    // Handle edit button click
                    $(".edit").click(function(){
                        let username = $(this).parent().data("username");
                        let newUsername = prompt("Enter new username:");
                        let newPassword = prompt("Enter new password:");
                        if(newUsername && newPassword){
                            $.ajax({
                                url: "/fetch/updateAdmin.php",
                                method: "POST",
                                data: JSON.stringify({
                                    old_username: username,
                                    new_username: newUsername,
                                    new_password: newPassword
                                }),
                                success: function(response) {
                                    alert(response);
                                    location.reload();
                                }
                            });
                        }
                    });

                    // Handle delete button click
                    $(".delete").click(function(){
                        let username = $(this).parent().data("username");
                        $.ajax({
                            url: "/fetch/deleteAdmin.php",
                            method: "POST",
                            data: JSON.stringify({
                                username: username
                            }),
                            success: function(response) {
                                alert(response);
                                location.reload();
                            }
                        });
                    });
                }
            });
        });
    </script>
<?php
}
?>
