<?php
session_start();
include('db-connect.php');

$id = $_GET['id'];
$sqlStatus = $msg = "";
$studentNoErr = $fullNameErr = $genderErr = "";
$idStatus = $nameStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['updateStudent'])) {

    $studentNo = $fullName = $gender = "";
    // server side validation
    if (empty($_POST['studentNo'])) {
        $studentNoErr = "* Student No. is required";
        $idStatus = "false";
    } else {
        $studentNo = test_input($_POST['studentNo']);
        $idStatus = "true";

        //check if 6 numeric values and without 0 as starting value - checking regular expressions
        if (!preg_match('/\A[123456789]\d{5}$/', $studentNo)) {
            $studentNoErr = "Invalid Input. Must only consist of 6 numeric values without 0 as starting value.";
            $idStatus = "false";
        }
    }

    if (empty($_POST['fullName'])) {
        $fullNameErr = "* Full Name is required";
        $nameStatus = "false";
    } else {
        $fullName = test_input($_POST['fullName']);
        $nameStatus = "true";
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $fullName)) {
            $fullNameErr = "Only letters and white space allowed";
            $nameStatus = "false";
        }
    }

    $gender = trim($_POST['gender']);

    if ($idStatus == "true" && $nameStatus == "true") {

        $sql = "UPDATE students SET
            studentNo = '$studentNo',
            fullName = '$fullName',
            gender = '$gender'
            WHERE id = $id";

        if ($conn->query($sql) === true) {
            $sqlStatus = "success";
            $msg = "Update Student Record Successful!";
        } else {
            $sqlStatus = "failure";
            $msg = "Update Student Record Fail!";
        }

    } else {
        $sqlStatus = "failure";
        $msg = "Error in server side form validation.";
    }


}

if (isset($_POST['removeStudent'])) {

    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql)) {
        $sqlStatus = "success";
        $msg = "Student Record has been deleted successfully.";
    } else {
        $sqlStatus = "failure";
        $msg = "Error in SQL Statement.";
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

  <title>Modify Student Page</title>

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
            <h5 class="card-header">Modify Student Records</h5>
            <div class="card-body">

            <?php 
            if ($sqlStatus == "success") {
                echo "<button class=\"btn btn-lg btn-success btn-block\">" . $msg . "</button><br>";
            } else if ($sqlStatus == "failure") {
                echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $msg . "</button><br>";
            }
            ?>
                <p class="card-text">Modify student records.</p>
                <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group text-left">
                                <label for="">Student No.</label>  
                                <input class="form-control text-left" placeholder="Student No." name="studentNo" type="text" style="width: 300px;" 
                                value="<?php $sql = "SELECT studentNo FROM students WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['studentNo'];
                                        }
                                        ?>">    
                                <span class="error"><?php echo $studentNoErr; ?></span>   
                                <small class="form-text text-muted">
                                Note: Must only consists of 6 numeric values from [1-9]. Starting with 0 is invalid.
                                </small>                                                      
                            </div>
                            <div class="form-group">
                                <label for="">Full Name</label>                                
                                <input class="form-control" placeholder="Full Name" name="fullName" type="text" style="width: 300px;" 
                                value="<?php 
                                        $sql = "SELECT fullName FROM students WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['fullName'];
                                        }
                                        ?>">    
                                <span class="error"><?php echo $fullNameErr; ?></span>                     
                            </div>
                            <?php
                            $sql = "SELECT gender FROM students WHERE id = $id";
                            $result = $conn->query($sql);
                            $input = $g1 = $g2 = "";
                            while ($row = $result->fetch_assoc()) {
                                $input = $row['gender'];
                            }
                            if ($input === "Male")
                                $g1 = "checked";
                            else if ($input === "Female")
                                $g2 = "checked";

                            ?>
                            <label for="">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="Male" <?php echo $g1; ?>>
                                <label class="form-check-label" for="exampleRadios1">
                                    Male
                                </label>
                            </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Female" <?php echo $g2; ?>>
                                <label class="form-check-label" for="exampleRadios2">
                                    Female
                                </label>
                            </div>
                            <br>
                            <input class="btn btn-lg btn-primary btn-block" style="width: 300px;" type="submit" value="Update Student" name="updateStudent">         
                            <input class="btn btn-lg btn-danger btn-block" style="width: 300px;" type="submit" value="Remove Subject" name="removeStudent">                                                                                                   
                        </form>
                            <a href="student.php"><button class="btn btn-lg btn-link btn-block" style="width: 300px;">Back</button></a>  
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
