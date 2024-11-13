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
                            <h3>List of Product Brands Available in the System</h3>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="category">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                    <table id="brand-table" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Brand</th>
                                                                <th>Category</th>
                                                                <th>Description</th>
                                                                <th>Originated From</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                // Query to fetch data from the brand_table
                                                $query = "
                                                SELECT 
                                                    b.brand_id,
                                                    b.brand_name,
                                                    c.category_name,
                                                    b.description,
                                                    b.country_of_origin
                                                FROM brand_table b
                                                LEFT JOIN category_table c ON b.category_id = c.category_id
                                                ";
                                                $result = mysqli_query($conn, $query);

                                                // Check if any brands exist
                                                if (mysqli_num_rows($result) > 0) {
                                                    // Iterate through each brand and display in the table
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr id='brand-row-{$row['brand_id']}'>
                                                                <td>{$row['brand_id']}</td>
                                                                <td>
                                                                {$row['brand_name']}
                                                                </td>
                                                                <td>
                                                                {$row['category_name']}
                                                                </td>
                                                                <td>
                                                                {$row['description']}
                                                                </td>
                                                                <td>
                                                                {$row['country_of_origin']}
                                                                </td>
                                                            </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5'>No brands found.</td></tr>";
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
    include 'includes/footer.php';
    include 'message.php';
    ?>

 <script>
     $(document).ready(
        function() {
         // Initialize shoes-table by default
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
     });

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