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
                             <h3>List of Products</h3>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="Product">
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
                                                    <table id="product-table" class="table table-bordered table-striped table-hover">
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
        p.product_id, 
        p.product_name, 
        c.category_name, 
        b.brand_name, 
        p.quantity_in_stock, 
        p.price, 
        s.supplier_name
    FROM product_table p
    LEFT JOIN category_table c ON p.category_id = c.category_id
    LEFT JOIN brand_table b ON p.brand_id = b.brand_id
    LEFT JOIN supplier_table s ON p.supplier_id = s.supplier_id
";

$result = mysqli_query($conn, $query);

// Check if any products exist
if (mysqli_num_rows($result) > 0) {
    // Iterate through each Product and display in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr id='product-row-{$row['product_id']}'>
                <td>{$row['product_id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['category_name']}</td> <!-- Show category name -->
                <td>{$row['brand_name']}</td> <!-- Show brand name -->
                <td>{$row['quantity_in_stock']}</td>
                <td>{$row['price']}</td>
                <td style='text-align:center;'>
                    <button class='btn btn-danger btn-sm' onclick='removeProduct({$row['product_id']})'>Remove</button>
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
                                                        <input type="text" name="Product" class="form-control form-control-md" placeholder="Product Name">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <select class="form-control form-control-md" name="category_id">
                                                            <option selected hidden disabled>Select Category</option>
        <?php           // Query to fetch data from the category_table
                $query = "SELECT * FROM category_table";
                $result = mysqli_query($conn, $query);

                // Check if any categories exist
                if (mysqli_num_rows($result) > 0) {
                    // Iterate through each category and display in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='". $row['category_id'] ."'>". $row['category_name']."</option>";
                    }
                } else {
                    echo "<option disabled>No Category Available</option>";
                }
                ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select class="form-control form-control-md" name="brand_id">
                                                            <option selected hidden disabled>Select Brand</option>
        <?php           // Query to fetch data from the brand_table
                $query = "SELECT * FROM brand_table";
                $result = mysqli_query($conn, $query);

                // Check if any categories exist
                if (mysqli_num_rows($result) > 0) {
                    // Iterate through each brand and display in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='". $row['brand_id'] ."'>". $row['brand_name']."</option>";
                    }
                } else {
                    echo "<option disabled>No Brand Available</option>";
                }
                ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select class="form-control form-control-md" name="supplier_id">
                                                            <option selected hidden disabled>Select Supplier</option>
        <?php           // Query to fetch data from the supplier_table
                $query = "SELECT * FROM supplier_table";
                $result = mysqli_query($conn, $query);

                // Check if any categories exist
                if (mysqli_num_rows($result) > 0) {
                    // Iterate through each supplier and display in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='". $row['supplier_id'] ."'>". $row['supplier_name']."</option>";
                    }
                } else {
                    echo "<option disabled>No supplier Available</option>";
                }
                ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="number" name="Quantity" class="form-control form-control-md" placeholder="Stock Quantity">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="number" name="Price" class="form-control form-control-md" placeholder="Product Price">
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
                                            <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; Edit Product Brand</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editStockForm" action="functions/edit_sql.php" method="post">

                                                <!-- Hidden field to store the ID of the record to edit -->
                                                <input type="hidden" name="brand_id" id="edit_brand_id">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="edit_brand_name">Brand Name</label>
                                                        <input type="text" name="brand" id="edit_brand_name" class="form-control form-control-md" placeholder="Brand Name">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="edit_origin_country">Origin Country</label>
                                                        <input type="text" name="origin_country" id="edit_origin_country" class="form-control form-control-md" placeholder="Originated Country">
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
     $(document).ready(
        function() {
         // Initialize shoes-table by default
         $('#product-table').DataTable({
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


// Function to open the edit modal and populate it with data
function openEditModal(id, brand, origin_country, description) {
    // Set the values in the modal fields
    $('#edit_brand_id').val(id);
    $('#edit_brand_name').val(brand);
    $('#edit_origin_country').val(origin_country);
    $('#edit_description').val(description);

    // Show the modal
    $('#edit-stocks').modal('show');
}
function removeProduct(product_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
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