<?php
session_start();
include('db-connect.php');
$session = "";


if (isset($_POST['signup'])) {
    header("Location: signup.php");
    exit;
}

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT username, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    if (!($count == 1)) {
        $errMSG = "User does not exist.";
    } elseif (!($row['password'] == $password)) {
        $errMSG = "Incorrect Password.";
    } else {
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
        exit;
    }

}

// if ($_GET['session'] == "logOut") {
//     //destroying the session once logged out
//     session_unset();
//     session_destroy();
// }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    
</head>
<style>

.vertical-center {
  height:100%;
  width:100%;
  margin: auto;
  display: inline-block;
}


</style>
<body>
    <?php include('header.php'); ?>
    <br><br>
    <div class="container-fluid vertical-center">
        <div class="row" style="">
            <div class="col-md-4 col-md-offset-4" style="margin: auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if (isset($errMSG)) {
                            echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $errMSG . "</button><br>";
                        }
                        ?>
                        <h3 class="panel-title">Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Username</label>                                
                                <input class="form-control" placeholder="Username" name="username" type="text">                                
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input class="form-control" placeholder="Password" name="password" type="password">
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" name="login">
                            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign Up" name="signup">
                        </form>
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