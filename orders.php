<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link rel="stylesheet" href='orders.css' type="text/css">
</head>

<body>
    <!-- connect restaurant db -->
    <?php
        include "connectrestaurant.php";
    ?>
    <!-- Nav Bar (put on every html page) -->
    <ul>
        <li><a href="restaurant.php">Home</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="accounts.php">Customers</a></li>
        <li><a href="employees.php">Employees</a></li>
        <li>
            <h1>Calico Cat Cafe</h1>
        </li>
    </ul>
    <p>Please enter a date in the form below in order to retreive information about orders on that date</p>

    <form method="post">
            Enter a date as date-time:
            <input type="date" name="time_placed">
            <br>
            <input type="submit" name="submit">
    </form>

    <?php
        // Check if form has been submitted
        if (isset($_POST['submit'])) {

            // Get the minimum and maximum prices entered by the user
            $time_placed = $_POST['time_placed'];

            // Connect to the database
            try {
                $connection = new PDO('mysql:host=localhost;dbname=restaurantDB', "root", "");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Error!: ". $e->getMessage(). "<br/>";
                die();
            }

            // Prepare and execute the query

            $order_sql = "SELECT customers.first_name, customers.last_name, order_items.food_name, orders.order_price, orders.tip, employee.employee_name
            FROM orders
            INNER JOIN customers ON orders.customer_email = customers.customer_email
            INNER JOIN employees ON orders.employee_id = employee.employee_id
            WHERE orders.order_placement_date = '$date'";

            //$result = $connection->query($order_sql);

            echo "<h2>Orders placed at $time_placed :</h2>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Order Items</th><th>Price</th><th>Tip</th><th>Driver</th></tr>";
            echo "<tr>";
            /*
            while ($row=$result->fetch()) {
                echo "<tr>";
                echo "<td>".$row["first_name"]."</td>";
                echo "<td>".$row["last_name"]."</td>";
                echo "<td>".$row["food_name"]."</td>";
                echo "<td>".$row["order_price"]."</td>";
                echo "<td>".$row["tip"]."</td>";
                echo "<td>".$row["employee_name"]."</td>";
                echo "</tr>";
            }
            */
            echo "<td>first1</td>";
            echo "<td>last1</td>";
            echo "<td>30cm Pizza (2 Topping)</td>";
            echo "<td>22.99</td>";
            echo "<td>0.99</td>";
            echo "<td>Employee1</td>";
            //            echo "<td>" . $row['employee_name'] . "</td>";
            echo "</tr>";
            echo "</table>";
            } 
        ?>
        <br><br>
        <hr>
        <br>
        <h1>Dates on Which Orders Were Placed</h1>
        <?php
            //connect to db
            try {
                $connection = new PDO('mysql:host=localhost;dbname=restaurantDB', "root", "");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Error!: ". $e->getMessage(). "<br/>";
                die();
            }

            //get sql statement to collect info
            $sql = "SELECT order_placement_date, COUNT(*) FROM orders
            GROUP BY DATE(order_placement_date)";
            $result = $connection->query($sql);

            echo "<h2>Orders Grouped by Date</h2>";
            echo "<table>";
            echo "<tr><th>Date</th><th>&nbsp&nbsp&nbsp&nbspNumber of Orders</th></tr>";
            while ($row=$result->fetch()) {
                echo "<tr>";
                echo "<td>".$row["order_placement_date"]."</td>";
                echo "<td>&nbsp&nbsp&nbsp&nbsp".$row[1]."</td>";
                echo "</tr>";
            }
            //            echo "<td>" . $row['employee_name'] . "</td>";
            echo "</tr>";
            echo "</table>";
            
            // Close the connection
            $connection->close();
        ?>
</body>

</html>
