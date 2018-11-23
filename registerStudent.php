<?php
session_start();
include('db-connect.php');

$id = $_GET['id'];
$sqlStatus = $msg = "";
$classIdErr = $yearFormErr = $yearGradeErr = "";
$classStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['registerStudent'])) {

    $classId = $yearForm = $yearGrade = "";
    
    // server side validation
    if (empty($_POST['classId'])) {
        $classIdErr = "* Class ID is required";
        $classStatus = "false";
    } else {
        $classId = test_input($_POST['classId']);
        $yearForm = test_input($_POST['yearForm']);
        $yearGrade = test_input($_POST['yearGrade']);

        $classStatus = "true";

        $sql = "SELECT classId, yearForm, yearGrade FROM class WHERE classId = '$classId' AND yearForm = '$yearForm' AND yearGrade = '$yearGrade'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $count = $result->num_rows;

        if (!($count == 1)) {
            $classIdErr = "Class does not exist. Please try again.";
        } else {

            $sql2 = "UPDATE students SET
                     classId = '$classId',
                     yearForm = '$yearForm',
                     yearGrade = '$yearGrade'
                     WHERE id = $id";

            if ($conn->query($sql2) === true) {
                $sqlStatus = "success";
                $msg = "Registration of student into class " . $classId . " has been Successful!";
            } else {
                $sqlStatus = "failure";
                $msg = "Registration of student into class " . $classId . " has been Failure!";
            }

        }

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

  <title>Register Student Class Page</title>

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
            <h5 class="card-header">Register Student Class</h5>
            <div class="card-body">

            <?php 
            if ($sqlStatus == "success") {
                echo "<button class=\"btn btn-lg btn-success btn-block\">" . $msg . "</button><br>";
            } else if ($sqlStatus == "failure") {
                echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $msg . "</button><br>";
            }
            ?>
                <p class="card-text">In this section, you will be able to register student into the available classes by inserting the Class ID, Year Form and Year Grade.</p>
                <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Class ID</label>                                
                                <input class="form-control" placeholder="Class ID" name="classId" type="text" style="width: 300px;">    
                                <span class="error"><?php echo $classIdErr; ?></span>                     
                            </div>
                            <label for="">Year Form</label>
                            <div class="row align-items-center ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios1" value="Form 1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Form 1
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios2" value="Form 2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Form 2
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios3" value="Form 3">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Form 3
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios4" value="Form 4">
                                    <label class="form-check-label" for="exampleRadios4">
                                        Form 4
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios5" value="Form 5">
                                    <label class="form-check-label" for="exampleRadios5">
                                        Form 5
                                    </label>
                                </div>
                            </div>
                            <label for="" class="mt-2">Year Grade</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios1" value="Lower Secondary" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Lower Secondary
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios2" value="Upper Secondary Science">
                                <label class="form-check-label" for="exampleRadios2">
                                    Upper Secondary Science
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios3" value="Upper Secondary Art">
                                <label class="form-check-label" for="exampleRadios3">
                                    Upper Secondary Art
                                </label>
                            </div>  
                            <br>
                            <div class="form-group text-left">
                                <label for="">Student No.</label>  
                                <input class="form-control text-left" placeholder="Student No." name="studentNo" type="text" style="width: 300px;" 
                                value="<?php $sql = "SELECT studentNo FROM students WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['studentNo'];
                                        }
                                        ?>" readonly>                                                         
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
                                        ?>" readonly>                      
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
                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="Male" <?php echo $g1; ?> disabled>
                                <label class="form-check-label" for="exampleRadios1">
                                    Male
                                </label>
                            </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Female" <?php echo $g2; ?> disabled>
                                <label class="form-check-label" for="exampleRadios2">
                                    Female
                                </label>
                            </div>
                            <br>
                            <input class="btn btn-lg btn-success btn-block" style="width: 300px;" type="submit" value="Register Student" name="registerStudent">                                                                                                            
                        </form>
                            <a href="registration.php"><button class="btn btn-lg btn-link btn-block" style="width: 300px;">Back</button></a>  
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
