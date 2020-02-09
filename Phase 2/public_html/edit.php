<?php

// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

 // define variables and set to empty values
$message = "";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once "config.php";
require_once "functions.php";

//get the argument
$id=$_REQUEST['id'];

//find the rest of the information
$get_data = callAPI('GET', $db_service.'/api/student/'.$id, $data);
$response = json_decode($get_data, true);

$name = $response['name'];
$surname = $response['surname'];
$fathername =  $response['fathername'];
$grade = $response['grade'];
$mobile_number = $response['mobilenumber'];
$birthday = $response['birthday'];


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Check data for special characters
    $id = secure_input($_POST["id"]);
    $name = secure_input($_POST["name"]);
    $surname = secure_input($_POST["surname"]);
    $fathername = secure_input($_POST["fathername"]);
    $grade = (real)$_POST["grade"];
    $mobile_number = secure_input($_POST["mobile_number"]);
    $birthday = secure_input($_POST["birthday"]);

    //Input format validation
 
    // check if name only contains letters
    if (!preg_match("/^[a-zA-Z]*$/",$name) or !preg_match("/^[a-zA-Z]*$/",$surname) or !preg_match("/^[a-zA-Z]*$/",$fathername)) {
        $message = '<span style="color:red">Only letters are allowed to names!</span>';
    }

    if (!filter_var($grade, FILTER_VALIDATE_FLOAT)) {
        $message = '<span style="color:red">Only number are allowed to grade!</span>';
    }

    if (!filter_var($mobile_number, FILTER_VALIDATE_INT)) {
        $message = '<span style="color:red">Invalid mobile number!</span>';
    }

    
    // Validate credentials
    if(empty($message)){

        $student = new stdClass();
        $student->id = $id ;
        $student->name = $name ;
        $student->surname = $surname;
        $student->fathername = $fathername;
        $student->grade = $grade;
        $student->mobilenumber = $mobile_number ;
        $student->birthday = $birthday ;
        $data = json_encode($student);

        callAPI('PUT', $db_service.'/api/student/'.$id, $data);


        // Attempt to execute the prepared statement
        if($httpcode == 200){
            $message = '<span style="color:green">You updated a student!</span>';
        }else{
            $message = '<span style="color:red">Oops! Something went wrong. Please try again later.</span>';
        }
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <?php include 'includes.php'; ?>
        <title>Edit Student</title>
    </head>
    <body>
        <?php include 'menu.php'; ?>
        <div id="content">
        	<div class="container admin_form">
                <div class="row">
                    <h1>Update student</h1>
                    <p>Please fill in the form.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="col-md-3">    
                                <label for="id">ID</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="id" id="id" placeholder="1234" value="<?php echo $id; ?>" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="name">First Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name" placeholder="Kostas" value="<?php echo $name; ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label for="surname">Last Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="surname" id="surname" placeholder="Kostopoulos" value="<?php echo $surname; ?>" required> 
                            </div>

                            <div class="col-md-3">
                                <label for="fathername">Father's name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="fathername" id="fathername" placeholder="Giannis" value="<?php echo $fathername; ?>" required> 
                            </div>

                            <div class="col-md-3">
                                <label for="grade">Grade</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="grade" id="grade" placeholder="7.5" value="<?php echo $grade; ?>" required> 
                            </div>

                            <div class="col-md-3">
                                <label for="mobile_number">Mobile number</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="mobile_number" id="mobile_number" placeholder="6925856000" value="<?php echo $mobile_number; ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label for="birthday">Birthday</label>
                            </div>
                            <div class="col-md-9">
                                <input type="date" name="birthday" id="birthday" value="<?php echo $birthday; ?>" required> 
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Sumbit">
                            </div>
                    </form>
                    <div class="notifier"><?php echo $message; ?></div> 
                </div>     
            </div>
        </div>
    </body>
    <?php include 'footer.php'; ?> 
</html>