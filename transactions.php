 <?php
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    ?>
 <style>
     .nav-pills .nav-link[href="#ongoing"] {
         background-color: yellow;
         color: black;
         /* Adjust text color for better contrast */
     }

     .nav-pills .nav-link[href="#complete"] {
         background-color: green;
         color: white;
         /* Adjust text color for better contrast */
     }

     .nav-pills .nav-link {
         transition: transform 0.2s;
         /* Smooth transition for scaling */
     }

     .nav-pills .nav-link.active {
         background-color: yellow;
         /* Active color for ONGOING tab */
         color: black;
         /* Text color for ONGOING tab */
         transform: scale(1.1);
         /* Zoom in effect */
         opacity: 0.8;
         /* Slight opacity for emphasis */
     }

     .nav-pills .nav-link[href="#complete"] {
         background-color: green;
         /* Background color for COMPLETE tab */
         color: white;
         /* Text color for COMPLETE tab */
     }

     .nav-pills .nav-link[href="#ongoing"] {
         background-color: yellow;
         /* Background color for ONGOING tab */
         color: black;
         /* Text color for ONGOING tab */
     }
 </style>
 <div class="content-wrapper">

     <div class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12 mt-2">
                     <div class="card">
                         <div class="card-header p-3">
                             <ul class="nav nav-pills">
                                 <li class="nav-item"><a class="nav-link active" href="#ongoing" data-toggle="tab"><b>ONGOING</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#complete" data-toggle="tab"><b>COMPLETE</b></a></li>
                             </ul>
                         </div><!-- /.card-header -->
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="ongoing">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 <button type="submit" class="btn btn-success btn sm"><i class="fa fa-plus"></i> Add Transaction</button>
                                             </div>
                                             <!-- /.card-header -->
                                             <div class="card-body">
                                                 <table id="ongoing-table" class="table table-bordered table-striped">
                                                     <thead>
                                                         <tr>
                                                             <th>Customer Name</th>
                                                             <th>Category</th>
                                                             <th>Brand</th>
                                                             <th>Quantity</th>
                                                             <th>Price</th>
                                                             <th>Payment Status</th>
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
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane" id="complete">
                                     <div class="col-12">
                                         <div class="card">
                                             <!-- /.card-header -->
                                             <div class="card-body">
                                                 <table id="complete-table" class="table table-bordered table-striped">
                                                     <thead>
                                                         <tr>
                                                             <th>Customer Name</th>
                                                             <th>Category</th>
                                                             <th>Brand</th>
                                                             <th>Quantity</th>
                                                             <th>Price</th>
                                                             <th>Payment Status</th>
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
                                 <!-- /.tab-pane -->
                             </div>
                             <!-- /.tab-content -->
                         </div><!-- /.card-body -->
                     </div>
                     <!-- /.card -->
                 </div>
             </div>
         </div>

     </div>

 </div>


 <?php
    include 'includes/footer.php';
    ?>

 <script>
     $(document).ready(function() {
         // Initialize shoes-table by default
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

         // Reinitialize bags-table and clothes-table when their tabs are shown
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var target = $(e.target).attr("href"); // Get the target tab

             if (target === "#complete") {
                 if (!$.fn.DataTable.isDataTable('#complete-table')) {
                     $('#complete-table').DataTable({
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
     $(document).ready(function() {
         // Check if there's a saved active tab in localStorage
         var activeTab = localStorage.getItem('activeTab');
         if (activeTab) {
             // Activate the saved tab
             $('.nav-pills a[href="' + activeTab + '"]').tab('show');
         }

         // Add click event to tabs
         $('.nav-pills a').on('shown.bs.tab', function(e) {
             // Save the active tab to localStorage
             var href = $(e.target).attr('href');
             localStorage.setItem('activeTab', href);
         });
     });
 </script>