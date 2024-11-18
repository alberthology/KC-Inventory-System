                            <div class="row">
                                <h5 class="col-12"> &nbsp Order Detail:</h5>
                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md" name="category_id[]" id="categorySelect" onchange="fetchBrand()">
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
                                    <select class="form-control form-control-md" name="brand_id[]" id="brandSelect" onchange="fetchProducts()">
                                        <option selected hidden disabled>Select Brand</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md" name="product_id[]" id="productSelect" onchange="fetchSize()">
                                        <option selected hidden disabled>Select Product</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md" name="size_id[]" id="sizeSelect" onchange="fetchColor()">
                                        <option selected hidden disabled>Select Size</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select class="form-control form-control-md" name="color_id[]" id="colorSelect" onchange="fetchPrice(this)">
                                        <option selected hidden disabled>Select Color</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="number" name="quantity[]" class="form-control form-control-md" placeholder="Quantity">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <input type="number" name="payment[]" class="form-control form-control-md" placeholder="Payment Amount (₱)">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" name="price[]" id="priceInput" placeholder="Product Price (₱)" readonly>
                                </div>
                            </div>