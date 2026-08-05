 <?php
    include '..\functions/db_con.php';
    include '..\includes/user-header.php';
    include '..\includes/nav.php';
    include '..\includes/user-sidebar.php';
    ?>

 <div class="content-wrapper">

     <div class="content">
         <div class="container-fluid">
             <div class="row mt-3">
                 <?php
                    $dsp_sql = "SELECT 
                (SELECT COUNT(*) FROM product_table) AS total_products,
                (SELECT COUNT(*) FROM brand_table) AS total_brands,
                (SELECT SUM(CASE WHEN quantity_in_stock < 5 AND quantity_in_stock > 0 THEN 1 ELSE 0 END) FROM product_table) AS low_stock_products,
                (SELECT SUM(CASE WHEN quantity_in_stock = 0 THEN 1 ELSE 0 END) FROM product_table) AS out_of_stock_products";

                    $run = $conn->query($dsp_sql);

                    if ($run) {
                        $fetch_result = mysqli_fetch_assoc($run);
                        $display_count = $fetch_result;
                    } else {
                        // Handle query error
                        echo "Error: " . $conn->error;
                    }
                    ?>


                 <!-- /.col -->

                 <div class="col-12 col-sm-6 col-md-6">
                     <div class="info-box mb-3">
                         <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">Low Stock Products</span>
                             <span class="info-box-number"><?php echo $display_count['low_stock_products']; ?>
                                 <small> low quantity product/s </small>

                             </span>
                         </div>
                     </div>
                 </div>
                 <!-- /.col -->

                 <div class="col-12 col-sm-6 col-md-6">
                     <div class="info-box mb-3">
                         <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

                         <div class="info-box-content">
                             <span class="info-box-text">Out-of-Stock Products</span>
                             <span class="info-box-number"><?php echo $display_count['out_of_stock_products']; ?>
                                 <small> Out-of-stock product/s</small>

                             </span>
                         </div>
                     </div>
                 </div>
                 <!-- /.col -->
             </div>

             <div class="row">
                 <div class="col-md-12 mt-2">
                     <div class="card">
                         <div class="card-header p-3">
                             <ul class="nav nav-pills">
                                 <!-- <li class="nav-item"><a class="nav-link" href="#brand" data-toggle="tab"><b>BRAND</b></a></li> -->
                                 <li class="nav-item"><a class="nav-link tbl active" href="#product" data-toggle="tab"><b>PRODUCT LIST</b></a></li>
                                 <li class="nav-item"><a class="nav-link tbl" href="#category" data-toggle="tab"><b>BRAND LIST</b></a></li>
                             </ul>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="product">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <!-- /.card-header -->
                                                 <div class="card-body">


                                                     <table id="product-table" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                             <tr>
                                                                 <!-- <th>Product Code</th> -->
                                                                 <th>Product</th>
                                                                 <th>Color</th>
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
        p.product_id,  
        p.product_name, 
        p.category_id, 
        p.brand_id, 
        p.quantity_in_stock, 
        p.price, 
        p.product_size, 
        p.product_color, 
        p.description, 
        c.category_name, 
        b.brand_name
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
                                                                        $quantity_color = ($row['quantity_in_stock'] == 0) ? 'class="bg-danger"' : (($row['quantity_in_stock'] < 5) ? 'class="bg-warning"' : '');


                                                                        echo "<tr id='product-row-{$row['product_id']}'>
                                                                                <td>{$row['brand_name']} {$row['product_name']}</td>
                                                                                <td>{$row['product_color']}</td>
                                                                                <td {$quantity_color}>{$row['quantity_in_stock']}</td>
                                                                                <td>{$formatted_price}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-primary btn-sm' onclick='openEditModal(
                                                                                        {$row['product_id']}, 
                                                                                        \"{$row['product_name']}\" , 
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
                                                                                        <i class='fas fa-solid fa-folder-open'></i>
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

                                 <!-- Edit Stock Modal -->
                                 <div class="modal fade" id="edit-stocks">
                                     <div class="modal-dialog modal-lg">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; Product Details</h4>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-body mb-5">

                                                 <input type="hidden" name="form_type" value="update_product">
                                                 <input type="hidden" name="product_id" id="edit_product_id">

                                                 <div class="row">
                                                     <!-- Product Name -->
                                                     <div class="col-md-12">
                                                         <label for="edit_product_name">Product Name:</label>
                                                         <input type="text" name="product" id="edit_product_name" class="form-control form-control-md uppercase-input" placeholder="Product Name" disabled>
                                                     </div>



                                                     <!-- Product Size -->
                                                     <div class="col-md-6 mt-3">
                                                         <label for="edit_size">Size:</label>
                                                         <input type="text" name="size" class="form-control form-control-md uppercase-input" id="edit_size" placeholder="Product Size" disabled>
                                                     </div>

                                                     <!-- Product Color -->
                                                     <div class="col-md-6 mt-3">
                                                         <label for="edit_color">Color:</label>
                                                         <input type="text" name="color" class="form-control form-control-md uppercase-input" id="edit_color" placeholder="Product Color" disabled>
                                                     </div>

                                                     <!-- Quantity in Stock -->
                                                     <div class="col-md-6 mt-3">
                                                         <label for="edit_quantity">Quantity in Stock:</label>
                                                         <input type="number" name="quantity" class="form-control form-control-md uppercase-input" id="edit_quantity" placeholder="Stock Quantity" min="1" disabled>
                                                     </div>

                                                     <!-- Price -->
                                                     <div class="col-md-6 mt-3">
                                                         <label for="edit_price">Price:</label>
                                                         <input type="text" name="price" id="edit_price" class="form-control form-control-md uppercase-input" placeholder="Product Price" disabled>
                                                     </div>
                                                 </div>

                                                 <hr>

                                             </div>
                                             <div class="modal-footer justify-content-between mt-5">
                                                 <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="tab-pane" id="category">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">

                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="category-table" class="table table-bordered table-striped table-hover" style="width:100%;">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand</th>
                                                                 <th>Category</th>
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
                                                                        echo "
                                                                            <tr id='brand-row-{$row['brand_id']}'>
                                                                                <td>{$row['brand_name']}</td>
                                                                                <td>{$row['category_name']}</td>

                                                                            </tr>";
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='3'>No brand and categories found.</td></tr>";
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

                         </div>
                     </div>

                 </div>

             </div>
         </div>

     </div>

 </div>


 <?php
    include '../includes/footer.php';
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
             $('#product-table').css('display', 'table');
             $('#brand-table').css('display', 'table');

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
         const categoryField = document.getElementById("edit_category");
         if (categoryField) categoryField.value = category;

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
             width: '30%', // Adjust the width here

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
             width: '30%', // Adjust the width here
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
                             });
                         } else {
                             // Show error message
                             Swal.fire({
                                 icon: 'error',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
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
             width: '30%', // Adjust the width here
         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove product
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/delete_sql.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState === 4 && xhr.status === 200) {
                         try {
                             // Parse the JSON response
                             var response = JSON.parse(xhr.responseText);

                             // Check if the removal was successful
                             if (response.status === "success") {
                                 // Remove the row from the table
                                 var row = document.getElementById("product-row-" + product_id);
                                 if (row) {
                                     row.parentNode.removeChild(row);
                                 }

                                 // Show SweetAlert success message
                                 Swal.fire({
                                     icon: 'success',
                                     title: response.message,
                                     position: 'top-end',
                                     showConfirmButton: false,
                                     timer: 1500,
                                 });
                             } else {
                                 // Show SweetAlert error message
                                 Swal.fire({
                                     icon: 'error',
                                     title: response.message,
                                     position: 'top-end',
                                     showConfirmButton: false,
                                     timer: 1500,
                                 });
                             }
                         } catch (e) {
                             console.error("Error parsing response:", e, xhr.responseText);

                             // Show SweetAlert error message
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Error processing the request!',
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                             });
                         }
                     }
                 };

                 // Send the product_id to the server
                 xhr.send("product_id=" + encodeURIComponent(product_id));
             }
         });
     }
 </script>