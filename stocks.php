   <?php
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    ?>

   <style>
       .modal-header {
           display: flex;
           justify-content: center;
           /* Centers the content horizontally */
           position: relative;
           /* Ensures close button stays at the right */
       }

       .modal-header .close {
           position: absolute;
           right: 15px;
           /* Keeps the close button on the right */
           top: 15px;
           /* Aligns the close button vertically */
       }

       .modal-title {
           margin: 0 auto;
           /* Centers the title within the header */
           text-align: center;
       }

       .modal-title i {
           margin-right: 10px;
           /* Adds spacing between the icon and text */
       }

       /* Ensure the Select2 dropdown matches the form-control style */
       .select2-container--bootstrap5 .select2-selection {
           height: calc(3.25rem + 2px);
           /* Same as Bootstrap input height */
           padding: 0.375rem 0.75rem;
           /* Same padding as Bootstrap */
           font-size: 1rem;
           line-height: 1.5;
           border: 1px solid #ced4da;
           /* Same border style */
           border-radius: 0.25rem;
           /* Same border radius */
       }

       .select2-container--bootstrap5 .select2-selection__arrow {
           height: calc(2.25rem + 2px);
           /* Ensures the arrow is vertically aligned */
       }
   </style>
   <div class="content-wrapper">

       <section class="content">
           <div class="container-fluid">
               <div class="row">
                   <!-- /.col -->
                   <div class="col-md-12 mt-2">
                       <div class="card">
                           <div class="card-header p-3">
                               <ul class="nav nav-pills">
                                   <li class="nav-item"><a class="nav-link active" href="#shoes" data-toggle="tab"><b>STOCKS TABLE</b></a></li>
                                   <!-- <li class="nav-item"><a class="nav-link" href="#bags" data-toggle="tab"><b>BAGS</b></a></li>
                                   <li class="nav-item"><a class="nav-link" href="#clothes" data-toggle="tab"><b>CLOTHES</b></a></li> -->
                               </ul>
                           </div>
                           <div class="card-body">
                               <div class="tab-content">
                                   <div class="active tab-pane" id="shoes">
                                       <div class="col-12">
                                           <div class="card">
                                               <div class="card-header">
                                                   <div class="row">
                                                       <div class="col-auto">
                                                           <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stocks"><i class="fas fa-box"></i> add stocks</button>
                                                       </div>
                                                       <div class="col-md-3">
                                                           <select class="form-control form-control-sm select2" style="width: 100%;">
                                                               <option selected="selected" disabled>Choose Category</option>
                                                               <option>Alaska</option>
                                                               <option>California</option>
                                                               <option>Delaware</option>
                                                               <option>Tennessee</option>
                                                               <option>Texas</option>
                                                               <option>Washington</option>
                                                           </select>
                                                       </div>
                                                   </div>
                                                   <!-- /.card-header -->
                                                   <div class="card-body">
                                                       <table id="shoes-table" class="table table-bordered table-striped">
                                                           <thead>
                                                               <tr>
                                                                   <th>Code</th>
                                                                   <th>Brand</th>
                                                                   <th>Size</th>
                                                                   <th>Color</th>
                                                                   <th>Price</th>
                                                                   <th>Quantity</th>
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
                                   <div class="modal-dialog modal-lg">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                               <h4 class="modal-title"><i class="fas fa-boxes"></i> Add Category Modal</h4>
                                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>
                                           <div class="modal-body">
                                               <div class="row">
                                                   <div>

                                                   </div>
                                               </div>
                                           </div>
                                           <div class="modal-footer justify-content-between">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                               <button type="button" class="btn btn-primary">Save changes</button>
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
       </section>

   </div>

   <?php
    include 'includes/footer.php';
    ?>
   <script>
       $(document).ready(function() {
           // Initialize shoes-table by default
           $('#shoes-table').DataTable({
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
   </script>

   <script>
       $(function() {
           //Initialize Select2 Elements
           $('.select2').select2()

           //Initialize Select2 Elements
           $('.select2bs4').select2({
               theme: 'bootstrap4'
           })
       })
   </script>

   <script>
       $(document).ready(function() {
           $('.select2').select2({
               theme: 'bootstrap4', // Use Bootstrap4 theme
               width: '100%' // Ensure it fills the width
           });
       });
   </script>