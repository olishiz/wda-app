<?php
session_start();
include('db-connect.php');

$sqlStatus = $msg = "";
$subIdErr = $subNameErr = $subTypeErr = "";
$idStatus = $nameStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if (isset($_POST['addSubject'])) {

    $subId = $subName = $subType = "";
    // server side validation
    if (empty($_POST['subId'])) {
        $subIdErr = "* Subject ID is required";
        $idStatus = "false";
    } else {
        $subId = test_input($_POST['subId']);
        $idStatus = "true";

        //check if only capital letter 'S' and followed by three digits
        if (!preg_match('/\AS\d{3}$/', $subId)) {
            $subIdErr = "Only capital 'S' at the start and followed by three digits allowed.";
            $idStatus = "false";
        }
    }

    if (empty($_POST['subName'])) {
        $subNameErr = "* Subject Name is required";
        $nameStatus = "false";
    } else {
        $subName = test_input($_POST['subName']);
        $nameStatus = "true";
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $subName)) {
            $subNameErr = "Only letters and white space allowed";
            $nameStatus = "false";
        }
    }

    $subType = trim($_POST['subType']);

    if ($idStatus == "true" && $nameStatus == "true") {

        $sql = "INSERT INTO subjects(`subjectId`, `subjectName`, `subjectType`) VALUES ('$subId', '$subName', '$subType')";

        if ($conn->query($sql) === true) {
            $sqlStatus = "success";
            $msg = "Add Subject Record Successful!";
        } else {
            $sqlStatus = "failure";
            $msg = "Add Subject Record Fail!";
        }

    } else {
        $sqlStatus = "failure";
        $msg = "Error in server side form validation.";
    }


}





?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Add Subject Page</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>
<style>

.error {color: #FF0000;}


</style>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <!-- php code to retrieve name -->
    <a class="navbar-brand mr-1" href="dashboard.php">Welcome, <?php echo $_SESSION['user'] ?>. Your role is <?php echo $_SESSION['role'] ?></a>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php 

    if ($_SESSION['role'] == "admin") {
        include('sidebar-nav-admin.php');
    } else if ($_SESSION['role'] == "teacher") {
        include('sidebar-nav-teacher.php');
    }

    ?>

    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Main content goes here -->
        <div class="card">
            <h5 class="card-header">Add Subject Records</h5>
            <div class="card-body">
            <?php 

            if ($sqlStatus == "success") {
                echo "<button class=\"btn btn-lg btn-success btn-block\">" . $msg . "</button><br>";
            } else if ($sqlStatus == "failure") {
                echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $msg . "</button><br>";
            }

            ?>
                <p class="card-text">Adding subject records for students.</p>
                <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Subject ID</label>  
                                <input class="form-control" placeholder="Subject ID" name="subId" type="text" style="width: 300px;" required> 
                                <span class="error"><?php echo $subIdErr; ?></span>                           
                                <small class="form-text text-muted">
                                Please enter the subject ID. Note: Start each subject ID with capital letter 'S' and followed by three digits.
                                </small>                              
                            </div>
                            <div class="form-group">
                                <label for="">Subject Name</label>                                
                                <input class="form-control" placeholder="Subject Name" name="subName" type="text" style="width: 300px;" required>  
                                <span class="error"><?php echo $subNameErr; ?></span>   
                                <small class="form-text text-muted">
                                Please enter the subject name.
                                </small>                              
                            </div>
                            <label for="">Subject Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="subType" id="exampleRadios1" value="Core" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Core
                                </label>
                            </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="subType" id="exampleRadios2" value="Selective">
                                <label class="form-check-label" for="exampleRadios2">
                                    Selective
                                </label>
                            </div>
                            <br>
                            <input class="btn btn-lg btn-primary btn-block" style="width: 300px;" type="submit" value="Add Subject" name="addSubject">                                                      
                        </form>
                            <a href="subject.php"><button class="btn btn-lg btn-link btn-block" style="width: 300px;">Back</button></a>  
                    </div>
            </div>
        </div> 

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <?php include('footer.php'); ?>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a href="login.php?session=logOut"><button class="btn btn-primary" name="logout">Logout</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>