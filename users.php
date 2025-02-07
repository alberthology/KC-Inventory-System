 <?php
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
                                 <li class="nav-item"><a class="nav-link active" href="#user" data-toggle="tab"><b>System User Accounts</b></a></li>
                                 <!-- <li class="nav-item"><a class="nav-link" href="#brand" data-toggle="tab"><b>BRAND</b></a></li> -->
                             </ul>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="user">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <div class="row">
                                                     <div class="col-auto">
                                                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-user"><i class="fas fa-plus"></i>  &nbsp User Account</button>
                                                     </div>
                                                 </div>
                                                 <!-- /.card-header -->
                                                 <div class="card-body">
                                                     <table id="user-table" class="table table-bordered table-striped table-hover">
                                                         <thead>
                                                             <tr>
                                                                 <th>Name</th>
                                                                 <th>Role</th>
                                                                 <th>Email</th>
                                                                 <th>Date Created</th>
                                                                 <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             <?php

                                                                // Query to fetch data from the user_table
                                                                $query = "SELECT * FROM user_table WHERE role != 'Developer'";
                                                                $result = mysqli_query($conn, $query);

                                                                // Check if any categories exist
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    // Iterate through each user and display in the table
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $datetime = new DateTime($row['created_at']);
                                                                        $formattedDate = $datetime->format('F j, Y, g:i A');

                                                                        echo "<tr id='user-row-{$row['user_id']}'>
                                                                                <td>{$row['full_name']}</td>
                                                                                <td>{$row['role']}</td>
                                                                                <td>{$row['email']}</td>
                                                                                <td>{$formattedDate}</td>
                                                                                <td style='text-align:center;'>
                                                                                    <button class='btn btn-danger btn-sm' onclick='removeUser({$row['user_id']})'>
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
                             </div>
                             
                            <div class="modal fade" id="add-user">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fas fa-tags"></i> Add Another User Account</h4>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions/insert_sql.php" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="fullname" class="form-control form-control-md mb-3" placeholder="Fullname" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="text" name="email" class="form-control form-control-md mb-3" placeholder="Email" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select name="role" class="form-control form-control-md mb-3" required>
                                                            <option selected hidden disabled>Select Role</option>
                                                            <option>Admin</option>
                                                            <option>Manager</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="text" name="username" class="form-control form-control-md mb-3" placeholder="User Name" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="password" name="password" class="form-control form-control-md mb-3" placeholder="Password" required>
                                                    </div>
                                                 </div>
                                                 <hr>
                                                 <div class="row">
                                                     <div class="col-md-6">
                                                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <button type="submit" name="submit-user" class="btn btn-primary btn-sm" style="float: right;">Add</button>
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
         $('#user-table').DataTable({
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

    function removeUser(user_id) {
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
                 // Perform AJAX request to remove user
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
                             var row = document.getElementById("user-row-" + user_id);
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
                 xhr.send("user_id=" + user_id);
             }
         });
     }

 </script>