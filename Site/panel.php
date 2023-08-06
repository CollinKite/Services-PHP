<?php
$page = "Admin Panel";
include_once "Database/dbconnect.php";
include_once "Frame/header.php";
include_once "Fetch/AdminUtil.php";

$conn = Connect();

$validToken = verifyAdminToken($conn);

//if token is not valid, return error
if(!$validToken){
    echo "Invalid Login, logout and login again";
    die();
}
else {
 ?>
    <link rel="stylesheet" href="css/panel.css">
    <div id="Admins"></div>
    <div id="Catagories"></div>
    <div id="SubCatagories"></div>
    
    <script>
        function fetchAdmins() {
            fetch('/Fetch/getAdmins.php')
            .then(response => response.json())
            .then(data => {
            let html = '<h1>Admins</h1>';
            //loop through the json response from DB and create a div for each contact and append it to the results div
            data.forEach(admin => {
                html += `<div class="admin">
                        <h2>${admin.username}</h2>
                        <p>Password: ${admin.password}</p>
                        <button onclick='editAdmin("${admin.username}")'>Edit</button>
                        <button onclick='deleteAdmin("${admin.username}")'>Delete</button>
                        </div>`;
            });
            document.getElementById('Admins').innerHTML = html;
            });
        }

        function deleteAdmin(username) {
            fetch('/Fetch/deleteAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username: username }),
            })
            .then(response => {
                if (response.ok) {
                    // Refresh the admins list
                    fetchAdmins();
                } else {
                    alert('Error deleting admin');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function editAdmin(username) {
            // Implement edit function, possibly opening a form with the admin's details filled in
        }

        window.onload = function() {
        console.log("fetching ..")
        fetchAdmins();
  };
    </script>
<?php
}
?>
