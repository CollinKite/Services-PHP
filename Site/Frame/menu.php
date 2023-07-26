<?php
    // Assuming you have the functions for fetching main and subcategories here

    // Function to fetch main categories from the database
    function getMainCategories() {
        // Replace this with your actual database query to fetch main categories
        // and return the data as an array
        return [
            ['id' => 1, 'name' => 'Category A'],
            ['id' => 2, 'name' => 'Category B'],
            ['id' => 3, 'name' => 'Category C'],
        ];
    }

    // Function to fetch sub categories for a given main category from the database
    function getSubCategories($mainCategoryId) {
        // Replace this with your actual database query to fetch sub categories for the given main category id
        // and return the data as an array
        // For this example, we'll use static data:
        $subCategories = [
            ['id' => 1, 'name' => 'Subcategory 1'],
            ['id' => 2, 'name' => 'Subcategory 2'],
        ];

        return $subCategories;
    }

    $pages = getMainCategories();
    foreach ($pages as $tempPage) :
        $subCategories = getSubCategories($tempPage['id']);
    ?>
        <div class="dropdown">
            <span><?php echo $tempPage['name']; ?></span>
            <div class="dropdown-content">
                <?php foreach ($subCategories as $subcategory) : ?>
                    <a href="sub_category.php?category=<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        // JavaScript to handle the click event and toggle active class
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', () => {
                    dropdown.classList.toggle('active');
                });

                // Close the dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (!dropdown.contains(event.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            });
        });
    </script>