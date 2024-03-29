
<?php
if(isset($_POST['login'])){

    $connection =new mysqli("localhost", "root", "", "resume_builder");
    if($connection){
        $email=$_POST['username'];
        $password=$_POST['password'];
        $sql="SELECT * FROM `login` WHERE Email='$email'";
        $result=mysqli_query($connection,$sql);
        if($row=mysqli_fetch_assoc($result)){
            if($password==$row['Password']){
                 echo '<script>alert("Login Successfully")</script>';
                 header("location: information1.php");
                 exit();
                 
            }
            else{
                // echo'Invalid Password'; 
                 echo '<script>alert("Invalid Password, Please Cheack The Password")</script>';
            }
        }
        else{
            // echo'Invalid Email';
            echo '<script>alert("Invalid Username, Please Cheack The Username")</script>';


        }

    }
    else{
        // echo "Connection Failed With Database, Please Cheack Your Database Connection";
        echo '<script>alert("Connection Failed With Database, Please Cheack Your Database Connection")</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <title>Signin and Signup</title>
    <style>
        /* Reset default styles and set the font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Remove underlines from links */
        a {
            text-decoration: none;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #222;
        }

        .main-container {
            width: 700px;
            /* background-color: rgb(255, 0, 0); */
            box-shadow: 10px 20px 20px 0 rgba(0, 0, 0, 0.4), -10px 20px 20px 0 rgba(0, 0, 0, 0.4), 0 -2px 20px 0 rgba(0, 0, 0, 0.5);
            border: 2px solid #ffffff;
            border-radius: 3%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow: hidden;
        }

        .main-container .ex-img {
            width: 350px;
            height: 500px;
            /* background-color: rgb(72, 0, 255); */
        }

        .main-container .ex-img img {
            height: 100%;
            width: 100%;

        }

        .container {
            width: 350px;
            height: 500px;

            background: #333;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Style the grid layout containing forms */
        .signin-signup {
            display: grid;
            grid-template-columns: 1fr;
        }

        /* Style the forms and hide the sign-up form initially */
        form {
            grid-column: 1 / 2;
            grid-row: 1/2;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        form.sign-up-form {
            visibility: hidden;
        }

        /* Style form titles, input fields, icons, and buttons */
        .title {
            font-size: 35px;
            color: #ff6f00;
            margin-bottom: 10px;
        }

        .input-field {
            width: 280px;
            height: 50px;
            border-bottom: 2px solid #ffffff;
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .input-field i {
            flex: 1;
            text-align: center;
            font-size: 20px;
            color: #ffffff;
        }

        .input-field input {
            flex: 5;
            border: none;
            outline: none;
            background: none;
            font-size: 18px;
            color: #f0f0f0;
            font-weight: 600;
        }

        /* Style paragraphs and links */
        p,
        a {
            font-size: 14px;
            color: #999;
        }

        .forgot-password {
            align-self: flex-end;
        }

        .btn {
            width: 130px;
            height: 40px;
            /* background: none; */
            outline: none;
            border: none;
            background: #ff6f00;

            /* border: 2px solid #ffffff; */
            border-radius: 5%;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: 600;
            margin: 20px 0;
            color: #ffffff;
        }

        .btn:hover {
            color: #ffffff;
            border: none;
            background: #cb5800;
        }

        .account-text {
            color: #f0f0f0;
        }

        /* Make the sign-up form visible when in sign-up mode */
        .container.sign-up-mode form.sign-up-form {
            visibility: visible;
        }

        /* Hide the sign-in form when in sign-up mode */
        .container.sign-up-mode form.sign-in-form {
            visibility: hidden;
        }

        /* Adjust container styles for smaller screens */
        @media (max-width: 400px) {
            .container {
                width: 100vw;
                height: 100vh;
            }
        }
    </style>

</head>

<body>
    
        <div class="main-container">
            <div class="ex-img">
                <img src="images/L_img3.jpg" alt="image">
            </div>
            <div class="container">
                <div class="signin-signup">
                    <!-- Login Form -->
                    <form action="" class="sign-in-form" method="post">
                        <h2 class="title">Login</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Username" name="username">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                        <a href="#" class="forgot-password">Forgot password?</a>
                        <input type="submit" value="Login" class="btn" name="login">
                        <p>Don't have an account? <a href="#" class="account-text" id="sign-up-link">Sign up</a></p>
                    </form>
                    <!-- Sign-up Form -->
                    <form action="" class="sign-up-form" method="post">
                        <h2 class="title">Sign up</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Username/Email" name="email" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="pass" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Confirm Password" name="cpass" required>
                        </div>
                        <input type="submit" value="Sign up" class="btn" name="register">
                        <p>Already have an account? <a href="#" class="account-text" id="sign-in-link">Login</a></p>
                    </form>
                </div>
            </div>

        </div>
 
    <!-- <script src="app.js"></script> -->
    <script>
        const sign_in_link = document.querySelector("#sign-in-link");
        const sign_up_link = document.querySelector("#sign-up-link");
        const container = document.querySelector(".container");
        sign_up_link.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        })
        sign_in_link.addEventListener("click", () => {
            // container.classList.remove("sign-up-mode");
            container.classList.add("sign-up-mode");
        })
    </script>
</body>

</html>
<!-- code for login page -->



<!-- code for register page -->
<?php
if(isset($_POST['register'])){

    $connection =new mysqli("localhost", "root", "", "resume_builder");
    if($connection)
    {
        $email=$_POST['email'];
        $password=$_POST['pass'];
        $cpassword=$_POST['cpass'];
      if($password===$cpassword){
        $sql="INSERT INTO `login`(`Email`, `Password`, `Confirm_Password`) VALUES ('$email','$password','$cpassword')";
        $result=mysqli_query($connection,$sql);
       if($result){
        echo '<script>alert("Registration Successfully")</script>';
       }
       else{
        echo '<script>alert("Failed To Register")</script>';
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