<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// //The htmlspecialchars() function converts special characters to HTML entities. This means that it will replace HTML characters like < and > with &lt; and &gt;. This prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms.
// $firstname = htmlspecialchars($_SESSION["firstname"]); //
// $surname = htmlspecialchars($_SESSION["surname"]);
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include 'menu.php'; ?>
</body>
</html>