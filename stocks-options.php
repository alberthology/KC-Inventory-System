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
                                 <li class="nav-item"><a class="nav-link active" href="#category" data-toggle="tab"><b>CATEGORY</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#brand" data-toggle="tab"><b>BRAND</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#sizes" data-toggle="tab"><b>SIZES</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#color" data-toggle="tab"><b>COLOR</b></a></li>
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
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-category"><i class="fas fa-plus"></i> add category</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="category-table" class="table table-bordered table-striped">
                                                         <thead>
                                                             <tr>
                                                                 <th>Category Name</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php

                                                                // Query to fetch data from the category_table
                                                                $query = "SELECT cat_id, cat_name FROM category_table";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each category and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr id='category-row-{$row['cat_id']}'>
                                                                                <td>{$row['cat_name']}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-danger btn-sm' onclick='removeCategory({$row['cat_id']})'>Remove</button>
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
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-plus"></i> add brand</button>
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
                                                         </tbody>
                                                     </table>
                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                 </div>

                                 <div class="tab-pane" id="sizes">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-plus"></i> add sizes</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="sizes-table" class="table table-bordered table-striped">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand Name</th>
                                                                 <th>Sizes</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                 </div>

                                 <div class="tab-pane" id="color">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-plus"></i> add color</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="color-table" class="table table-bordered table-striped">
                                                         <thead>
                                                             <tr>
                                                                 <th>Brand Name</th>
                                                                 <th>Color</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                 </div>
                                 <!-- /.tab-content -->
                             </div>
                             <!-- add stock modal -->
                             <div class="modal fade" id="add-stocks">
                                 <div class="modal-dialog modal-lg">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h4 class="modal-title"><i class="fas fa-box"></i> Add Stocks Modal</h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <div class="modal-body">
                                             <form id="stockForm">
                                                 <div class="container-fluid">
                                                     <div class="row">
                                                         <!-- Category Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="categorySelect"><i class="fas fa-tags"></i> Category</label>
                                                                 <select class="form-control select2" id="categorySelect" style="width: 100%;" required>
                                                                     <option value="">Select Category</option>
                                                                     <!-- Add your categories here -->
                                                                 </select>
                                                             </div>
                                                         </div>
                                                         <!-- Brand Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="brandInput"><i class="fas fa-building"></i> Brand</label>
                                                                 <select class="form-control select2" id="brandSelect" style="width: 100%;" required>
                                                                     <option value="">Select Brand</option>
                                                                 </select>
                                                             </div>
                                                         </div>
                                                         <!-- Size Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="sizeInput"><i class="fas fa-ruler-combined"></i> Size</label>
                                                                 <select class="form-control select2" id="sizeSelect" style="width: 100%;" required>
                                                                     <option value="">Select Size</option>
                                                                 </select>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="row">
                                                         <!-- Color Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="colorSelect"><i class="fas fa-palette"></i> Color</label>
                                                                 <select class="form-control select2" id="colorSelect" style="width: 100%;" required>
                                                                     <option value="">Select Color</option>
                                                                     <!-- Add your colors here -->
                                                                 </select>
                                                             </div>
                                                         </div>
                                                         <!-- Price Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="priceInput"><i class="fas fa-peso-sign"></i> Price</label>
                                                                 <input type="number" class="form-control" id="priceInput" placeholder="Enter Price" required>
                                                             </div>
                                                         </div>
                                                         <!-- Quantity Field -->
                                                         <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="quantityInput"><i class="fas fa-boxes"></i> Quantity</label>
                                                                 <input type="number" class="form-control" id="quantityInput" placeholder="Enter Quantity" required>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>
                                         <div class="modal-footer justify-content-between">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-primary">Save changes</button>
                                         </div>
                                     </div>
                                     <!-- /.modal-content -->
                                 </div>
                                 <!-- /.modal-dialog -->
                             </div>


                             <div class="modal fade" id="add-category">
                                 <div class="modal-dialog modal-sm">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h4 class="modal-title"><i class="fas fa-boxes"></i> Add Category Modal</h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <div class="modal-body">
                                             <form action="functions/add_category.php" method="post">
                                                 <div class="row">
                                                     <div class="col-md-12">
                                                         <input type="text" name="category" class="form-control form-control-sm" placeholder="Category Name">
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

             if (target === "#sizes") {
                 if (!$.fn.DataTable.isDataTable('#sizes-table')) {
                     $('#sizes-table').DataTable({
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

             if (target === "#color") {
                 if (!$.fn.DataTable.isDataTable('#color-table')) {
                     $('#color-table').DataTable({
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
 </script>

 <script>
     function removeCategory(cat_id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove category
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/remove_category.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                         // Parse the JSON response
                         var response = JSON.parse(xhr.responseText);

                         // Check if the removal was successful
                         if (response.status === "success") {
                             // Remove the row from the table
                             var row = document.getElementById("category-row-" + cat_id);
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
                 xhr.send("cat_id=" + cat_id);
             }
         });
     }
 </script>