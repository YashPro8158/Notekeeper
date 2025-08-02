
<?php 
session_start();
$username = $_SESSION['username'];
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php'); // connection

    $noteid = mysqli_real_escape_string($conn, $_POST['noteid']);
    $noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
    $notemsg = mysqli_real_escape_string($conn, $_POST['notemsg']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($conn) {
        if (!empty($noteid) && !empty($noteTitle) && !empty($notemsg)) {
            if (!empty($password)) {
                // If exist, then 
                $sqlexistquery = "SELECT * FROM `tablenote` WHERE noteid = '$noteid'";
                $resultexist  = mysqli_query($conn, $sqlexistquery);

                if (mysqli_num_rows($resultexist) > 0) {
                    header("Location: index.php?status=exist");
                    exit();
                }

                // If not exist, then insert
                $database = 'your_database_name'; // Replace 'your_database_name' with the actual database name
                $sqlquerinsert = "INSERT INTO `tablenote` (`noteid`, `noteTitle`, `notemsg`, `password`,`username`) VALUES ('$noteid', '$noteTitle', '$notemsg', '$password','$username')";
                $insertqueryresult = mysqli_query($conn, $sqlquerinsert);

                if ($insertqueryresult) {
                    header("Location: index.php?status=success");
                    
                } else {
                    header("Location: index.php?status=error");
                    
                    
                }
                exit();
            } else {
                header("Location: index.php?status=missing_password");
                exit();
            }
        } else {
            header("Location: index.php?status=error");
            exit();
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Notes Web App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/32eba3fa52.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="navbar.css">
    
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="text-center text-3xl font-bold text-indigo-700 mb-4">Personal Notes Web App</h1>
            <?php 
            
            echo "<h1 class='text-center text-3xl font-bold text-indigo-700 mb-4'>Welcome {$username}</h1>"
            ?>
            <p class="text-center text-gray-600 mb-2">Welcome to your personal notes web application! Here you can create, edit, and manage your notes.</p>
            <p class="text-center text-gray-600 mb-6">Use the navigation menu to access different features of the app.</p>
            
            <nav class="navbar">
                <ul>
                    <li><a href="index.php" id="create"><i class="fa-solid fa-plus mr-2"></i>Create Note</a></li>
                    <li><a href="view_notes.php"><i class="fa-solid fa-folder-open mr-2"></i>View Notes</a></li>
                    <li><a href="edit_note.php"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Note</a></li>
                    <li><a href="delete_note.php"><i class="fa-solid fa-trash mr-2"></i>Delete Note</a></li>
                    <li><a href="settings.php"><i class="fa-solid fa-gear mr-2"></i>Settings</a></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
                </ul>
            </nav>
        </div>

        <div id="create" class="card">
            <h2 class="text-center text-2xl font-semibold text-indigo-700 mb-6">Create a New Note</h2>
            
            <?php
            if(isset($_GET['status']) && $_GET['status']=="success"){
                echo "<p class='text-green-700 bg-green-100 p-3 rounded-lg mb-4 text-center'>Note created successfully!</p>";
            } elseif(isset($_GET['status']) && $_GET['status']=="error"){
                echo "<p class='text-red-700 bg-red-100 p-3 rounded-lg mb-4 text-center'>Please fill in all fields.</p>";
            } elseif(isset($_GET['status']) && $_GET['status']=="missing_password"){
                echo "<p class='text-red-700 bg-red-100 p-3 rounded-lg mb-4 text-center'>Password required.</p>";
            }elseif(isset($_GET['status']) && $_GET['status']=="exist"){
                echo "<p class='text-red-700 bg-red-100 p-3 rounded-lg mb-4 text-center'>Note id is already exist pls try different.</p>";
            }
            ?>
            
            <form id="noteForm" action="index.php" method="POST" class="form" autocomplete="off">
                <div class="form-group">
                <label for="noteTitle">Note Id:</label>
                <input type="text" id="noteid" name="noteid" required autocomplete="off" placeholder="Enter note title">
                    <label for="noteTitle">Title:</label>
                    <input type="text" id="noteTitle" name="noteTitle" required autocomplete="off" placeholder="Enter note title">
                    
                    <label for="notemsg">Your note:</label>
                    <textarea name="notemsg" id="notemsg" rows="8" autocomplete="off" required placeholder="Write your note here..."></textarea>
                    
                  
                    
                    <div class="passwordbox" id="passwordbox">
                        <p id="submitsuccess" class="text-green-700"></p>
                        <div id="inputpswdbox">
                            <label for="password">Enter password to protect your note:</label>
                            <input type="password" id="password" name="password" autocomplete="off" placeholder="Enter password">
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <input type="submit" value="Create Note" class="btn btn-primary">
                </div>
            </form>
            
            <div id="message" class="text-center mt-4"></div>
        </div>
        
        <footer>
            <p>&copy; 2023 Personal Notes Web App. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('checkbox');
            const passwordBox = document.getElementById('passwordbox');
            const viewPswd = document.getElementById('viewpswd');
            const passwordField = document.getElementById('password');
            const enablePassword = document.getElementById('enablepassword');
            const disablePassword = document.getElementById('disablepassword');
            const submitSuccess = document.getElementById('submitsuccess');
            
            // Toggle password box visibility
            checkbox.addEventListener('change', function() {
                passwordBox.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    passwordField.value = '';
                    submitSuccess.textContent = '';
                }
            });
            
            // Toggle password visibility
            viewPswd.addEventListener('click', function(e) {
                e.preventDefault();
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    viewPswd.classList.remove('fa-eye-slash');
                    viewPswd.classList.add('fa-eye');
                } else {
                    passwordField.type = 'password';
                    viewPswd.classList.remove('fa-eye');
                    viewPswd.classList.add('fa-eye-slash');
                }
            });
            
            // Enable password
            enablePassword.addEventListener('click', function() {
                if (passwordField.value.trim() !== '') {
                    submitSuccess.textContent = 'Password set successfully!';
                    submitSuccess.classList.remove('text-red-700');
                    submitSuccess.classList.add('text-green-700');
                } else {
                    submitSuccess.textContent = 'Please enter a password.';
                    submitSuccess.classList.remove('text-green-700');
                    submitSuccess.classList.add('text-red-700');
                }
            });
            
            // Disable password
            disablePassword.addEventListener('click', function() {
                checkbox.checked = false;
                passwordBox.style.display = 'none';
                passwordField.value = '';
                submitSuccess.textContent = '';
            });
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9683e93d040559c3',t:'MTc1NDAzNjM3Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
