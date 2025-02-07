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
                    $query = "
                        SELECT 
                            COUNT(*) AS total_orders,
                            COUNT(CASE WHEN MONTH(i.order_date) = MONTH(CURDATE()) 
                                AND YEAR(i.order_date) = YEAR(CURDATE()) THEN 1 END) AS current_orders
                        FROM order_item_table o
                        INNER JOIN order_table i ON o.order_id = i.order_id
                        WHERE o.total_price = o.payment";  // Only count fully paid orders

                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_orders = $row['total_orders'];
                    $current_orders = $row['current_orders'];


                    // Query to calculate total sales for the current month where orders are fully paid
                    $query2 = "
                        SELECT SUM(o.total_price) AS total_sales 
                        FROM order_item_table o
                        LEFT JOIN order_table i ON o.order_id = i.order_id /*AND o.total_price = o.payment*/
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


                    $query3 = "
                      SELECT 
                          COUNT(*) AS pending_orders,
                          COUNT(CASE WHEN MONTH(i.order_date) = MONTH(CURDATE()) 
                              AND YEAR(i.order_date) = YEAR(CURDATE()) THEN 1 END) AS current_pending_orders
                      FROM order_item_table o
                      INNER JOIN order_table i ON o.order_id = i.order_id
                      WHERE o.total_price != o.payment
                      ";
                    $result3 = mysqli_query($conn, $query3);
                    $row3 = mysqli_fetch_assoc($result3);
                    $pendeing_orders_count = $row3['pending_orders'];
                    $current_pending_orders = $row3['current_pending_orders'];

                    $query4 = "
                    SELECT SUM(o.total_price - o.payment) AS pending_amount 
                    FROM order_item_table o
                    LEFT JOIN order_table i ON o.order_id = i.order_id
                    WHERE o.total_price != o.payment;
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
                            <h3><?php echo $current_orders; ?> </h3>
                            <h5> Orders Completed For This Month</h5><h5>A total of <b><?php echo $total_orders; ?></b> completed purchase</h5>
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
                        <h3>₱ <?php  $formatted_sales = formatNumber($new_orders_count2);
                              echo $formatted_sales; ?>
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

                        <h5>Pending Purchase For This Month</h5><h5>A total of <b><?php echo $total_orders; ?></b> pending orders</h5>
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
                        <h3>₱ <?php echo number_format($pending_amount,2); ?></h3>

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
                    LEFT JOIN order_table i ON o.order_id = i.order_id";
                    $result5 = mysqli_query($conn, $query_total);
                    $row5 = mysqli_fetch_assoc($result5);
                    $total_complete_purchase = $row5['total_complete_purchase'];
                    if ($total_complete_purchase != 0) {
                      // code...
                    $completed_order_percent = round(($total_orders/$total_complete_purchase) * 100,2);
                    }


                        ?>

                        <div class="progress-group">
                          Completed Purchase
                          <span class="float-end"><b><?php echo $total_orders;?></b>/<?php echo $total_complete_purchase;?></span>
                          <div class="progress progress-sm">
                            <div class="progress-bar text-bg-danger" style="width: <?php  if ($total_complete_purchase != 0) {echo $completed_order_percent;}else{ echo "0"; }?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

<?php
                    $monthly_query2 = "
                        SELECT 
                            SUM(CASE WHEN MONTH(i.order_date) = MONTH(CURDATE()) 
                                     AND YEAR(i.order_date) = YEAR(CURDATE()) 
                                     THEN o.total_price ELSE 0 END) AS current_month_sales,

                            SUM(CASE WHEN MONTH(i.order_date) = MONTH(CURDATE() - INTERVAL 1 MONTH) 
                                     AND YEAR(i.order_date) = YEAR(CURDATE() - INTERVAL 1 MONTH) 
                                     THEN o.total_price ELSE 0 END) AS previous_month_sales

                        FROM order_item_table o
                        LEFT JOIN order_table i ON o.order_id = i.order_id
                        ";
                    // Execute the query
                    $exec2 = mysqli_query($conn, $monthly_query2);

                    // Check for query errors
                    if ($exec2) {
                        $fetch2 = mysqli_fetch_assoc($exec2);
                        $current_sales = $fetch2['current_month_sales'] ?? 0;
                        $previous_sales = $fetch2['previous_month_sales'] ?? 0;

                            // Calculate Monthly Sales Growth %
                        if ($previous_sales > 0) {
                            $growth_percentage = (($current_sales - $previous_sales) / $previous_sales) * 100;
                            $growth_value = $current_sales - $previous_sales;
                            // $growth_percentage = 20;

                        } else {
                            $growth_percentage = ($current_sales > 0) ? 100 : 0; // If no previous sales, assume 100% growth if sales exist
                        }

                    } else {
                        // Log or display error for debugging
                        error_log("Query failed: " . mysqli_error($conn));
                        $monthly_orders_count2 = 0;
                        echo "Query failed: " . mysqli_error($conn);
                    }
?>
                  <div class="card-footer">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="text-success">
                            <i class="fas <?php echo ($growth_percentage >= 1) ? 'fa-caret-up' : 'fa-caret-down'; ?>"></i> 
                              <?php echo round($growth_percentage,2); ?> %
                          </span>
                          <h5 class="fw-bold mb-0">₱<?php echo number_format($current_sales,2);?></h5>
                          <span class="text-uppercase">TOTAL MONTHLY SALES</span>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="<?php echo ($growth_percentage >= 50) ? 'text-success' : (($growth_percentage >= 1) ? 'text-secondary' : 'text-danger'); ?>">
                              <i class="fas <?php echo ($growth_percentage >= 1) ? 'fa-caret-up' : 'fa-caret-down'; ?>"></i> 
                              <!-- <?php //echo round($growth_percentage,2); ?> % -->
                              <?php echo ($growth_percentage < 0) ? '0' : round($growth_percentage,2); ?> %
                          </span>

                          <!-- <h5 class="fw-bold mb-0">₱<?php //echo number_format($current_sales,2);?></h5> -->
                          <h5 class="fw-bold mb-0">₱<?php echo ($growth_percentage < 0) ? '0' : number_format($growth_value,2);?></h5>
                          <span class="text-uppercase">SALES GROWTH</span>
                        </div>
                      </div>
                      <!-- /.col -->

<?php
                    $monthly_query3 = "
SELECT 
    SUM(CASE 
            WHEN MONTH(i.order_date) = MONTH(CURDATE()) 
            AND YEAR(i.order_date) = YEAR(CURDATE()) 
            THEN o.total_price 
            ELSE 0 
        END) AS current_month_sales,

    SUM(CASE 
            WHEN MONTH(i.order_date) = MONTH(CURDATE() - INTERVAL 1 MONTH) 
            AND YEAR(i.order_date) = YEAR(CURDATE() - INTERVAL 1 MONTH) 
            THEN o.total_price 
            ELSE 0 
        END) AS previous_month_sales

FROM order_item_table o
LEFT JOIN order_table i ON o.order_id = i.order_id
WHERE o.total_price = o.payment;

                        ";
                    // Execute the query
                    $exec3 = mysqli_query($conn, $monthly_query3);

                    // Check for query errors
                    if ($exec3) {
                        $fetch3 = mysqli_fetch_assoc($exec3);
                        $current_revenue = $fetch3['current_month_sales'] ?? 0;
                        $previous_revenue = $fetch3['previous_month_sales'] ?? 0;

                            // Calculate Monthly Sales Growth %
                        if ($previous_sales > 0) {
                            $revenue_percentage = (($current_revenue - $previous_revenue) / $previous_revenue) * 100;
                            // $revenue_percentage = 30;

                        } else {
                            $revenue_percentage = ($current_revenue > 0) ? 100 : 0; // If no previous sales, assume 100% growth if sales exist
                        }

                    } else {
                        // Log or display error for debugging
                        error_log("Query failed: " . mysqli_error($conn));
                        $current_revenue = 0;
                        echo "Query failed: " . mysqli_error($conn);
                    }
?>

                      <div class="col-md-3 col-6">
                        <div class="text-center border-end">
                          <span class="<?php echo ($revenue_percentage >= 50) ? 'text-success' : (($revenue_percentage >= 1) ? 'text-warning' : 'text-danger'); ?>">
                              <i class="fas <?php echo ($revenue_percentage >= 1) ? 'fa-caret-up' : 'fa-caret-down'; ?>"></i> 
                              <?php echo round($revenue_percentage,2); ?>%
                          </span>

                          <h5 class="fw-bold mb-0">₱<?php echo number_format($current_revenue,2);?></h5>
                          <span class="text-uppercase">MONTHLY REVENUE</span>
                        </div>
                      </div>

<?php
                    $monthly_query4 = "
                        SELECT SUM(o.payment) AS total_revenue 
                        FROM order_item_table o
                        LEFT JOIN order_table i ON o.order_id = i.order_id";
                    // Execute the query
                    $exec4 = mysqli_query($conn, $monthly_query4);

                    // Check for query errors
                    if ($exec4) {
                        $fetch4 = mysqli_fetch_assoc($exec4);
                        $count4 = $fetch4['total_revenue'] ?? 0; // Default to 0 if no data
                    } else {
                        // Log or display error for debugging
                        error_log("Query failed: " . mysqli_error($conn));
                        $count4 = 0;
                    }
?>
                      <!-- /.col -->
                      <div class="col-md-3 col-6">
                        <div class="text-center">
                          <span class="text-primary">
                            <!-- <i class="bi bi-caret-down-fill"></i> 0% -->
                            <br>
                          </span>
                          <h5 class="fw-bold mb-0">₱<?php echo number_format($count4,2); ?></h5>
                          <span class="text-uppercase">OVERALL REVENUE</span>
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
    const { categories, sales_data } = data;

    // Convert sales data to numeric values (just for charting purposes)
    const numeric_sales_data = sales_data.map(value => {
      // Remove currency symbol and commas to convert back to numeric values
      return parseFloat(value.replace(/[₱,]/g, ''));
    });

    // Chart options
    const sales_chart_options = {
      series: [
        {
          name: 'Total Sales',
          data: numeric_sales_data, // Use numeric sales data for chart
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
        categories: categories, // Inject PHP data for months
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            // Format the Y-axis labels with commas and currency symbol
            return "₱" + value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          },
        },
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy',
        },
        y: {
          formatter: function (val) {
            return "₱" + val.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          },
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