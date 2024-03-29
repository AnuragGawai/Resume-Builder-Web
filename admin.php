<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to adminlog.php
    session_destroy();
    header("Location: adminlog.php");
    exit();
}
?>

<?php
   

    if (isset($_POST['clear_data'])) {
        // Reload the page to clear the data
        header("Refresh:0");
    } ?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* .navbar {
            background-color: #333;
            padding: 20px;
            text-align: left;
        }

        .navbar a {
            color: #ff6f00;
            text-decoration: none;
            margin: 0 20px;
            font-size: 20px;
        }

        .navbar button {
            background-color: #ff6f00;
            color: #333;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            margin-left: auto;
        }

        button:hover {
            background-color: #ffa733;
        } */

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navigation ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navigation ul li {
            display: inline-block;
            margin-right: 20px;
        }

        .navigation ul li:last-child {
            margin-right: 0;
        }

        .navigation ul li a {
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }

        .navigation ul li a:hover {
            color: #ff6f00;
        }

        .navigation ul li button {
            background-color: #ff6f00;
            color: #333;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            margin-left: auto;
        }

        button:hover {
            background-color: #ffa733;
        }

        h1 {
            text-align: center;
        }

        /* input[type="submit"] , input[type="button"] {
            background-color: #ff6f00;
            color: #333;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            margin-left: auto;
        } */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: black;
            color: white
        }

        ;

        .content {
            width:100%
            display: flex;
            justify-content: center;
            margin: 20px;
            max-width: 1200px;
        }

        .content form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* max-width: 600px; Adjust the max-width as needed */
            width: 100%;
        }

        .content form input[type="submit"],
        form input[type="button"] {
            background-color: #ff6f00;
            color: #333;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
        }
        

        .hidden {
            display: none;
        }

        .inp_delete
         {
    /* padding: 10px; */
    width:200px;
    height:30px;
    margin-right: 10px;
    font-size: 16px;
    border: 1px solid #666; 
    border-radius: 5px;
    background-color: #444; 
    color: #fff; 
} 

.user{
    display: flex;
    /* flex-direction:column; */
            justify-content: center;
            align-item:center;
            background-color:red;
}
    </style>
</head>

<body>
    <!-- <div class="navbar">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        <form action="" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div> -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="images/logo.pn" alt="Resume Builder Logo">
                <!-- <h3>SELECTED.COM</h4> -->

            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#">Templates</a></li>
                    <li><a href="#about">About</a></li>
                    <li>
                        <form action="" method="post">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>


    <h1>Welcome to Admin Dashboard </h1>

    <!-- Content of the page -->
    <div class="content">
        <form method="post">
            <input type="submit" name="fetch_users" value="Fetch All Users">
            <input type="submit" name="fetch_admin" value="Fetch All Admins">
            <input type="submit" name="clear_data" value="Clear Data">
        </form>
    </div>
    <br>
    <div class="user">
        <form id="deleteUserForm" class="deleteUserForm">
            <input type="button" name="delete_user" value="Delete User" id="showButton"><br><br>
            <div id="inputBoxContainer" class="hidden">
                <input type="text" id="inputBox" name="email" class="inp_delete">
                <!-- <button type="submit" id="submitButton" name="delete">Submit</button> -->
                <input type="button" id="submitButton" name="delete" value="Delete">
            </div>
        </form>
    </div>

<?php
   if(isset($_POST['delete'])){

    $connection =new mysqli("localhost", "root", "", "resume_builder");
    if($connection)
    {
        $email=$_POST['email'];
       
      
        $sql="DELETE FROM `login` WHERE Email= '$email'";
        $result=mysqli_query($connection,$sql);
       if($result){
        echo '<script>alert("User Deleted Successfully ")</script>';
       }
       else{
        echo '<script>alert("Failed To Delete User")</script>';
       }

      }
      
      else{
        // echo "Connection Failed With Database, Please Cheack Your Database Connection";
        echo '<script>alert("Connection Failed With Database, Please Cheack Your Database Connection")</script>';
    }
    }
   


?>

    <script>
        // Get references to the button and container
        const showButton = document.getElementById('showButton');
        const inputBoxContainer = document.getElementById('inputBoxContainer');
        const deleteForm = document.getElementById('deleteUserForm');

        // Function to toggle visibility of input box and button
        function toggleInputBox() {
            inputBoxContainer.classList.toggle('hidden');
        }

        // Attach event listener to the showButton
        showButton.addEventListener('click', toggleInputBox);

        // Function to handle form submission
        function submitForm(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // You can add your code to handle form submission here
            // For example, you can use AJAX to send a request to the server without reloading the page

            // For demonstration purposes, let's log a message
            console.log('Form submitted asynchronously');
        }

        // Attach event listener to the form submission
        deleteForm.addEventListener('submit', submitForm);
    </script>
</body>

</html>
<?php
if (isset($_POST['fetch_users'])) {
    // $conn = mysqli_connect("localhost", "username", "password", "resume_builder");
    $conn =new mysqli("localhost", "root", "", "resume_builder");

    if (!$conn) {
        echo '<script>alert("Connection failed: ' . mysqli_connect_error() . '")</script>';
    } else {
        $sql = "SELECT * FROM login";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>User ID</th><th>Email</th><th>Password</th><th>Confirm Password</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["Password"] . "</td>";
                echo "<td>" . $row["Confirm_Password"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
    }
}
?>

<?php
if (isset($_POST['fetch_admin'])) {
    $conn = new mysqli("localhost", "root", "", "resume_builder");

    if (!$conn) {
        echo '<script>alert("Connection failed: ' . mysqli_connect_error() . '")</script>';
    } else {
        // $sql = "SELECT `user_id`,`email`, `password`, `c_password` FROM `admin_login`";
        $sql = "SELECT * FROM `admin_login`";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Admin ID</th><th>Email</th><th>Password</th><th>Confirm Password</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["admin_id"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["c_password"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
    }
}
?>