<style>
  /* Add side spacing between the dropdowns */
    .dropdown {
        padding-left: 10px;
        padding-right: 10px;
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
            name: mainCategory.category,
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
                `<a href="service.php?category=${subcategory.id}">${subcategory.Title}</a>`
            )
            .join('')}
        </div>`;
    dropdownContainer.appendChild(dropdown);
    });
}

  // Call the fetchMainAndSubCategories function to initiate the data fetching
fetchMainAndSubCategories();
</script>
<div id="dropdownContainer"></div>