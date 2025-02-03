 <?php
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    ?>

 <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <div class="content">
         <div class="container-fluid">
             <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <?php
                    // Query to count new orders
                    $query = "SELECT COUNT(*) AS total_orders 
                    FROM order_item_table o 
                    LEFT JOIN order_table i ON o.order_id = i.order_id
                    WHERE MONTH(i.order_date) = MONTH(CURDATE()) AND YEAR(i.order_date) = YEAR(CURDATE()) AND o.total_price = o.payment;";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $new_orders_count = $row['total_orders'];

                    // Query to calculate total sales for the current month where orders are fully paid
                    $query2 = "
                        SELECT SUM(o.total_price) AS total_sales 
                        FROM order_item_table o
                        LEFT JOIN order_table i ON o.order_id = i.order_id
                        WHERE 
                            MONTH(i.order_date) = MONTH(CURDATE()) 
                            AND YEAR(i.order_date) = YEAR(CURDATE()) 
                            /*AND o.total_price = o.payment*/;
                    ";

                    // Execute the query
                    $result2 = mysqli_query($conn, $query2);

                    // Check for query errors
                    if ($result2) {
                        $row2 = mysqli_fetch_assoc($result2);
                        $new_orders_count2 = $row2['total_sales'] ?? 0; // Default to 0 if no data
                    } else {
                        // Log or display error for debugging
                        error_log("Query failed: " . mysqli_error($conn));
                        $new_orders_count2 = 0;
                    }


                    $query3 = "SELECT COUNT(*) AS pending_orders 
                    FROM order_item_table o 
                    LEFT JOIN order_table i ON o.order_id = i.order_id
                    WHERE MONTH(i.order_date) = MONTH(CURDATE()) AND YEAR(i.order_date) = YEAR(CURDATE()) AND o.total_price != o.payment;";
                    $result3 = mysqli_query($conn, $query3);
                    $row3 = mysqli_fetch_assoc($result3);
                    $pendeing_orders_count = $row3['pending_orders'];

                    $query4 = "
                    SELECT SUM(o.total_price - o.payment) AS pending_amount 
                    FROM order_item_table o
                    LEFT JOIN order_table i ON o.order_id = i.order_id
                    WHERE 
                        MONTH(i.order_date) = MONTH(CURDATE()) 
                        AND YEAR(i.order_date) = YEAR(CURDATE()) 
                        AND o.total_price != o.payment;
                ";

                // Execute the query
                $result4 = mysqli_query($conn, $query4);

                // Check for query errors
                if ($result4) {
                    $row4 = mysqli_fetch_assoc($result4);
                    $pending_amount = $row4['pending_amount'] ?? 0; // Default to 0 if no data

                    $pending_amount; // Display the pending amount
                } else {
                    // Log or display error for debugging
                    error_log("Query failed: " . mysqli_error($conn));
                    $pending_amount = 0;
                }

/*=================================== future study ====================================*/

/*$query = "
    SELECT 
        COUNT(CASE WHEN o.total_price = o.payment THEN 1 END) AS total_orders,
        SUM(CASE WHEN o.total_price = o.payment THEN o.total_price ELSE 0 END) AS total_sales,
        COUNT(CASE WHEN o.total_price != o.payment THEN 1 END) AS pending_orders,
        SUM(CASE WHEN o.total_price != o.payment THEN o.total_price - o.payment ELSE 0 END) AS pending_amount
    FROM order_item_table o
    LEFT JOIN order_table i ON o.order_id = i.order_id
    WHERE 
        MONTH(i.order_date) = MONTH(CURDATE()) 
        AND YEAR(i.order_date) = YEAR(CURDATE());
";

$result = mysqli_query($conn, $query);

// Check for query errors
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $new_orders_count = $row['total_orders'] ?? 0;
    $total_sales = $row['total_sales'] ?? 0;
    $pending_orders_count = $row['pending_orders'] ?? 0;
    $pending_amount = $row['pending_amount'] ?? 0;

    echo "New Orders: $new_orders_count<br>";
    echo "Total Sales: $total_sales<br>";
    echo "Pending Orders: $pending_orders_count<br>";
    echo "Pending Amount: $pending_amount<br>";
} else {
    // Log or display error for debugging
    error_log("Query failed: " . mysqli_error($conn));
}
*/

                    ?>

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $new_orders_count; ?></h3>
                            <p>Total Orders Completed <small class="text">(Total Items Sold)</small></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="transactions.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>

                  </div>
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>₱ <?php echo $new_orders_count2; ?>
                          <!-- <sup style="font-size: 20px"></sup> -->
                        </h3>

                        <p>Total Sales <small class="text">(Total Amount Sold)</small></p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                      <a href="transactions.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3><?php echo $pendeing_orders_count; ?></h3>

                        <p>Pending Transactions <small class="text-muted">(Total Of Partially Paid Items)</small></p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                      </div>
                      <a href="transactions.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>₱ <?php echo $pending_amount; ?></h3>

                        <p>Total Pending Amount <small class="text">(Total Of Amount To Be Paid)</small></p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                      </div>
                      <a href="transactions.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

            </div>
            <!--begin::Row-->


            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Monthly Recap Report</h5>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-8">
                        <p class="text-center">
                          <strong>Here are the sales report as of this Month of <?php echo date('F, Y');  ?></strong>
                        </p>
                        <div id="sales-chart"></div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-4">
                        <p class="text-center"><strong>Progression Report (ongoing..)</strong></p>
                        <?php 

                    $query_total = "SELECT COUNT(*) AS total_complete_purchase 
                    FROM order_item_table o 
                    LEFT JOIN order_table i ON o.order_id = i.order_id
                    WHERE MONTH(i.order_date) = MONTH(CURDATE()) AND YEAR(i.order_date) = YEAR(CURDATE());";
                    $result5 = mysqli_query($conn, $query_total);
                    $row5 = mysqli_fetch_assoc($result5);
                    $total_complete_purchase = $row5['total_complete_purchase'];
                    if ($total_complete_purchase != 0) {
                      // code...
                    $completed_order_percent = round(($new_orders_count/$total_complete_purchase) * 100,2);
                    }


                        ?>

                        <div class="progress-group">
                          Completed Purchase
                          <span class="float-end"><b><?php echo $new_orders_count;?></b>/<?php echo $total_complete_purchase;?></span>
                          <div class="progress progress-sm">
                            <div class="progress-bar text-bg-danger" style="width: <?php  if ($total_complete_purchase != 0) {echo $completed_order_percent;}else{ echo "0"; }?>%"></div>
                          </div>
                        </div>



                        <div class="progress-group">
                          <span class="progress-text">Partial Purchases</span>
                          <span class="float-end"><b>0</b>/0</span>
                          <div class="progress progress-sm">
                            <div class="progress-bar text-bg-success" style="width: 0%"></div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-success">
                            <i class="bi bi-caret-up-fill"></i> 0%
                          </span>
                          <h5 class="fw-bold mb-0">ongoing..</h5>
                          <span class="text-uppercase">TOTAL REVENUE</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                          <h5 class="fw-bold mb-0">ongoing..</h5>
                          <span class="text-uppercase">Top Selling Products</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-success">
                            <i class="bi bi-caret-up-fill"></i> 0%
                          </span>
                          <h5 class="fw-bold mb-0">ongoing..</h5>
                          <span class="text-uppercase">Monthly Sales Growth</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center">
                          <span class="text-primary">
                            <i class="bi bi-caret-down-fill"></i> 0%
                          </span>
                          <h5 class="fw-bold mb-0">ongoing..</h5>
                          <span class="text-uppercase">Completed orders</span>
                        </div>
                      </div>
                    </div>
                    <!--end::Row-->
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
<script>

      /* apexcharts
       * -------
       * Here we will create a few charts using apexcharts
       */

      //-----------------------
      // - MONTHLY SALES CHART -
      //-----------------------

// Fetch data from PHP
fetch('functions/monthly_report_script.php') // Replace with your actual PHP file path
  .then((response) => response.json())
  .then((data) => {
    const {categories, sales_data } = data;

    // Chart options
    const sales_chart_options = {
      series: [
        {
          name: 'Total Sales',
          data: sales_data, // Inject PHP data
        },
      ],
      chart: {
        height: 180,
        type: 'area',
        toolbar: {
          show: false,
        },
      },
      colors: ['#0d6efd'],
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'smooth',
      },
      xaxis: {
        type: 'category', // Use 'category' for string-based x-axis
        categories: categories, // Inject PHP data
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy',
        },
      },
    };

    // Render the chart
    const sales_chart = new ApexCharts(
      document.querySelector('#sales-chart'),
      sales_chart_options,
    );
    sales_chart.render();
  })
  .catch((error) => console.error('Error fetching data:', error));


      //---------------------------
      // - END MONTHLY SALES CHART -
      //---------------------------
    </script>

        </div>

    </div>

</div>


 <?php
    include 'includes/footer.php';
    ?>