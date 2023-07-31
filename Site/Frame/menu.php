<style>
  /* Add side spacing between the dropdowns */
.dropdown {
    padding-left: 10px;
    padding-right: 10px;
    display: inline-block; /* Display main categories side by side */
}

  /* Add styles for the dropdown container to display items in a column */
.dropdown-container {
    display: flex;
    flex-wrap: wrap; /* Allow main categories to wrap into a new line if needed */
}

  /* Add styles for the individual dropdowns */
.dropdown-content {
    display: none; /* Hide subcategories by default */
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

  /* Show dropdown content when hovering over the main category */
.dropdown:hover .dropdown-content {
    display: block;
}

  /* Add some styling for the subcategory links */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

  /* Add some styling for the subcategory links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}
</style>


<script>
async function fetchMainAndSubCategories() {
    try {
        const mainCategoriesResponse = await fetch('Fetch/get_main_categories.php');
        const mainCategories = await mainCategoriesResponse.json();

        const categories = {};
        await Promise.all(
        mainCategories.map(async mainCategory => {
            const subCategoriesResponse = await fetch(`Fetch/get_sub_categories.php?mainCategoryId=${mainCategory.id}`);
            const subCategories = await subCategoriesResponse.json();
            categories[mainCategory.id] = {
            name: mainCategory.name,
            subcategories: subCategories
            };
        })
        );

      // After fetching all subcategories, populate the dropdown menu
        populateDropdownMenu(categories);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

  // Function to populate the dropdown menu with main categories and subcategories
function populateDropdownMenu(categories) {
    const dropdownContainer = document.getElementById('dropdownContainer');
    Object.keys(categories).forEach(mainCategoryId => {
        const mainCategory = categories[mainCategoryId];
        const dropdown = document.createElement('div');
        dropdown.classList.add('dropdown');
        dropdown.innerHTML = `
        <span>${mainCategory.name}</span>
        <div class="dropdown-content">
            ${mainCategory.subcategories
            .map(
                subcategory =>
                `<a href="${mainCategory.name.replace(/\s+/g, '_')}.php?category=${subcategory.id}">${subcategory.title}</a>`
            )
            .join('')}
        </div>`;
    dropdownContainer.appendChild(dropdown);
    });
}

// Call the fetchMainAndSubCategories function to initiate the data fetching
fetchMainAndSubCategories();
</script>
<div id="dropdownContainer" class="dropdown-container"></div>
