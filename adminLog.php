<?php
if(isset($_POST['login'])){
    // Only execute this block if the login form is submitted
    $connection = new mysqli("localhost", "root", "", "resume_builder");
    if($connection){
        $email=$_POST['username'];
        $password=$_POST['password'];
        $sql="SELECT * FROM `admin_login` WHERE email='$email'";
        $result=mysqli_query($connection,$sql);
        if($row=mysqli_fetch_assoc($result)){
            if($password==$row['password']){
                // echo '<script>alert(" Admin Login Successfully")</script>';
                header("location: admin.php");
                exit();
                 
            }
            else{
                echo '<script>alert("Invalid Password Of Admin, Please Check The Password")</script>';
            }
        }
        else{
            echo '<script>alert("Invalid Username Of Admin, Please Check The Username")</script>';
        }
    }
    else{
        echo '<script>alert("Connection Failed With Database, Please Check Your Database Connection")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login/Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
    background-color: #121212; /* Dark background color */
    color: #fff; /* Text color */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.form-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    background-color: #333; /* Darker background for the form */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #ff6f00; /* Accent color for headings */
}

input[type="text"],
input[type="password"],
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #666; /* Darker border for inputs */
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #444; /* Darker background for inputs */
    color: #fff; /* Text color */
}

input[type="submit"] {
    background-color: #ff6f00; /* Accent color for submit button */
    color: #fff; /* Text color */
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #ff9632; /* Darker accent color on hover */
}

a {
    color: #ff6f00; /* Accent color for links */
}

a:hover {
    color: #ff9632; /* Darker accent color on hover */
}

    </style>
</head>
<body>
    <div class="form-container">
        
        <!-- Login Form -->
        <form id="loginForm" action="" method="post">
            <h2>Admin Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name="login">
        </form>
        <!-- Register Form -->
        <form id="registerForm" action="" method="post" style="display: none;">
            <h2>Admin Register</h2>
            <input type="text" name="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="password" name="cpassword" placeholder=" Re-enter Password" required>
            <input type="submit" value="Register" name="register">
        </form>
        <!-- Toggle between login and register forms -->
        <p>Don't have an account? <a href="#" id="toggleForm">Register</a></p>
    </div>

    <script>
        document.getElementById("toggleForm").addEventListener("click", function(event) {
            event.preventDefault();
            var loginForm = document.getElementById("loginForm");
            var registerForm = document.getElementById("registerForm");
            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
            }
        });

        document.getElementById("loginForm").addEventListener("submit", function(event) {
            var password = document.getElementById("loginPassword").value;
            if (password.length < 6 || password.length > 10) {
                alert("Password must be between 6 and 10 characters");
                event.preventDefault();
            }
        });

        document.getElementById("registerForm").addEventListener("submit", function(event) {
            var password = document.getElementById("registerPassword").value;
            if (password.length < 6 || password.length > 10) {
                alert("Password must be between 6 and 10 characters");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>

<?php
if(isset($_POST['register'])){

    $connection =new mysqli("localhost", "root", "", "resume_builder");
    if($connection)
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
      if($password===$cpassword){
        $sql="INSERT INTO `admin_login`(`email`, `password`, `c_password`) VALUES ('$email','$password','$cpassword')";
        $result=mysqli_query($connection,$sql);
       if($result){
        echo '<script>alert("Admin Registration Successfully ")</script>';
       }
       else{
        echo '<script>alert("Failed To Register The Admin")</script>';
       }

      }
      else{
        echo '<script>alert("Please Check password and confirm Password")</script>';
      }
    }
    else{
        // echo "Connection Failed With Database, Please Cheack Your Database Connection";
        echo '<script>alert("Connection Failed With Database, Please Cheack Your Database Connection")</script>';
    }
}

?>