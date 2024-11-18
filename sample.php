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
                                 <li class="nav-item"><a class="nav-link active" href="#order" data-toggle="tab"><b>Order Transaction</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#ongoing" data-toggle="tab"><b>Ongoing Order</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#completed" data-toggle="tab"><b>Completed Order</b></a></li>
                             </ul>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="order">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-order"><i class="fas fa-plus"></i>  &nbsp Place Customer Order</button>
                                                    </div>
                                                </div>
                                                 <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="order-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Customer</th>
                                                            <th>Product</th>
                                                            <th>Unit Quantity & Price</th>
                                                            <th>Total Price</th>
                                                            <th>Transaction Date</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                             <?php

                                                                // Query to fetch data from the order_table
                                                                $query = "
                                                                SELECT
                                                                    o.order_item_id,
                                                                    c.order_id,
                                                                    p.product_name,
                                                                    o.quantity,
                                                                    o.unit_price,
                                                                    o.total_price,
                                                                    p.quantity_in_stock,
                                                                    b.brand_name,
                                                                    a.category_name,
                                                                    p.price,
                                                                    c.order_date,
                                                                    c.total_amount,
                                                                    c.status
                                                                FROM order_item_table o
                                                                LEFT JOIN order_table c ON o.order_id = c.order_id
                                                                LEFT JOIN product_table p ON o.product_id = p.product_id
                                                                LEFT JOIN category_table a ON p.category_id = a.category_id
                                                                LEFT JOIN brand_table b ON p.brand_id = b.brand_id";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr id='category-row-{$row['order_item_id']}'>
                                                                                <td>{$row['order_id']}</td>
                                                                                <td>{$row['customer_name']}</td>
                                                                                <td>{$row['product_name']}</td>
                                                                                <td>{$row['quantity']} items with ₱{$row['unit_price']} unit price</td>
                                                                                <td>₱{$row['total_price']}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-danger btn-sm' onclick='removeCategory({$row['order_id']})'>Remove</button>
                                                                                </td>
                                                                            </tr>";
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
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

                                <div class="tab-pane" id="ongoing">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">

                                                 <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="ongoing-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Customer</th>
                                                            <th>Date Ordered</th>
                                                            <th>Total Amount</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                             <?php

                                                                // Query to fetch data from the order_table
                                                                $query = "
                                                                SELECT
                                                                    o.order_id,
                                                                    c.customer_name,
                                                                    o.order_date,
                                                                    o.total_amount,
                                                                    o.status
                                                                FROM order_table o
                                                                LEFT JOIN customer_table c ON o.customer_id = c.customer_id";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr id='category-row-{$row['order_id']}'>
                                                                                <td>{$row['order_id']}</td>
                                                                                <td>{$row['customer_name']}</td>
                                                                                <td>{$row['order_date']}</td>
                                                                                <td>{$row['total_amount']}</td>
                                                                                <td>{$row['status']}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-danger btn-sm' onclick='removeCategory({$row['order_id']})'>Remove</button>
                                                                                </td>
                                                                            </tr>";
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
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


                                <div class="tab-pane" id="completed">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">

                                                 <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="completed-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Customer</th>
                                                            <th>Date Ordered</th>
                                                            <th>Total Amount</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                             <?php

                                                                // Query to fetch data from the order_table
                                                                $query = "
                                                                SELECT
                                                                    o.order_id,
                                                                    c.customer_name,
                                                                    o.order_date,
                                                                    o.total_amount,
                                                                    o.status
                                                                FROM order_table o
                                                                LEFT JOIN customer_table c ON o.customer_id = c.customer_id";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr id='category-row-{$row['order_id']}'>
                                                                                <td>{$row['order_id']}</td>
                                                                                <td>{$row['customer_name']}</td>
                                                                                <td>{$row['order_date']}</td>
                                                                                <td>{$row['total_amount']}</td>
                                                                                <td>{$row['status']}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-danger btn-sm' onclick='removeCategory({$row['order_id']})'>Remove</button>
                                                                                </td>
                                                                            </tr>";
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
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
                                                    <label for="edit_category_id">Category</label>
                                                    <select class="form-control form-control-md" name="category_id" id="edit_category_id">
                                                        <option selected hidden disabled>Select Category</option>
                                                        <!-- Categories will be populated here by JavaScript -->
                                                    </select>
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
<!-- Place Order Modal Form -->
<div class="modal fade" id="add-order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-tags"></i> Order Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="functions/insert_sql.php" method="post" id="orderForm">
                    <!-- Customer Information Section -->
                    <div class="row">
                        <h5 class="col-12"> &nbsp Customer Information:</h5>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="customer_name" class="form-control form-control-md" placeholder="Customer Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="contact_number" class="form-control form-control-md" placeholder="Contact Number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="email" class="form-control form-control-md" placeholder="Email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="address" class="form-control form-control-md" placeholder="Address" required>
                        </div>
                    </div>
                    <hr>

                    <!-- Dynamic Order Items Section -->
                    <div id="order-items">
                        <!-- Initial Product Selection -->
                        <div class="order-item">
                            <h5 class="col-12"> &nbsp Order Detail:</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md categorySelect" name="category_id[]" onchange="fetchBrand(this)">
                                        <option selected hidden disabled>Select Category</option>
                                        <?php
                                        $query = "SELECT * FROM category_table";
                                        $result = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='". $row['category_id'] ."'>". $row['category_name']."</option>";
                                            }
                                        } else {
                                            echo "<option disabled>No Categories Available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md brandSelect" name="brand_id[]" onchange="fetchProducts(this)">
                                        <option selected hidden disabled>Select Brand</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md productSelect" name="product_id[]" onchange="fetchPrice(this)">
                                        <option selected hidden disabled>Select Product</option>
                                    </select>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" name="quantity[]" class="form-control form-control-md" placeholder="Quantity">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" name="payment[]" class="form-control form-control-md" placeholder="Payment Amount (₱)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" name="price[]" placeholder="Product Price (₱)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Product</button>
                    <hr>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-md-6 text-right mb-3">
                            <button type="submit" name="submit-order" class="btn btn-primary btn-md">Submit Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    // Fetch Brands based on selected category
    function fetchBrand(selectElement) {
        const categoryId = selectElement.value;
        const brandSelect = selectElement.closest('.order-item').querySelector('.brandSelect');

        brandSelect.innerHTML = '<option selected hidden disabled>Select Brand</option>'; // Reset brands dropdown

        fetch(`functions/fetch_brands.php?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.brand_id;  // Use brand_id from the data
                        option.textContent = brand.brand_name;  // Use brand_name from the data
                        brandSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'No Brands Available';
                    brandSelect.appendChild(option);
                }
            })
            .catch(error => console.error('Error fetching brands:', error));
    }

    // Fetch Products based on selected brand
    function fetchProducts(selectElement) {
        const brandId = selectElement.value;
        const productSelect = selectElement.closest('.order-item').querySelector('.productSelect');

        productSelect.innerHTML = '<option selected hidden disabled>Select Product</option>'; // Reset products dropdown

        fetch(`functions/fetch_products.php?brand_id=${brandId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.product_id;  // Use product_id from the data
                        option.textContent = product.formatted_name;  // Use formatted product_name with size and color
                        productSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'No Products Available';
                    productSelect.appendChild(option);
                }
            })
            .catch(error => console.error('Error fetching products:', error));
    }

    // Fetch Price based on selected product
    function fetchPrice(selectElement) {
        const productId = selectElement.value;
        const priceInput = selectElement.closest('.order-item').querySelector('input[name="price[]"]');

        fetch(`functions/fetch_price.php?product_id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.price) {
                    priceInput.value = data.price;
                } else {
                    priceInput.value = 'Price Not Available';
                }
            })
            .catch(error => console.error('Error fetching price:', error));
    }

    // Add another order item dynamically
    function addItem() {
        const orderItemsDiv = document.getElementById('order-items');
        const newItem = document.createElement('div');
        newItem.classList.add('order-item');
        newItem.innerHTML = `
            <h5 class="col-12"> &nbsp Order Detail:</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select class="form-control form-control-md categorySelect" name="category_id[]" onchange="fetchBrand(this)">
                        <option selected hidden disabled>Select Category</option>
                        <?php
                        $query = "SELECT * FROM category_table";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='". $row['category_id'] ."'>". $row['category_name']."</option>";
                            }
                        } else {
                            echo "<option disabled>No Categories Available</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <select class="form-control form-control-md brandSelect" name="brand_id[]" onchange="fetchProducts(this)">
                        <option selected hidden disabled>Select Brand</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <select class="form-control form-control-md productSelect" name="product_id[]" onchange="fetchPrice(this)">
                        <option selected hidden disabled>Select Product</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="number" name="quantity[]" class="form-control form-control-md" placeholder="Quantity">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="number" name="payment[]" class="form-control form-control-md" placeholder="Payment Amount (₱)">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="price[]" placeholder="Product Price (₱)" readonly>
                </div>
            </div>
        `;
        orderItemsDiv.appendChild(newItem);
    }
</script>




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
$(document).ready(function() {
    // Initialize Select2 on the productSelect
    $('.productSelect').select2({
        placeholder: 'Select Product',  // Placeholder text
        allowClear: true,               // Option to clear selection
        width: '100%'                   // Make Select2 full width
    });
});

     $(document).ready(function() {
         // Initialize shoes-table by default
         $('#order-table').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true,
             "responsive": true,
             "pageLength": 10 // Display 10 items per page
         });

         // Reinitialize bags-table and clothes-table when their tabs are shown
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var target = $(e.target).attr("href"); // Get the target tab

             if (target === "#ongoing") {
                 if (!$.fn.DataTable.isDataTable('#ongoing-table')) {
                     $('#ongoing-table').DataTable({
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         "pageLength": 10 // Display 10 items per page
                     });
                 }
             }
         });
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var target = $(e.target).attr("href"); // Get the target tab

             if (target === "#Completed") {
                 if (!$.fn.DataTable.isDataTable('#completed-table')) {
                     $('#Completed-table').DataTable({
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         "pageLength": 10 // Display 10 items per page
                     });
                 }
             }
         });
     });


// Function to open the edit modal and populate it with data
function openEditModal(id, brand, category_id, origin_country, description) {
    // Set the values in the modal fields
    $('#edit_brand_id').val(id);
    $('#edit_brand_name').val(brand);
    $('#edit_origin_country').val(origin_country);
    $('#edit_description').val(description);

    // Now, load the categories into the dropdown and select the current category
    loadCategories(category_id);

    // Show the modal
    $('#edit-stocks').modal('show');
}

// Function to load categories dynamically via AJAX
function loadCategories(selectedCategoryId) {
    $.ajax({
        url: 'functions/get_categories.php',  // Adjust the path to where your PHP script is
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var selectElement = $('#edit_category_id');
            selectElement.empty();  // Clear existing options

            // Add the default "Select Category" option
            selectElement.append('<option selected hidden disabled>Select Category</option>');

            // Add the options for each category
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
             confirmButtonText: 'Yes, delete it!',
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
             confirmButtonText: 'Yes, delete it!',
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
 </script>