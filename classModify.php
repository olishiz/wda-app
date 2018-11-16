<?php
session_start();
include('db-connect.php');

$id = $_GET['id'];
$sqlStatus = $msg = "";
$classIdErr = $classNameErr = $classYearErr = "";
$idStatus = $nameStatus = $classStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['updateClass'])) {

    $classId = $className = $yearForm = $yearGrade = "";
    // server side validation

    if (empty($_POST['classId'])) {
        $classIdErr = "* Class ID is required";
        $idStatus = "false";
    } else {
        $classId = test_input($_POST['classId']);
        $idStatus = "true";

        //check if only capital letter 'S' and followed by three digits
        if (!preg_match('/\AC\d{3}$/', $classId)) {
            $classIdErr = "Only capital 'C' at the start and followed by three digits allowed.";
            $idStatus = "false";
        }
    }

    if (empty($_POST['className'])) {
        $classNameErr = "* Class Name is required";
        $nameStatus = "false";
    } else {
        $className = test_input($_POST['className']);
        $nameStatus = "true";
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $className)) {
            $classNameErr = "Only letters and white space allowed";
            $nameStatus = "false";
        }
    }

    $yearForm = trim($_POST['yearForm']);
    $yearGrade = trim($_POST['yearGrade']);

    if ($yearGrade == "Lower Secondary") {

        if ($yearForm == "Form 1" || $yearForm == "Form 2" || $yearForm == "Form 3") {
            $classStatus = "true";
        } else {
            $classStatus = "false";
            $classYearErr = "Only Form 1 - Form 3 is allowed in Lower Secondary and Form 4 - Form 5 is allowed in Upper Secondary";
        }

    } else if ($yearGrade == "Upper Secondary Science" || $yearGrade == "Upper Secondary Art") {

        if ($yearForm == "Form 4" || $yearForm == "Form 5") {
            $classStatus = "true";
        } else {
            $classStatus = "false";
            $classYearErr = "Only Form 1 - Form 3 is allowed in Lower Secondary and Form 4 - Form 5 is allowed in Upper Secondary";
        }

    }

    if ($idStatus == "true" && $nameStatus == "true" && $classStatus == "true") {

        $sql = "UPDATE class SET
            classId = '$classId',
            className = '$className',
            yearForm = '$yearForm',
            yearGrade = '$yearGrade'
            WHERE id = $id";

        if ($conn->query($sql) === true) {
            $sqlStatus = "success";
            $msg = "Update Class Record Successful!";
        } else {
            $sqlStatus = "failure";
            $msg = "Update Class Record Fail!";
        }

    } else {
        $sqlStatus = "failure";
        $msg = "Error in server side form validation.";
    }


}

if (isset($_POST['removeClass'])) {

    $sql = "DELETE FROM class WHERE id=$id";
    if ($conn->query($sql)) {
        $sqlStatus = "success";
        $msg = "Class Record has been deleted successfully.";
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

  <title>Modify Class Page</title>

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
            <h5 class="card-header">Modify Class Records</h5>
            <div class="card-body">

            <?php 
            if ($sqlStatus == "success") {
                echo "<button class=\"btn btn-lg btn-success btn-block\">" . $msg . "</button><br>";
            } else if ($sqlStatus == "failure") {
                echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $msg . "</button><br>";
            }
            ?>
                <p class="card-text">Modify class records for students.</p>
                <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group text-left">
                                <label for="">Class ID</label>  
                                <input class="form-control text-left" placeholder="Class ID" name="classId" type="text" style="width: 300px;" 
                                value="<?php $sql = "SELECT classId FROM class WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['classId'];
                                        }
                                        ?>">    
                                <span class="error"><?php echo $classIdErr; ?></span>   
                                <small class="form-text text-muted">
                                Note: Start each class ID with capital letter 'C' and followed by three digits.
                                </small>                                                      
                            </div>
                            <div class="form-group">
                                <label for="">Class Name</label>                                
                                <input class="form-control" placeholder="Class Name" name="className" type="text" style="width: 300px;" 
                                value="<?php 
                                        $sql = "SELECT className FROM class WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['className'];
                                        }
                                        ?>">    
                                <span class="error"><?php echo $classNameErr; ?></span>                     
                            </div>
                            <?php
                            $sql = "SELECT yearForm FROM class WHERE id = $id";
                            $result = $conn->query($sql);
                            $input = $f1 = $f2 = $f3 = $f4 = $f5 = "";
                            while ($row = $result->fetch_assoc()) {
                                $input = $row['yearForm'];
                            }
                            if ($input === "Form 1")
                                $f1 = "checked";
                            else if ($input === "Form 2")
                                $f2 = "checked";
                            else if ($input === "Form 3")
                                $f3 = "checked";
                            else if ($input === "Form 4")
                                $f4 = "checked";
                            else if ($input === "Form 5")
                                $f5 = "checked";

                            ?>
                            <label for="">Year Form</label>
                            <div class="row align-items-center ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios1" value="Form 1" <?php echo $f1; ?>>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Form 1
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios2" value="Form 2" <?php echo $f2; ?>>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Form 2
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios3" value="Form 3" <?php echo $f3; ?>>
                                    <label class="form-check-label" for="exampleRadios3">
                                        Form 3
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios4" value="Form 4" <?php echo $f4; ?>>
                                    <label class="form-check-label" for="exampleRadios4">
                                        Form 4
                                    </label>
                                </div>
                                <div class="form-check ml-3">
                                    <input class="form-check-input" type="radio" name="yearForm" id="exampleRadios5" value="Form 5" <?php echo $f5; ?>>
                                    <label class="form-check-label" for="exampleRadios5">
                                        Form 5
                                    </label>
                                </div>
                            </div>
                            <?php
                            $sql = "SELECT yearGrade FROM class WHERE id = $id";
                            $result = $conn->query($sql);
                            $input = $g1 = $g2 = $g3 = "";
                            while ($row = $result->fetch_assoc()) {
                                $input = $row['yearGrade'];
                            }
                            if ($input === "Lower Secondary")
                                $g1 = "checked";
                            else if ($input === "Upper Secondary Science")
                                $g2 = "checked";
                            else if ($input === "Upper Secondary Art")
                                $g3 = "checked";

                            ?>
                            <label for="" class="mt-2">Year Grade</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios1" value="Lower Secondary" <?php echo $g1; ?>>
                                <label class="form-check-label" for="exampleRadios1">
                                    Lower Secondary
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios2" value="Upper Secondary Science" <?php echo $g2; ?>>
                                <label class="form-check-label" for="exampleRadios2">
                                    Upper Secondary Science
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="yearGrade" id="exampleRadios3" value="Upper Secondary Art" <?php echo $g3; ?>>
                                <label class="form-check-label" for="exampleRadios3">
                                    Upper Secondary Art
                                </label>
                            </div>
                            <span class="error"><?php echo $classYearErr; ?></span>   
                            <small class="form-text text-muted">
                                Note: Lower Secondary Education (Form 1 - Form 3) and Upper Secondary Education (Form 4 - Form 5) 
                            </small> 
                            <br>
                            <input class="btn btn-lg btn-primary btn-block" style="width: 300px;" type="submit" value="Update Class" name="updateClass">         
                            <input class="btn btn-lg btn-danger btn-block" style="width: 300px;" type="submit" value="Remove Class" name="removeClass">                                                                                                   
                        </form>
                            <a href="class.php"><button class="btn btn-lg btn-link btn-block" style="width: 300px;">Back</button></a>  
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
