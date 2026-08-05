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
 <?php
// Ensure that the product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query to fetch product data
    $product_query = "
        SELECT 
            p.product_id, p.product_name, p.description, p.product_size, p.product_color, 
            c.category_id, c.category_name, b.brand_id, b.brand_name, 
            p.quantity_in_stock, p.price
        FROM product_table p
        LEFT JOIN category_table c ON p.category_id = c.category_id
        LEFT JOIN brand_table b ON p.brand_id = b.brand_id
        WHERE p.product_id = '$product_id'
    ";
    $product_result = mysqli_query($conn, $product_query);
    
    // Check if the product exists
    if (mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
    } else {
        // If no product is found, handle the error
        echo "Product not found!";
        exit;
    }

    // Fetch categories
    $categories_query = "SELECT category_id, category_name FROM category_table";
    $categories_result = mysqli_query($conn, $categories_query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($categories_result)) {
        $categories[] = $row;
    }

    // Fetch brands based on the selected category (if needed)
    $brands_query = "SELECT brand_id, brand_name FROM brand_table";
    $brands_result = mysqli_query($conn, $brands_query);
    $brands = [];
    while ($row = mysqli_fetch_assoc($brands_result)) {
        $brands[] = $row;
    }
} else {
    // If product_id is not set in the URL, show an error
    echo "Product ID is missing!";
    exit;
}
?>

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
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="edit_product_name">Product:</label>
                            <input type="text" name="product" id="edit_product_name" class="form-control form-control-md" value="<?php echo $product['product_name']; ?>" placeholder="Product Name">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_category_id">Category:</label>
                            <select class="form-control form-control-md" name="category_id" id="edit_category_id">
                                <option selected hidden disabled>Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>" <?php echo $product['category_id'] == $category['category_id'] ? 'selected' : ''; ?>>
                                        <?php echo $category['category_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_brand_id">Brand:</label>
                            <select class="form-control form-control-md" name="brand_id" id="edit_brand_id">
                                <option selected hidden disabled>Select Brand</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?php echo $brand['brand_id']; ?>" <?php echo $product['brand_id'] == $brand['brand_id'] ? 'selected' : ''; ?>>
                                        <?php echo $brand['brand_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="edit_product_size">Size:</label>
                            <input type="text" name="size" class="form-control form-control-md" id="edit_product_size" value="<?php echo $product['product_size']; ?>" placeholder="Input Size">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="edit_product_color">Color:</label>
                            <input type="text" name="color" class="form-control form-control-md" id="edit_product_color" value="<?php echo $product['product_color']; ?>" placeholder="Input Color">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="edit_quantity_in_stock">Quantity in Stock:</label>
                            <input type="number" name="quantity" class="form-control form-control-md" id="edit_quantity_in_stock" value="<?php echo $product['quantity_in_stock']; ?>" placeholder="Stock Quantity" min="1">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="edit_price">Price:</label>
                            <input type="text" name="price" id="edit_price" class="form-control form-control-md" value="<?php echo $product['price']; ?>" placeholder="Product Price">
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="edit_description">Product Description:</label>
                            <input type="text" name="description" class="description" id="edit_description" value="<?php echo $product['description']; ?>" placeholder="Product Description (optional)">
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


   <?php
    include 'includes/footer.php';
    ?>
