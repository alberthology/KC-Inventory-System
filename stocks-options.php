 <?php
    session_start();
    include 'functions/db_con.php';
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    ?>

 <div class="content-wrapper">

     <div class="content">
         <div class="container-fluid">
             <div class="row">

                 <div class="col-md-12 mt-2">
                     <div class="card">
                         <div class="card-header p-3">
                             <ul class="nav nav-pills">
                                 <li class="nav-item"><a class="nav-link tbl active" href="#category" data-toggle="tab"><b>BRAND LIST</b></a></li>
                                 <!-- <li class="nav-item"><a class="nav-link" href="#brand" data-toggle="tab"><b>BRAND</b></a></li> -->
                                 <li class="nav-item"><a class="nav-link tbl" href="#product" data-toggle="tab"><b>PRODUCT LIST</b></a></li>
                             </ul>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="category">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add-category"><i class="fas fa-plus"></i>  &nbsp Brand</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="category-table" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand</th>
                                                                 <th>Category</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php

                                                                // Query to fetch data from the category_table
                                                                $query = "SELECT
                                                                c.category_id, 
                                                                c.category_name, 
                                                                b.brand_id, 
                                                                b.brand_name, 
                                                                b.description, 
                                                                b.country_of_origin
                                                                FROM category_table c
                                                                INNER JOIN  brand_table b ON b.category_id = c.category_id ";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='brand-row-{$row['brand_id']}'>
                    <td>{$row['brand_name']}</td>
                    <td>{$row['category_name']}</td>
                    <td style='text-align:center;'>
                        <button class='btn btn-primary' onclick='openEditModal_brand({$row['brand_id']}, \"{$row['brand_name']}\", \"{$row['category_id']}\" , \"{$row['country_of_origin']}\", \"{$row['description']}\")'>
                            <i class='fas fa-edit'></i>
                        </button> &nbsp 
                        <button class='btn btn-danger' onclick='removeBrand({$row['brand_id']})'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                </tr>";
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='2'>No categories found.</td></tr>";
                                                                }
                                                                ?>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                 </div>

<!--                                  <div class="tab-pane" id="brand">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-plus"></i> &nbsp Brand</button>
                                                     </div>
                                                 </div>
                                                 <div class="card-body">
                                                     <table id="brand-table" class="table table-bordered table-striped" style="width:100%;">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand Name</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                        <tbody> -->
<?php
/*    $query = "SELECT * FROM brand_table";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='brand-row-{$row['brand_id']}'>
                    <td>{$row['brand_name']}</td>
                    <td style='text-align:center;'>
                        <button class='btn btn-primary' onclick='openEditModal_brand({$row['brand_id']}, \"{$row['brand_name']}\", \"{$row['category_id']}\" , \"{$row['country_of_origin']}\", \"{$row['description']}\")'>
                            <i class='fas fa-edit'></i>
                        </button> &nbsp 
                        <button class='btn btn-danger' onclick='removeBrand({$row['brand_id']})'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                </tr>
                                                         </tbody>

                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>";
        }
    } else {
        echo "<tr><td colspan='2'>No brands found.</td></tr>
                                                 </tbody>

                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>";
    }*/
?>

                                 <div class="tab-pane" id="product">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-product"><i class="fas fa-plus"></i>  &nbsp Product</button>
                                                    </div>
                                                </div>
                                                 <!-- /.card-header -->
                                                <div class="card-body">


                                                    <table id="product-table" class="table table-bordered table-striped table-hover" style="width:100.1%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Product Code</th>
                                                                <th>Product Name</th>
                                                                <th>Category</th>
                                                                <th>Brand</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php

// SQL query to join product_table with category_table, brand_table, and supplier_table
$query = "
    SELECT 
p.product_id, p.product_name, p.category_id, p.brand_id, p.quantity_in_stock, p.price, 
           p.product_size, p.product_color, p.description, 
           c.category_name, b.brand_name
    FROM product_table p
    LEFT JOIN category_table c ON p.category_id = c.category_id
    LEFT JOIN brand_table b ON p.brand_id = b.brand_id
";

$result = mysqli_query($conn, $query);

// Check if any products exist
if (mysqli_num_rows($result) > 0) {
    // Iterate through each Product and display in the table
    while ($row = mysqli_fetch_assoc($result)) {
        $formatted_price = number_format($row['price'], 2);
        echo "<tr id='product-row-{$row['product_id']}'>
    <td>{$row['product_id']}</td>
    <td>{$row['product_name']}</td>
    <td>{$row['category_name']}</td> <!-- Show category name -->
    <td>{$row['brand_name']}</td> <!-- Show brand name -->
    <td>{$row['quantity_in_stock']}</td>
    <td>{$formatted_price}</td>
    <td style='text-align:center;'>
        <button class='btn btn-primary btn-sm' onclick='openEditModal(
            {$row['product_id']}, 
            \"{$row['product_name']}\", 
            \"{$row['brand_name']}\", 
            \"{$row['brand_id']}\", 
            \"{$row['category_id']}\", 
            \"{$row['category_name']}\", 
            \"{$row['quantity_in_stock']}\", 
            \"{$row['price']}\", 
            \"{$row['product_size']}\", 
            \"{$row['product_color']}\", 
            \"{$row['description']}\"
        )'>
            <i class='fas fa-edit'></i>
        </button>
        &nbsp
        <button class='btn btn-danger btn-sm' onclick='removeProduct({$row['product_id']})'>
            <i class='fas fa-trash'></i>
        </button>
    </td>
</tr>";

    }
} else {
    echo "<tr><td colspan='7'>No Products found.</td></tr>";
}

?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                 <!-- /.card-body -->
                                            </div>
                                             <!-- /.card -->
                                        </div>
                                     </div>
                                 </div>
                             </div>


                        <!-- Edit brand Modal -->
                        <div class="modal fade" id="edit-brand">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; Edit Product Brand</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editBrandForm" action="functions/edit_sql.php" method="post">
                                            <!-- Hidden field to store the ID of the record to edit -->
                                        <input type="hidden" name="form_type" value="update_brand">
                                            <input type="hidden" name="brand_id" id="edit_brand_id">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="edit_brand_name">Brand Name</label>
                                                    <input type="text" name="brand" id="edit_brand_name" class="form-control form-control-md uppercase-input" placeholder="Brand Name">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="edit_category_id">Category</label>
                                                    <select class="form-control form-control-md uppercase-input" name="category_id" id="edit_category_id">
                                                        <option selected hidden disabled>Select Category</option>
                                                        <!-- Categories will be populated here by JavaScript -->
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="edit_origin_country">Origin Country</label>
                                                    <input type="text" name="origin_country" id="edit_origin_country" class="form-control form-control-md uppercase-input" placeholder="Originated Country">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="edit_description">Description</label>
                                                    <input type="text" name="description" id="edit_description" class="form-control" placeholder="Brand Description">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" form="editBrandForm" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- ============================ future proofing ========================= -->
                        <?php
                        // Display message if it exists
                        /*if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-{$_SESSION['message_type']}'>";
                            echo $_SESSION['message'];
                            echo "</div>";*/

                            // Clear the session message after it's displayed
                            /*unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                        }*/
                        ?>
                            <div class="modal fade" id="add-category">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fas fa-tags"></i> Add Product Brand & Category</h4>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions/insert_sql.php" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="category" class="form-control form-control-md uppercase-input" placeholder="Category">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="text" name="brand" class="form-control form-control-md uppercase-input" placeholder="Brand">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="text" name="origin_country" class="form-control form-control-md uppercase-input" placeholder="Originated Country (Optional)">
                                                    </div>
                                                    <div class="col-md-12 mb-5">
                                                        <input type="text" name="description" class="form-control form-control-md uppercase-input" placeholder="Brand Description (Optional)">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="submit" name="submit-category" class="btn btn-primary btn-sm" style="float: right;">Add</button>
                                                    </div>
                                                </div>
                                            </form>

                                         </div>
                                     </div>
                                     <!-- /.modal-content -->
                                 </div>
                                 <!-- /.modal-dialog -->
                             </div>

                            <!-- add stock modal -->
                            <div class="modal fade" id="add-product">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fas fa-tags"></i> Add Product</h4>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions/insert_sql.php" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="product" class="form-control form-control-md uppercase-input" placeholder="Product Name">
                                                    </div>

                                                    <div class="col-md-12">
    <select class="form-control form-control-md uppercase-input" name="category_id" id="category_id">
        <option selected hidden disabled>Select Category</option>
        <?php
        // Query to fetch data from the category_table
        $query = "SELECT * FROM category_table";
        $result = mysqli_query($conn, $query);

        // Check if any categories exist
        if (mysqli_num_rows($result) > 0) {
            // Iterate through each category and display in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
            }
        } else {
            echo "<option disabled>No Category Available</option>";
        }
        ?>
    </select>
</div>

<div class="col-md-12">
    <select class="form-control form-control-md uppercase-input" name="brand_id" id="brand_id">
        <option selected hidden disabled>Select Brand</option>
        <!-- Brands will be populated based on the category selected -->
    </select>
</div>

<script type="text/javascript">
    
    document.getElementById('category_id').addEventListener('change', function () {
    var categoryId = this.value;

    // Make sure a category is selected before making the request
    if (categoryId) {
        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'functions/get_brands.php?category_id=' + categoryId, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var brandSelect = document.getElementById('brand_id');
                var brands = JSON.parse(xhr.responseText);

                // Clear the existing options
                brandSelect.innerHTML = '<option selected hidden disabled>Select Brand</option>';

                // Populate the brand options
                if (brands.length > 0) {
                    brands.forEach(function (brand) {
                        var option = document.createElement('option');
                        option.value = brand.brand_id;
                        option.textContent = brand.brand_name;
                        brandSelect.appendChild(option);
                    });
                } else {
                    brandSelect.innerHTML = '<option disabled>No Brand Available</option>';
                }
            }
        };
        xhr.send();
    } else {
        // If no category is selected, clear the brand dropdown
        document.getElementById('brand_id').innerHTML = '<option selected hidden disabled>Select Brand</option>';
    }
});

</script>
                                                    <div class="col-md-6">
                                                        <input type="text" name="size" class="form-control form-control-md uppercase-input" placeholder="Input Size">
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="color" class="form-control form-control-md uppercase-input" placeholder="Input Color">
                                                        
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <input type="number" name="quantity" class="form-control form-control-md uppercase-input" placeholder="Stock Quantity" min="1">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="text" name="price" id="price" class="form-control form-control-md uppercase-input" placeholder="Product Price">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <input type="text" name="description" class="description" placeholder="Product Description (optional)">
                                                    </div>
                                                 </div>
                                                 <hr>
                                                 <div class="row">
                                                     <div class="col-md-6">
                                                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <button type="submit" name="submit-product" class="btn btn-primary btn-sm" style="float: right;">Add</button>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                     <!-- /.modal-content -->
                                 </div>
                                 <!-- /.modal-dialog -->
                             </div>



<!-- Edit Stock Modal -->
<div class="modal fade" id="edit-stocks">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStockForm" action="functions/edit_sql.php" method="post">
                    <input type="hidden" name="form_type" value="update_product">
                    <input type="hidden" name="product_id" id="edit_product_id">

                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-12">
                            <label for="edit_product_name">Product Name:</label>
                            <input type="text" name="product" id="edit_product_name" class="form-control form-control-md uppercase-input" placeholder="Product Name">
                        </div>



                        <!-- Product Size -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_size">Size:</label>
                            <input type="text" name="size" class="form-control form-control-md uppercase-input" id="edit_size" placeholder="Product Size">
                        </div>

                        <!-- Product Color -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_color">Color:</label>
                            <input type="text" name="color" class="form-control form-control-md uppercase-input" id="edit_color" placeholder="Product Color">
                        </div>

                        <!-- Quantity in Stock -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_quantity">Quantity in Stock:</label>
                            <input type="number" name="quantity" class="form-control form-control-md uppercase-input" id="edit_quantity" placeholder="Stock Quantity" min="1">
                        </div>

                        <!-- Price -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_price">Price:</label>
                            <input type="text" name="price" id="edit_price" class="form-control form-control-md uppercase-input" placeholder="Product Price">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Category Dropdown -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_category">Category:</label>
                            <select class="form-control form-control-md uppercase-input" name="category_id" id="edit_category_dropdown">
                                
                                <!-- Categories will be populated based on selection -->
                                
                            </select>
                        </div>


                        <!-- Brand Dropdown -->
                        <div class="col-md-6 mt-3">
                            <label for="edit_brand">Brand:</label>
                            <select class="form-control form-control-md uppercase-input" name="brand_id" id="edit_brand">
                                <option selected hidden disabled>Select Brand</option>
                                <!-- Brands will be populated dynamically -->
                            </select>
                        </div>

                        <!-- Product Description -->
                        <div class="col-md-12 mt-3">
                            <label for="edit_description">Product Description:</label>
                            <input type="text" name="description" class="description" id="edit_description" placeholder="Product Description (optional)">
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
            <div class="modal-footer justify-content-between" style="margin-top: 5%;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="editStockForm" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>


                         </div>
                     </div>

                 </div>

             </div>
         </div>

     </div>

 </div>


 <?php
    include 'includes/footer.php';
    include 'message.php';
    ?>

 <script>
    document.querySelectorAll('.uppercase-input').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });

$(document).ready(function() {
    var brandTable;
    var productTable;

    // Initialize the category table by default
    var categoryTable = $('#category-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "pageLength": 10 // Display 10 items per page
    });

$(document).ready(function() {
    // Make the tables visible before initializing DataTables
    $('#brand-table').css('display', 'table');
    $('#product-table').css('display', 'table');

    // Initialize the DataTable for the brand table
    var brandTable = $('#brand-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "pageLength": 10 // Display 10 items per page
    });

    // Initialize the DataTable for the product table
    var productTable = $('#product-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "pageLength": 10 // Display 10 items per page
    });
});


    // Initialize DataTable for brand table when the tab is shown
/*    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var target = $(e.target).attr("href"); // Get the target tab

        if (target === "#brand" && !$.fn.DataTable.isDataTable('#brand-table')) {
            if (brandTable) {
                brandTable.destroy(); // Destroy the old instance if it exists
            }
            brandTable = $('#brand-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "pageLength": 10
            });
        }

        if (target === "#product" && !$.fn.DataTable.isDataTable('#product-table')) {
            if (productTable) {
                productTable.destroy(); // Destroy the old instance if it exists
            }
            productTable = $('#product-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "pageLength": 10
            });
        }
    });*/
});



    document.getElementById('price').addEventListener('input', function(event) {
        // Get the input value
        let value = event.target.value;
        
        // Remove any non-numeric characters (except for decimal points)
        value = value.replace(/[^0-9.]/g, '');

        // Split the number into integer and decimal parts (if any)
        let parts = value.split('.');

        // Format the integer part with commas
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Join the parts back together, ensuring the decimal part is included if there was one
        event.target.value = parts.join('.');
    });




// function fetchCategoryAndBrand() {
//     const categoryId = document.getElementById("edit_category").value;
//     const categorySelect = document.getElementById("edit_category_dropdown"); // Corrected ID
//     const brandSelect = document.getElementById("edit_brand");

//     console.log("Fetching categories and brands for category ID:", categoryId);

//     // Clear previous options in the category select dropdown
//     console.log("Clearing previous category options...");
//     // categorySelect.innerHTML = '<option selected hidden disabled>Select Category</option>';

//     // Clear previous brand options
//     console.log("Clearing previous brand options...");
//     // brandSelect.innerHTML = '<option selected hidden disabled>Select Brand</option>';

//     // Fetch data from the server
//     console.log("Sending request to fetch data...");
//     fetch(`functions/fetch_categories.php?category_id=${categoryId}`)
//         .then(response => {
//             console.log("Received response from server.");
//             return response.json();
//         })
//         .then(data => {
//             console.log("Data received:", data);

//             const { category, brand } = data;
//             console.log("Categories:", category);
//             console.log("Brands:", brand);

//             // If no categories are available, display a message
// if (category.length === 0) {
//     console.log("No categories available. Displaying message.");
//     const option = document.createElement('option');
//     option.disabled = true;
//     option.textContent = 'No Categories Available';
//     categorySelect.appendChild(option);
// } else {
//     // Populate Category dropdown
//     console.log("Populating category dropdown...");
//     category.forEach(categoryItem => {
//         console.log("Adding category:", categoryItem.category_name);
//         const option = document.createElement('option');
//         option.value = categoryItem.category_id;
//         option.textContent = categoryItem.category_name;

//         // Check if the current category matches the selected category
//         if (categoryItem.category_id === parseInt(category_id)) {
//             option.selected = true;  // Set the option as selected
//             console.log("Setting category as selected:", categoryItem.category_name);
//         }

//         categorySelect.appendChild(option);
//     });
// }


//             // If no brands are available, display a message
//             if (brand.length === 0) {
//                 console.log("No brands available. Displaying message.");
//                 const option = document.createElement('option');
//                 option.disabled = true;
//                 option.textContent = 'No Brands Available';
//                 brandSelect.appendChild(option);
//             } else {
//                 // Populate Brand dropdown
//                 console.log("Populating brand dropdown...");
//                 brand.forEach(brandItem => {
//                     console.log("Adding brand:", brandItem.brand_name);
//                     const option = document.createElement('option');
//                     option.value = brandItem.brand_id;
//                     option.textContent = brandItem.brand_name;
//                     brandSelect.appendChild(option);
//                 });
//             }
//         })
//         .catch(error => {
//             console.error('Error fetching categories and brands:', error);
//         });
// }





function openEditModal(product_id, product_name, brand_name, brand_id, category_id, category_name, quantity_in_stock, price, product_size, product_color, description) {
    console.log("Opening modal for product ID:", product_id);

    // Set the hidden product ID field in the modal
    const productIdField = document.getElementById("edit_product_id");
    if (productIdField) productIdField.value = product_id;

    // Populate the product name input field
    const productNameField = document.getElementById("edit_product_name");
    if (productNameField) productNameField.value = product_name;

    // Set other fields
    const sizeField = document.getElementById("edit_size");
    if (sizeField) sizeField.value = product_size;

    const colorField = document.getElementById("edit_color");
    if (colorField) colorField.value = product_color;

    const quantityField = document.getElementById("edit_quantity");
    if (quantityField) quantityField.value = quantity_in_stock;

    const priceField = document.getElementById("edit_price");
    if (priceField) priceField.value = price;

    const descriptionField = document.getElementById("edit_description");
    if (descriptionField) descriptionField.value = description;

    // Populate category dropdown
    const categorySelect = document.getElementById("edit_category_dropdown");
    if (categorySelect) {
        console.log("Fetching categories...");
        fetch('functions/get_categories.php')
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch categories');
                return response.json();
            })
            .then(data => {
                categorySelect.innerHTML = '<option value="" disabled>Select a category</option>';
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.category_id;
                    option.textContent = category.category_name;
                    if (category.category_id === category_id) option.selected = true;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching categories:", error));
    }

    // Populate brand dropdown
    const brandSelect = document.getElementById("edit_brand");
    if (brandSelect) {
        console.log("Fetching brands...");
        fetch('functions/get_brand.php')
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch brands');
                return response.json();
            })
            .then(data => {
                brandSelect.innerHTML = '<option value="" disabled>Select a brand</option>';
                data.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand.brand_id;
                    option.textContent = brand.brand_name;
                    if (brand.brand_id === brand_id) option.selected = true;
                    brandSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching brands:", error));
    }

    // Show the modal
    $('#edit-stocks').modal('show');
}


// Function to open the edit modal and populate it with data
function openEditModal_brand(id, brand, category_id, origin_country, description) {
    // Set the values in the modal fields
    $('#edit_brand_id').val(id);
    $('#edit_brand_name').val(brand);
    $('#edit_origin_country').val(origin_country);
    $('#edit_description').val(description);

    // Now, load the categories into the dropdown and select the current category
    loadCategories(category_id);

    // Show the modal
    $('#edit-brand').modal('show');
}

// Open the modal with pre-filled data
/*function openEditModal(product_id, product_name, brand_name, brand_id, category_id, category_name, quantity_in_stock, price, product_size, product_color, description) {
    // Set the values in the modal fields
    $('#edit_product_id').val(product_id);
    $('#edit_product_name').val(product_name);

    $('#edit_brand_name').val(brand_name);
    $('#edit_brand_id').val(brand_id);
    $('#edit_category_id').val(category_id);
    $('#edit_category_name').val(category_name);

    $('#edit_quantity_in_stock').val(quantity_in_stock);
    $('#edit_price').val(price);
    $('#edit_product_size').val(product_size);
    $('#edit_product_color').val(product_color);
    $('#edit_description').val(description);

    
    $('#edit-stocks').modal('show'); 
}
*/





// Function to load categories dynamically via AJAX
function loadCategories(selectedCategoryId) {
    $.ajax({
        url: 'functions/get_categories.php',  
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var selectElement = $('#edit_category_id');
            selectElement.empty();  

            
            selectElement.append('<option selected hidden disabled>Select Category</option>');

           
            data.forEach(function(category) {
                var selected = (category.category_id == selectedCategoryId) ? 'selected' : '';
                selectElement.append('<option value="' + category.category_id + '" ' + selected + '>' + category.category_name + '</option>');
            });
        },
        error: function() {
            alert('Failed to load categories.');
        }
    });
}

     function removeCategory(category_id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Confirm',
             width: '30%',  // Adjust the width here

         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove category
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/delete_sql.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                         // Parse the JSON response
                         var response = JSON.parse(xhr.responseText);

                         // Check if the removal was successful
                         if (response.status === "success") {
                             // Remove the row from the table
                             var row = document.getElementById("category-row-" + category_id);
                             if (row) {
                                 row.parentNode.removeChild(row);
                             }
                             // Show SweetAlert message
                             Swal.fire({
                                 icon: 'success',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         } else {
                             // Show error message
                             Swal.fire({
                                 icon: 'error',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         }
                     }
                 };
                 xhr.send("category_id=" + category_id);
             }
         });
     }

     function removeBrand(brand_id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Confirm',
             width: '30%',  // Adjust the width here

         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove brand
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/delete_sql.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                         // Parse the JSON response
                         var response = JSON.parse(xhr.responseText);

                         // Check if the removal was successful
                         if (response.status === "success") {
                             // Remove the row from the table
                             var row = document.getElementById("brand-row-" + brand_id);
                             if (row) {
                                 row.parentNode.removeChild(row);
                             }
                             // Show SweetAlert message
                             Swal.fire({
                                 icon: 'success',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         } else {
                             // Show error message
                             Swal.fire({
                                 icon: 'error',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         }
                     }
                 };
                 xhr.send("brand_id=" + brand_id);
             }
         });
     }


function removeProduct(product_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm',
        width: '30%',  // Adjust the width here
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform AJAX request to remove Product
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "functions/delete_sql.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Check the response status
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        console.log(response); // For debugging purposes

                        if (response.status === "success") {
                            // Successfully deleted product from the database
                            
                            // Remove the row from the table
                            var row = document.getElementById("product-row-" + product_id);
                            if (row) {
                                row.parentNode.removeChild(row); // Remove the row from DOM immediately
                            }

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: { popup: 'swal2-popup' }
                            });
                        } else {
                            // Show error message if deletion failed
                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: { popup: 'swal2-popup' }
                            });
                        }
                    } catch (e) {
                        console.error("Error parsing response:", e);
                    }
                }
            };

            // Handle network or other errors in the request
            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred while processing your request.',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: { popup: 'swal2-popup' }
                });
            };

            // Send the product_id to the backend for deletion
            xhr.send("product_id=" + product_id);
        }
    });
}







 </script>