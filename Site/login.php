<?php
$page = "Admin Login";
include_once "Frame/header.php";

?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <br>
    <p id="output" rows="5" cols="50" readonly></p>

    <!-- JavaScript to display the output message -->
    <script>
        function displayMessage(message) {
            document.getElementById('output').value = message;
        }
    </script>
    



<style>
form {
    max-width: 400px;

    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

input[type="text"],
input[type="password"],
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="number"] {
    width: 100px;
}

input[type="submit"] {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>

<?php include_once "Frame/footer.php"; ?>
