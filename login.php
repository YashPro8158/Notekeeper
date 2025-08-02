 
<?php
include('db.php'); // your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Plain password input from user

    // Fetch the user from the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Check hashed password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            // redirect to dashboard or notes page
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?status=incorrectpswd");

            // echo "❌ Incorrect password.";
        }
    } else {
        header("Location: login.php?status=usernotfound");
        // echo "❌ User not found.";
    }
}
 
 ?>
 
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteKeeper | Login Form</title>
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
    
    <form class="signup-form" action="login.php" method="POST">
        <h2>NoteKeeper Login</h2>

        <?php 
                if(isset($_GET['status']) && $_GET['status']=="success"){
                    echo"<h3 style='color:green'>Login Successfully</h3>";
                }
                else  if(isset($_GET['status']) && $_GET['status']=="usernotfound"){
                    echo"<h4 style='color:red'>❌ user not Found</h4>";
                }
                else  if(isset($_GET['status']) && $_GET['status']=="incorrectpswd"){
                    echo"<h4 style='color:red'>❌ Incorrect Password </h4>";
                }

        ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>  
        
                
        <button type="submit">login Up</button>
        
        <div class="login-link">
            <p>Already have an account? <a href="signup.php">Signup here</a></p>
        </div>
    </form>
</body>
</html>