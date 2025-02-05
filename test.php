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




            ?>