<?php
$page = "Admin Login";
include_once "Frame/header.php";
?>
<form id="loginForm">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Login">
    <p id="output"></p>
</form>
<br>

<!-- JavaScript to display the output message and handle form submission -->
<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        // Prevent the form from being submitted in the traditional way
        e.preventDefault();

        // Get username and password from the form
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;

        // Make a POST request with the Fetch API
        fetch('/Fetch/checkLogin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: username,
                password: password
            }),
        })
        .then(response => response.text())
        .then(data => {
            // If the login was successful, redirect to the panel
            if (data == "success") {
                window.location.href = '/content.php?title=Admin%20Panel&categoryid=9';
            }
            // Otherwise, display the error message
            else {
                document.getElementById('output').innerHTML = data;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            document.getElementById('output').innerHTML = "An error occurred during login";
        });
    });
</script>

<?php include_once "Frame/footer.php"; ?>
