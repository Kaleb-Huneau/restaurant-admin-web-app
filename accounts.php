<!DOCTYPE html>
<html>

<head>
    <title>Calico Cat Cafe</title>

    <!-- Link to css styles-->
    <link href="accounts.css" rel="stylesheet">
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
        <h1>This is the accounts page</h1>
        <p>Here, you can deal with the customer accounts. Use the tool below to add new customers to the database. The default amount of credit applied is $5.</p>
    </div>

    <div class="add_new">
        <h1>Add New Customer</h1>
        <form method='post'>
            <input type="text" name="email"> Email
            <br><br>
            <input type="text" name="first"> First Name
            <br><br>
            <input type="text" name="last"> Last Name
            <br><br>
            <input type="text" name="phone"> Phone Number
            <br><br>
            <input type="text" name="address"> Address
            <br><br>
            <input type="submit" name="submit"> 
        </form>
    </div>

    <?php
        // Check if form has been submitted
        if (isset($_POST['submit'])) {

            // load in the variables
            $email = $_POST['email'];
            $first = $_POST['first'];
            $last = $_POST['last'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Connect to the database
            try {
                $connection = new PDO('mysql:host=localhost;dbname=restaurantDB', "root", "");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Error!: ". $e->getMessage(). "<br/>";
                die();
            }
            // primary key is email, so check that email is not in database
            $query = $connection->query("SELECT customer_email FROM Customers WHERE customer_email = '$email'");
            $result = $query->fetch();
            if(strlen($result) == 0){
                // if the email is not in database, then insert
                $sql = "INSERT INTO Customers (customer_email, first_name, last_name, phone_number, delivery_address, credit)
                VALUES ('$email', '$first', '$last', '$phone', '$address', '5')";
                $result = $connection->query($sql);
                if ($result) {
                    echo "New record created successfully";
                } else {
                    echo "Error while trying to insert record";
                }
            } else{
                echo "Error: Customer with that email already exists";
            } 
            $connection->close();
        }
        ?>
</body>
</html>