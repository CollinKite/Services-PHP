<?php
include_once "Database/dbconnect.php";
include_once "Fetch/AdminUtil.php";
if(session_status() == PHP_SESSION_NONE){
  // session has not started
  session_start();
}
//The reason the fetch is above the header is to initalize the page variable

if (isset($_GET['title'])) {
    $page = $_GET['title'];
} else {
    $page = 'default_value'; // Provide a default value if the session variable is not set
}


include_once "Frame/header.php";

?>

<div id="basepageinfo" hidden>

<div class="content-text" id="categoryDescription"></div>

<!-- Add an empty container for the category cost -->
<div class="content-cost" id="categoryCost" hidden></div>
</div>

<!-- If the title is "Consultation," show the form -->
<div id="consultationFormContainer" hidden>
    <form class="consultation-form" >
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br><br>
        <!--Drop down selection box of services will go here--> 
        <label for="service">Service:</label>
        <select id="service" name="service">
        </select><br><br>
        <!--SubmitButton-->
        <button type="submit" value="Submit">Submit</button>
    </form>
</div>

<script>
  //handle the form submission
  document.querySelector('.consultation-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    console.log('form submitted');
    //get the values from the form
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
// get theservice id 
    var service = document.getElementById('service').value;
    //create the url to send the request to
    var url = 'Fetch/post_consultation_form.php';

    //create the data object to send
    var data = {
      name: name,
      email: email,
      sub_category_id: service
    };

    //console log the data to make sure it is correct
    console.log(data);
    //send the request
    var request = new XMLHttpRequest();
    request.open('POST', url);
    request.setRequestHeader('Content-Type', 'application/json');
    request.onload = function () {
        if (request.status == 200) {
            // If the request was successful, display a success message
            alert('Thank you for your submission. We will contact you shortly.');
            console.log("success");
            console.log(request.responseText);
        } else {
            // If the request failed, display an error message
            alert('Something went wrong with your submission. Please try again later.');
            console.log("error");
        }
    };

    // Send the request with the JSON data
    request.send(JSON.stringify(data)); // This line was missing in your original code
});
  </script>



<?php
if($page == "Login"){
  include_once "login.php";
}
elseif($page == "Admin Panel"){
  include_once "panel.php";
}
else{
  include_once "load_content.php";
}
?>


<?php
echo "<br><br><br><br><br>";
include_once "Frame/footer.php";
?>