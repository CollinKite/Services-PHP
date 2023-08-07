<?php
$page = "Admin Panel";
include_once "Database/dbconnect.php";
include_once "Fetch/AdminUtil.php";
include_once "Fetch/MainUtil.php";
include_once "Fetch/SubUtil.php";
include_once "Fetch/CustomerUtil.php";
if(session_status() == PHP_SESSION_NONE){
    // session has not started
    session_start();
}

$conn = Connect();

$validToken = verifyAdminToken($conn);

//if token is not valid, return error
if(!$validToken){
    session_destroy();
    echo "<div id=\"basepageinfo\"> Invalid Login. Login again <a href=/login.php>Login</a> </div>";
    die();
}
else {
 ?>
    <div>
        <select id="theme" name="Theme" onchange=setTheme()></select>
        <button id="logout" onclick="window.location.href = '/Fetch/logout.php';">Logout</button>
    </div>
    <div id="section">
        <h1>Admin</h1>
        <h3>Create Admin</h3>
        <input type="text" id="username" placeholder="Enter Username">
        <input type="text" id="password" placeholder="Enter Password">
        <button onclick=createAdmin()>Create</button>
        <div id="Admins"></div>
    </div>
    <div id="section">
        <h1>Main Catagories</h1>
        <h3>Create Catagory</h3>
        <input type="text" id="mainCategoryName" placeholder="Enter Catagory">
        <button onclick=createMainCategory()>Create</button>
        <div id="Catagories"></div>
    </div>
    <div id="section">
        <h1>Sub Categories</h1>
        <h3>Create Sub Category</h3>
        <input type="text" id="subCategoryTitle" placeholder="Enter Sub Category">
        <input type="text" id="subCategoryDesc" placeholder="Enter Sub Category Description">
        <input type="text" id="subCategoryCost" placeholder="Enter Sub Category Cost">
        <label for="MainCategories">Main Category:</label>
        <select id="MainCategories" Name="MainCategories"></select>
        <button onclick=createSubCategory()>Create</button>
        <div id="subCatagories"></div>
    </div>

    <div id="section">
        <h1>Customers</h1>
        <div id="Customers"></div>
    </div>
    
    <script>
        function showEditForm(section, index) {
            document.getElementById(`edit${section}Form${index}`).style.display = 'block';
        }

        function fetchStyles() {
            try{
                //remove any options that are already there
                let select = document.getElementById('theme');
                while(select.firstChild){
                    select.removeChild(select.firstChild);
                }
                let styles = [];
                fetch('/Fetch/getStyles.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach((style, index) => {
                        styles.push(
                        {
                            id: style.id,
                            name: style.filename,
                            selected: style.selected_id ? true : false
                        });
                    });
                    populateDropdownSelect(styles, 'theme');
                });

            }
            catch(err){
                console.log(err);
            }
        }


        function fetchAdmins() {
            fetch('/Fetch/getAdmins.php')
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach((admin, index) => {
                    html += `<div class="admin" id="admin${index}">
                            <p>${admin.username}<p>
                            <p>Password: ${admin.password}</p>
                            <button id='editAdmin${index}'>Edit</button>
                            <button id='deleteAdmin${index}'>Delete</button>
                            <div id='editAdminForm${index}' style='display: none;'>
                                <input type='text' id='newUsername${index}' placeholder='New Username' value='${admin.username}'>
                                <input type='password' id='newPassword${index}' placeholder='New Password' value='${admin.password}'>
                                <button id='submitEditAdmin${index}'>Submit</button>
                            </div>
                            </div>`;
                });
                document.getElementById('Admins').innerHTML = html;

                // Add event listeners
                data.forEach((admin, index) => {
                    document.getElementById(`editAdmin${index}`).addEventListener('click', () => showEditForm('Admin', index));
                    document.getElementById(`deleteAdmin${index}`).addEventListener('click', () => deleteAdmin(admin.username));
                    document.getElementById(`submitEditAdmin${index}`).addEventListener('click', () => editAdmin(admin.username, index));
                });
            });
        }


        async function fetchMainCategories(categoryId){
            try{
                let html = '';
                const response = await fetch('Fetch/get_main_categories.php');
                const data = await response.json();
                const MainCategories = [];
                data.forEach((mainCategory, index) => {
                    MainCategories.push(
                        {
                            id: mainCategory.id,
                            name: mainCategory.name
                        });
                    html += `<div class="MainCategory" id="mainCategory${index}">
                                <p>${mainCategory.name}</p>
                                <button id='editMainCategory${index}'>Edit</button>
                                <button id='deleteMainCategory${index}'>Delete</button>
                                <div id='editMainCategoryForm${index}' style='display: none;'>
                                    <input type='text' id='newMainCategoryName${index}' placeholder='New Category Name' value='${mainCategory.name}'>
                                    <button id='submitEditMainCategory${index}'>Submit</button>
                                </div>
                            </div>`;
                });
                document.getElementById('Catagories').innerHTML = html;
                populateDropdownSelect(MainCategories, 'MainCategories');

                // Add event listeners
                data.forEach((mainCategory, index) => {
                    document.getElementById(`editMainCategory${index}`).addEventListener('click', () => showEditForm('MainCategory', index));
                    document.getElementById(`deleteMainCategory${index}`).addEventListener('click', () => deleteMainCategory(mainCategory.id));
                    document.getElementById(`submitEditMainCategory${index}`).addEventListener('click', () => editMainCategory(mainCategory.id, index));
                });
            }
            catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function fetchSubCategories() {
            try {
                let html = '';
                const response = await fetch('Fetch/getSubCategory.php'); 
                const data = await response.json();

                data.forEach((subCategory, index) => {
                    html += `<div class="SubCategory" id="subCategory${index}">
                                <p>${subCategory.title} (Main Category: ${subCategory.main_category_name})</p>
                                <p>Price: ${subCategory.cost}</p>
                                <p>Description: ${subCategory.desc}</p>
                                <button id='editSubCategory${index}'>Edit</button>
                                <button id='deleteSubCategory${index}'>Delete</button>
                                <div id='editSubCategoryForm${index}' style='display: none;'>
                                    <input type='text' id='newSubCategoryTitle${index}' placeholder='New Sub-Category Title' value='${subCategory.title}'>
                                    <input type='text' id='newSubCategoryDesc${index}' placeholder='New Description' value='${subCategory.desc}'>
                                    <input type='text' id='newSubCategoryCost${index}' placeholder='New Cost' value='${subCategory.cost}'>
                                    <label for="newMainCategory${index}">Main Category:</label>
                                    <select id="newMainCategory${index}" Name="newMainCategory${index}"></select>
                                    <button id='submitEditSubCategory${index}'>Submit</button>
                                </div>
                            </div>`;
                });

                document.getElementById('subCatagories').innerHTML = html;

                // Add event listeners
                data.forEach((subCategory, index) => {
                    document.getElementById(`editSubCategory${index}`).addEventListener('click', () => showEditForm('SubCategory', index));
                    document.getElementById(`deleteSubCategory${index}`).addEventListener('click', () => deleteSubCategory(subCategory.id));
                    document.getElementById(`submitEditSubCategory${index}`).addEventListener('click', () => editSubCategory(subCategory.id, index));
                });

                // Populate the dropdowns in the edit forms
                const mainCategoriesResponse = await fetch('Fetch/get_main_categories.php');
                const mainCategories = await mainCategoriesResponse.json();
                mainCategories.forEach((subCategory, index) => {
                    populateDropdownSelect(mainCategories, `newMainCategory${index}`);
                    document.getElementById(`newMainCategory${index}`).value = subCategory.main_category_id;  // Set the current main category as the selected option
                });
            }
            catch (error) {
                console.error('Error fetching data:', error);
            }
        }



        function fetchCustomers(){
            fetch('/Fetch/getCustomers.php')
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach((customer, index) => {
                    html += `<div class="Customer" id="customer${index}">
                                <p>Name: ${customer.name}</p>
                                <p>Email: ${customer.email}</p>
                                <p>Service Intrested In: ${customer.sub_category_title}</p>
                                <button id='deleteCustomer${index}'>Delete</button>
                            </div>`;
                });
                document.getElementById('Customers').innerHTML = html;

                // Add event listeners
                data.forEach((customer, index) => {
                    document.getElementById(`deleteCustomer${index}`).addEventListener('click', () => deleteCustomer(customer.id));
                });
            })
            .catch(error => console.error('Error fetching data:', error));
        }

        function populateDropdownSelect(array, id) {
            var select = document.getElementById(`${id}`);
            array.forEach(array => {
                const option = document.createElement('option');
                option.value = array.id;
                option.innerHTML = array.name;
                if(array.selected)
                {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        }

        function createAdmin() {
            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;
            console.log(username, password)
            fetch('/Fetch/createAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username: username, password: password }),
            })
            .then(response => {
                if (response.ok) {
                    response.text().then(data => console.log(data));
                    // Refresh the admins list
                    fetchAdmins();
                    //clear the input fields
                    document.getElementById('username').value = '';
                    document.getElementById('password').value = '';
                } else {
                    alert('Error creating admin');
                }
            })
        }

        function createMainCategory() {
            let name = document.getElementById('mainCategoryName').value;
            fetch('/Fetch/createMainCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name: name }),
            })
            .then(response => {
                if (response.ok) {
                    response.text().then(data => console.log(data));
                    // Refresh the main categories list
                    fetchMainCategories();
                    //clear the input fields
                    document.getElementById('mainCategoryName').value = '';
                } else {
                    alert('Error creating main category');
                }
            })
        }

        function createSubCategory() {
            let title = document.getElementById('subCategoryTitle').value;
            let cost = document.getElementById('subCategoryCost').value;
            let desc = document.getElementById('subCategoryDesc').value;
            let mainCategoryId = document.getElementById('MainCategories').value;            
            fetch('/Fetch/createSubCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ title: title, desc: desc, cost: cost, main_category_id: mainCategoryId }),
            })
            .then(response => {
                if (response.ok) {
                    response.text().then(data => console.log(data));
                    // Refresh the sub categories list
                    fetchSubCategories();
                    //clear the input fields
                    document.getElementById('subCategoryTitle').value = '';
                    document.getElementById('subCategoryCost').value = '';
                    document.getElementById('subCategoryDesc').value = '';
                } else {
                    alert('Error creating sub category');
                }
            })
        }

        function setTheme(){
            let theme = document.getElementById('theme').value;
            fetch('/Fetch/updateStyle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: theme }),
            })
            .then(response => {
                if (response.ok) {
                    // response.text().then(data => console.log(data));
                    //refresh page
                    location.reload();
                } else {
                    alert('Error creating sub category');
                }
            })
        }

        function editAdmin(username, index) {
            const newUsername = document.getElementById(`newUsername${index}`).value;
            const newPassword = document.getElementById(`newPassword${index}`).value;

            fetch('Fetch/updateAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ old_username: username, new_username: newUsername, new_password: newPassword }),
            })
            .then(response => response.text())
            .then(data => {
                console.log('Admin update response:', data);
                fetchAdmins();  // Refresh the list of admins
                document.getElementById(`editAdminForm${index}`).style.display = 'none';  // Hide the edit form
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }


        function editMainCategory(id, index) {
            const newName = document.getElementById(`newMainCategoryName${index}`).value;

            fetch('Fetch/updateMainCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id, name: newName }),
            })
            .then(response => response.text())
            .then(data => {
                fetchMainCategories();  // Refresh the list of main categories
                document.getElementById(`editMainCategoryForm${index}`).style.display = 'none';  // Hide the edit form
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function editSubCategory(id, index) {
            const newTitle = document.getElementById(`newSubCategoryTitle${index}`).value;
            const newDesc = document.getElementById(`newSubCategoryDesc${index}`).value;
            const newCost = document.getElementById(`newSubCategoryCost${index}`).value;
            const newMainCategoryId = document.getElementById(`newMainCategory${index}`).value;

            fetch('Fetch/updateSubCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id, title: newTitle, desc: newDesc, cost: newCost, main_category_id: newMainCategoryId }),
            })
            .then(response => response.text())
            .then(data => {
                console.log('Sub-category update response:', data);
                fetchSubCategories();  // Refresh the list of sub-categories
                document.getElementById(`editSubCategoryForm${index}`).style.display = 'none';  // Hide the edit form
            })
            .catch((error) => {
                console.error('Error:', error);
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

        function deleteMainCategory(id) {
            fetch('/Fetch/deleteMainCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({id: id}),
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                fetchMainCategories();
                fetchSubCategories();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function deleteSubCategory(id) {
            fetch('/Fetch/deleteSubCategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({id: id}),
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                fetchSubCategories();
                fetchCustomers();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function deleteCustomer(id) {
            fetch('/Fetch/deleteCustomer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({id: id}),
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                fetchCustomers();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }


        function reloadData() {
            fetchStyles();
            fetchAdmins();
            fetchMainCategories();
            fetchSubCategories();
            fetchCustomers();
        }

        window.onload = function() {
        console.log("fetching ..")
        reloadData();
  };
    </script>
<?php
}
?>
