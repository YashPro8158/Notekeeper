<?php
        include('db.php');
        session_start();
        $username = $_SESSION['username'];
        if(!isset($_SESSION['username'])) {
            // exit();
        }

        $query = "SELECT * FROM tablenote WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $notecount = 0;
        
        // Array of border colors to cycle through
        $borderColors = ['border-indigo-500', 'border-purple-500', 'border-blue-500', 'border-pink-500', 'border-teal-500'];
        
        echo "  <h1 class='text-4xl font-bold text-gray-800 mb-3 text-center m-10'><i class='fa-solid fa-folder-open mr-2'></i>My Notes</h1>";
   
         
        echo "<h2 class='text-center text-3xl font-bold text-indigo-700 mb-4'>{$username}</h2>"
               
        ?>
        

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/32eba3fa52.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="navbar.css">
    <style>
          .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
            
        }
        .note {
            margin-bottom: 20px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .note:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .note-number {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="mt-10 container">
         
<nav class="navbar">
                <ul>
                    <li><a href="index.php" id="create"><i class="fa-solid fa-plus mr-2"></i>Create Note</a></li>
                    <li><a href="edit_note.php"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Note</a></li>
                    <li><a href="delete_note.php"><i class="fa-solid fa-trash mr-2"></i>Delete Note</a></li>
                    <li><a href="settings.php"><i class="fa-solid fa-gear mr-2"></i>Settings</a></li>
                </ul>
            </nav>

<?php 
       
while ($row = mysqli_fetch_assoc($result)) {
    

    if($row>0){
      $notecount++;
      $noteid = htmlspecialchars($row['noteid']);
      $noteTitle = htmlspecialchars($row['noteTitle']);
      $notemsg = htmlspecialchars($row['notemsg']);
      $borderColor = $borderColors[($notecount - 1) % count($borderColors)];
      echo "<div class='note bg-white rounded-xl p-6 shadow-md border-l-4 {$borderColor}'>";
      echo "<div class='flex items-center mb-4'>";
      echo "<div class='note-number mr-4'>{$notecount}</div>";
      echo "<h3 class='text-xl font-semibold text-gray-800'>Note-id:  $noteid <br>Note-Title:  {$noteTitle} <br>Note-Msg:{$notemsg} </h3>";
      echo "</div>";
      echo "</div>";
    }
    else {
      echo "<p class='text-gray-500'>No notes found.</p>";
    }
  }
  echo "  <h1 class='text-4xl font-bold text-gray-800 mb-3 text-center m-10'>Total {$notecount} Notes Created</h1>";



?>
            <a href="index.php" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition-opacity shadow-lg">
                Add New Note
    </a>
        </div>

<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9683c5fa1320549c',t:'MTc1NDAzNDkyOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
