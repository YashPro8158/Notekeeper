<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash the password

    $checkUser = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        header("Location: signup.php?status=error");
    } else {
        $insertUser = "INSERT INTO users (`username`,`email`, `password`) VALUES ('$username','$email', '$password')";
        if (mysqli_query($conn, $insertUser)) {
            // echo "Sign-up successful. You can now <a href='login.php'>login</a
            header("Location: signup.php?status=success");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

 
 
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 16px;
        }
        .signup-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            font-size: 18px;
        }
        .signup-form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #4f46e5;
            font-size: 24px;
        }
        .signup-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #4f46e5;
            font-size: 16px;
        }
        .signup-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
            font-size: 16px;
        }
        .signup-form input:focus {
            border-color: #4f46e5;
            outline: none;
        }
        .signup-form button {
            width: 100%;
            padding: 12px;
            background-color: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        .signup-form button:hover {
            background-color: #3c3abf;
        }
        .signup-form .login-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .signup-form .login-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: bold;
        }   
        .signup-form .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <form class="signup-form" action="signup.php" method="POST">
        <h2>NoteKeeper Signup</h2>

        <?php 
                if(isset($_GET['status']) && $_GET['status']=="success"){
                    echo"<h3 style='color:green'>Signup Successfully</h3>";
                }
                else  if(isset($_GET['status']) && $_GET['status']=="error"){
                    echo"<h3 style='color:red'>Email Already Exist Try different pls</h3>";
                }


        ?>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>  
        
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required>
        
        <button type="submit">Sign Up</button>
        
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>
</body>
</html>