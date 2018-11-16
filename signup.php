<?php

include('db-connect.php');
$sqlStatus = "";
$message = "";
$nameErr = $usernameErr = $passwordErr = $roleErr = "";
$nameStatus = $usernameStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if (isset($_POST['signup'])) {

    $name = $username = $password = $role = "";

    //server side validation
    if (empty($_POST['name'])) {
        $nameErr = "* Name is required";
        $nameStatus = "false";
    } else {
        $name = test_input($_POST['name']);
        $nameStatus = "true";
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $nameStatus = "false";
        }
    }

    if (empty($_POST['username'])) {
        $usernameErr = "* Username is required";
        $usernameStatus = "false";
    } else {
        $username = test_input($_POST['username']);
        $usernameStatus = "true";
        // check if username only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $usernameErr = "Only letters and white space allowed";
            $usernameStatus = "false";
        }
    }

    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($nameStatus == "true" && $usernameStatus == "true") {

        $sql = "INSERT INTO users(`name`, `username`, `password`, `role`) VALUES ('$name', '$username', '$password', '$role')";

        if ($conn->query($sql) === true) {
            $sqlStatus = "success";
            $message = "Sign Up Successful!";
        } else {
            $sqlStatus = "failure";
            $message = "Sign Up Fail!";
        }

    } else {
        $sqlStatus = "failure";
        $message = "Error in server side form validation.";
    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>



</head>
<style>

.vertical-center {
  height:100%;
  width:100%;
  margin: auto;
  display: inline-block;
}

.error {color: #FF0000;}


</style>
<body>
    <?php include('header.php'); ?>
    <br><br>
    <div class="container-fluid vertical-center">
        <div class="row" style="">
            <div class="col-md-4 col-md-offset-4" style="margin: auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php 

                        if ($sqlStatus == "success") {
                            echo "<button class=\"btn btn-lg btn-success btn-block\">" . $message . "</button><br>";
                        } else if ($sqlStatus == "failure") {
                            echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $message . "</button><br>";
                        }

                        ?>
                        <h3 class="panel-title">Sign Up</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Name</label>                                
                                <input class="form-control" placeholder="Name" name="name" type="text" required>
                                <span class="error"><?php echo $nameErr; ?></span>  
                                <small class="form-text text-muted">
                                Please enter your name.
                                </small>                              
                            </div>
                            <div class="form-group">
                                <label for="">Username</label>                                
                                <input class="form-control" placeholder="Username" name="username" type="text" required>
                                <span class="error"><?php echo $usernameErr; ?></span>    
                                <small class="form-text text-muted">
                                Please create your unique username.
                                </small>                              
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input class="form-control" placeholder="Password" name="password" type="password" required>
                                <small class="form-text text-muted">
                                Must be 8-20 characters long.
                                </small>
                            </div>
                            <label for="">Please select a role for the system.</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="admin" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    School Admin
                                </label>
                            </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="teacher">
                                <label class="form-check-label" for="exampleRadios2">
                                    School Teacher
                                </label>
                            </div>
                            <br>
                            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign Up" name="signup">                                                      
                        </form>
                            <a href="login.php"><button class="btn btn-lg btn-link btn-block">Back</button></a>  
                    </div>
                </div>
            </div>
        </div>
    </div>







<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>