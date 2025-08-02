<?php 
include('db.php'); // Just includes connection

session_start();
$username = $_SESSION['username'];
if(!isset($_SESSION['username'])) {
    // exit();
}

if($_SERVER['REQUEST_METHOD']=='POST'){
$noteid = mysqli_real_escape_string($conn, $_POST['noteid']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
$notemsg = mysqli_real_escape_string($conn, $_POST['notemsg']);

$sqlquery = "SELECT * FROM `$database`.`tablenote` WHERE username = '$username' && noteid= '$noteid' AND password = '$password'";
$resultquery = mysqli_query($conn,$sqlquery);
if(mysqli_num_rows($resultquery)==1){
  $updatequery = "UPDATE `$database`.`tablenote` SET noteTitle = '$noteTitle', notemsg = '$notemsg',password = '$password' WHERE noteid = '$noteid'";
  $updatequeryresult = mysqli_query($conn, $updatequery);
  if(!$updatequeryresult){
      die("Query Failed: " . mysqli_error($conn));
  }else{
    
    echo"<h2 style='color:green;font-family:sans-serif;'>Note Updated Successfully</h2>";
  }
    
}
else {
    echo" <h2 style='color:red;font-family:sans-serif;'>Invalid note ID or password</h2>";
}
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <script src="https://kit.fontawesome.com/32eba3fa52.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9ff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }
        .form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group input:focus, .form-group textarea:focus {
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
    <h1 class="text-4xl font-bold text-gray-800 mb-3 text-center"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Note</h1>
    <?php 
    
        echo "<h2 class='text-center text-3xl font-bold text-indigo-700 mb-4'>{$username}</h2>"
    ?>

    <nav class="navbar">
                <ul>
                    <li><a href="index.php" id="create"><i class="fa-solid fa-plus mr-2"></i>Create Note</a></li>
                    <li><a href="view_notes.php"><i class="fa-solid fa-folder-open mr-2"></i>View Notes</a></li>
                    <li><a href="delete_note.php"><i class="fa-solid fa-trash mr-2"></i>Delete Note</a></li>
                    <li><a href="settings.php"><i class="fa-solid fa-gear mr-2"></i>Settings</a></li>
                </ul>
            </nav>


    <form action="edit_note.php" method="POST" class="form">
        <div class="form-group">
            <label for="noteid">Note ID:</label>
            <input type="text" id="noteid" name="noteid" required placeholder="Enter note ID" value="<?php echo htmlspecialchars($noteid); ?>">
        </div>
        <div class="form-group">
            <label for="noteTitle">Title:</label>
            <input type="text" id="noteTitle" name="noteTitle" required placeholder="Enter note title" value="<?php echo htmlspecialchars($noteTitle); ?>">
        </div>
        <div class="form-group">
            <label for="notemsg">Message:</label>
            <textarea id="notemsg" name="notemsg" rows="4" required placeholder="Enter note message"><?php echo htmlspecialchars($notemsg); ?></textarea>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter password" value="<?php echo htmlspecialchars($password); ?>">
        </div>
        <div class="form-group">
            <button type="submit">Save Note</button>
        </div>
    </form>
</div>
</body>
</html>