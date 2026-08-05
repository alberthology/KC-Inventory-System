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
                            <h3>List of Product Category</h3>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="category">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">

                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="category-table" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                             <tr>
                                                                 <th>Category ID</th>
                                                                 <th>Category Name</th>
                                                                 <th>Description</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php

                                                                // Query to fetch data from the category_table
                                                                $query = "SELECT * FROM category_table";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr id='category-row-{$row['category_id']}'>
                                                                                <td>{$row['category_id']}</td>
                                                                                <td>
                                                                                    {$row['category_name']}
                                                                                </td>
                                                                                <td>
                                                                                    {$row['description']}
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

                                 <div class="tab-pane" id="brand">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-plus"></i> &nbsp Brand</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="brand-table" class="table table-bordered table-striped">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand Name</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                        <tbody>
<?php
    // Query to fetch data from the brand_table
    $query = "SELECT * FROM brand_table";
    $result = mysqli_query($conn, $query);

    // Check if any brands exist
    if (mysqli_num_rows($result) > 0) {
        // Iterate through each brand and display in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='brand-row-{$row['brand_id']}'>
                    <td>{$row['brand_name']}</td>
                    <td style='text-align:center;'>
                        <button class='btn btn-primary' onclick='openEditModal({$row['brand_id']}, \"{$row['brand_name']}\", \"{$row['country_of_origin']}\", \"{$row['description']}\")'>
                            <i class='fas fa-edit'></i>
                        </button> &nbsp 
                        <button class='btn btn-danger' onclick='removeBrand({$row['brand_id']})'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No brands found.</td></tr>";
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
                            <div class="modal fade" id="add-stocks">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form id="stockForm" action="functions/insert_sql.php" method="post">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp Add Product Brands</h4>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="brand" class="form-control form-control-md" placeholder="Brand Name">
                                                    </div>
                                                   <div class="col-md-12">
                                                        <input type="text" name="origin_country" class="form-control form-control-md" placeholder="Originated Country">
                                                    </div>
                                                    <div class="col-md-12">

                                                        <input type="text" name="description" class="description" placeholder="Brand Description">
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type="submit" name="submit-brand" class="btn btn-primary" style="float: right;">Add</button>
                                        </div>
                                        </form>
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
                                            <h4 class="modal-title"><i class="fas fa-tags"></i> Add Product Category</h4>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions/insert_sql.php" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="category" class="form-control form-control-md" placeholder="Category Name">
                                                    </div>
                                                    <div class="col-md-12">

                                                        <input type="text" name="description" class="description" placeholder="Category Description">
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
         // Initialize shoes-table by default
         $('#category-table').DataTable({
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

             if (target === "#brand") {
                 if (!$.fn.DataTable.isDataTable('#brand-table')) {
                     $('#brand-table').DataTable({
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
function openEditModal(id, brand, origin_country, description) {
    // Set the values in the modal fields
    $('#edit_brand_id').val(id);
    $('#edit_brand_name').val(brand);
    $('#edit_origin_country').val(origin_country);
    $('#edit_description').val(description);

    // Show the modal
    $('#edit-stocks').modal('show');
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