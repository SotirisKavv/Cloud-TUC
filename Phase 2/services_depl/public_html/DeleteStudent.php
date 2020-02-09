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

// Include config file
require_once "config.php";
require_once "functions.php";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes.php'; ?>
        <title>Delete Student</title>
    </head>
    <body>
        <?php include 'menu.php'; ?>
        <div id="content">
            <div class="student_list">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 23%;"><strong>ID</strong></th>
                            <th style="width: 23%;"><strong>Name</strong></th>
                            <th style="width: 23%;"><strong>Surname</strong></th>
                            <th style="width: 8%; text-align: center;"><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    // Show all student in the database
                    $get_data = callAPI('GET', $db_service.'/api/student/', $data);
                    $response = json_decode($get_data, true);

                    foreach ($response['records'] as $student){ 
                        echo "<tr>";
                            echo '<td style="width: 23%">'.$student['id'].'</td>';
                            echo '<td style="width: 23%">'.$student["name"].'</td>';
                            echo '<td style="width: 23%">'.$student["surname"].'</td>';
                            echo '<td style="width: 8%; text-align: center;"><a href="delete.php?id='.$student["id"].'"><i class="fas fa-trash"></i></a></td>';
                        echo "</tr>";                    
         
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <?php include 'footer.php'; ?> 
</html>