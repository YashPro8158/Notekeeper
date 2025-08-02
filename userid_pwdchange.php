<?php 

session_start();
$username = $_SESSION['username'];
if(!isset($_SESSION['username'])) {
    // exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include ("db.php");

$password= $_POST['password'];
$updatepassword = password_hash($_POST['updatepassword'], PASSWORD_DEFAULT); // hash the password


$sqluser = "SELECT * FROM users WHERE username = '$username'";
$resultuser = mysqli_query($conn,$sqluser);

if ($resultuser && mysqli_num_rows($resultuser) === 1) {
    $user = mysqli_fetch_assoc($resultuser);
    
    if (password_verify($password, $user['password'])) {
    //     $sqlpswdupdate = "UPDATE `users` SET password = '$updatepassword' WHERE email = '$email'";
    //     $resultpswdupdate = mysqli_query($conn, $sqlpswdupdate);

    //     if(mysqli_num_rows($resultpswdupdate)===1){}{
    //     header("Location: userid_pwdchange.php?status=success");
    // }
echo "user found";

    } else {
        header("Location: userid_pwdchange.php?status=incorrectpswd");

    }
} else {
    header("Location: userid_pwdchange.php?status=usernotfound");
}

}

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Note</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/32eba3fa52.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="style.css">
    <style>
       
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }
        .settingbox{
            width:100%;
            text-align:center;
        }
        .settingbox a{
    padding: 0.75rem 1.25rem;
    background-color: #4f46e5;
    color: white;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
    cursor: pointer;
        }
.changepswdform{
    display:none;
    width:70%;
    height:auto;
    border:1px solid #4f46e5;
    margin:40px auto;
    padding:40px 20px;
    border-radius:20px;

}
        .form-group {
            margin-bottom: 20px;
        }
        label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #4b5563;
}
        .form-group input{
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group input:focus{
            border-color: #6366f1;
            outline: none;
        }
        .form-group button {
            background-color: #6366f1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #4f46e5;
        }
    </style>


</head>
<body>
<div class="container">
<h1 class="text-4xl font-bold text-gray-800 mb-3 text-center"><i class="fa-solid fa-gear mr-2"></i>Account password Update</h1>

<?php 
    
    
        echo "<h2 class='text-center text-3xl font-bold text-indigo-700 mb-4'>{$username}</h2>"
?>
<nav class="navbar">
                <ul>
                    <li><a href="index.php" id="create"><i class="fa-solid fa-plus mr-2"></i>Create Note</a></li>
                    <li><a href="view_notes.php"><i class="fa-solid fa-folder-open mr-2"></i>View Notes</a></li>
                    <li><a href="edit_note.php"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Note</a></li>
                    <li><a href="delete_note.php"><i class="fa-solid fa-trash mr-2"></i>Delete Note</a></li>
                </ul>
            </nav>
            <?php 
             if(isset($_GET['status']) && $_GET['status']=="success"){
                echo "<h3 style='color:green'>Account password Update Successfully</h3>";
            }
            else if(isset($_GET['status']) && $_GET['status']=="incorrectpswd"){
                echo "<h3 style='color:red'>InCorrect Password</h3>";
            }
                        else if(isset($_GET['status']) && $_GET['status']=="usernotfound"){
                            echo "<h3 style='color:red'>User not Found</h3>";
                        }
            ?>
            
</div>

<div class="settingbox">

<div class="acchangepswdform" id ="acchangepswdform">
    <form action="userid_pwdchange.php" method="POST">
    <div class="form-group">
            
                    
                        <div id="inputpswdbox">
                            <label for="password">Enter password:</label>
                            <input type="password" id="password" name="password" autocomplete="off" placeholder="Enter password">
                        </div>

                        <div id="inputpswdbox">
                            <label for="updatepassword">update password:</label>
                            <input type="password" id="updatepassword" name="updatepassword" autocomplete="off" placeholder="Update password">
                        </div>
                </div>
                
                <div class="text-center">
                    <input type="submit" value="Update password" class="btn btn-primary" >
                </div>
    </form>
</div>

</div>
    </div>



 
</body>
</html>