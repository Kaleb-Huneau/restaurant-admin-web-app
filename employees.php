<!DOCTYPE html>
<html>

<head>
    <title>Calico Cat Cafe</title>

    <!-- Link to css styles-->
    <link href="employees.css" rel="stylesheet">
</head>

<body>
    <!-- Connecting to database -->

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

    <div class="description">
        <h1>This is the employee page</h1>
        <p>Here, you can select an employee and view their schedule using the form below</p>
    </div>

    <div class="check">
        <h1>Check Employee Schedule</h1>
        <select name="Employee" form="emp">
            <!-- Need to run some php in the form to get a list of the employees -->
            <?php
                // Connect to the database
                try {
                    $connection = new PDO('mysql:host=localhost;dbname=restaurantDB', "root", "");
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    print "Error!: ". $e->getMessage(). "<br/>";
                    die();
                }
                // Query the database for employee names
                $query = "SELECT employee_name FROM Employees";
                $result = $connection->query($query);

                // Loop through the result set and create an option for each employee
                while ($row = $result->fetch()) {
                    $name = $row['employee_name'];
                    echo "<option value=\"$name\">$name</option>";
                }
            ?>
        </select>
        <form method="post" id="emp">
            <input type="submit" name="submit">
        </form>
    </div class="schedule">
        <table>
        <thead>
            <tr>
            <th>Day of Week &nbsp&nbsp</th>
            <th>Start Time &nbsp&nbsp </th>
            <th>End Time </th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Check if form has been submitted
            if (isset($_POST['submit'])) {

                // load in the variables
                $employee = $_POST['Employee'];
                
                // Connection should already be open, so no need to reopen here

                // Create query to get the employee's schedule
                $query = ("SELECT * FROM Schedules s WHERE s.employee_id = (SELECT e.employee_id FROM Employees e WHERE e.employee_name = '$employee') AND s.day_of_week != 'Saturday' AND s.day_of_week != 'Sunday'");
                $result = $connection->query($query);
                
                // print all of the scheduled shifts to screen
                while ($row=$result->fetch()) {
                    echo "<tr>";
                    echo "<td>".$row["day_of_week"]."</td>";
                    echo "<td>".$row["start_time"]."</td>";
                    echo "<td>".$row["end_time"]."</td>";
                    echo "</tr>";
                }
                    
                
                $connection->close();
            }
        ?>
        </tbody>
        </table>
    </div>
</body>
</html>