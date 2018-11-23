<?php
session_start();
include('db-connect.php');

$id = $_GET['id'];
$sqlStatus = $msg = "";
$studentNoErr = $fullNameErr = "";
$idStatus = $nameStatus = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['addScore'])) {

    $bm = $english = $mathematic = $science = $geography = $history = "";
    $biology = $chemistry = $physics = "";
    $economics = $commerce = $art = "";

    $sql1 = "SELECT yearGrade FROM students WHERE id = $id";
    $result1 = $conn->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {

        if ($row1['yearGrade'] === "Lower Secondary") {

            $bm = test_input($_POST['bm']);
            $english = test_input($_POST['english']);
            $mathematic = test_input($_POST['mathematic']);
            $science = test_input($_POST['science']);
            $geography = test_input($_POST['geography']);
            $history = test_input($_POST['history']);

            $sql = "UPDATE students SET
            bm = '$bm',
            english = '$english',
            mathematic = '$mathematic',
            science = '$science',
            geography = '$geography',
            history = '$history'
            WHERE id = $id";

            if ($conn->query($sql) === true) {
                $sqlStatus = "success";
                $msg = "Add Score Record Successful!";
            } else {
                $sqlStatus = "failure";
                $msg = "Add Score Record Fail!";
            }

        } else if ($row1['yearGrade'] === "Upper Secondary Science") {

            $bm = test_input($_POST['bm']);
            $english = test_input($_POST['english']);
            $mathematic = test_input($_POST['mathematic']);
            $science = test_input($_POST['science']);
            $geography = test_input($_POST['geography']);
            $history = test_input($_POST['history']);

            $biology = test_input($_POST['biology']);
            $chemistry = test_input($_POST['chemistry']);
            $physics = test_input($_POST['physics']);

            $sql = "UPDATE students SET
            bm = '$bm',
            english = '$english',
            mathematic = '$mathematic',
            science = '$science',
            geography = '$geography',
            history = '$history',
            biology = '$biology',
            chemistry = '$chemistry',
            physics = '$physics'
            WHERE id = $id";

            if ($conn->query($sql) === true) {
                $sqlStatus = "success";
                $msg = "Add Score Record Successful!";
            } else {
                $sqlStatus = "failure";
                $msg = "Add Score Record Fail!";
            }

        } else if ($row1['yearGrade'] === "Upper Secondary Art") {

            $bm = test_input($_POST['bm']);
            $english = test_input($_POST['english']);
            $mathematic = test_input($_POST['mathematic']);
            $science = test_input($_POST['science']);
            $geography = test_input($_POST['geography']);
            $history = test_input($_POST['history']);

            $economics = test_input($_POST['economics']);
            $commerce = test_input($_POST['commerce']);
            $art = test_input($_POST['art']);

            $sql = "UPDATE students SET
            bm = '$bm',
            english = '$english',
            mathematic = '$mathematic',
            science = '$science',
            geography = '$geography',
            history = '$history',
            economics = '$economics',
            commerce = '$commerce',
            art = '$art'
            WHERE id = $id";

            if ($conn->query($sql) === true) {
                $sqlStatus = "success";
                $msg = "Add Score Record Successful!";
            } else {
                $sqlStatus = "failure";
                $msg = "Add Score Record Fail!";
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

  <title>Add Score Page</title>

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
            <h5 class="card-header">Add Score Records</h5>
            <div class="card-body">
            <?php 

            if ($sqlStatus == "success") {
                echo "<button class=\"btn btn-lg btn-success btn-block\">" . $msg . "</button><br>";
            } else if ($sqlStatus == "failure") {
                echo "<button class=\"btn btn-lg btn-danger btn-block\">" . $msg . "</button><br>";
            }

            ?>
                <p class="card-text">Adding student score records.</p>
                <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="">Year Form</label>                                
                                <input class="form-control" type="text" style="width: 300px;" 
                                value="<?php 
                                        $sql = "SELECT yearForm FROM students WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['yearForm'];
                                        }
                                        ?>" readonly>                              
                            </div>
                            <div class="form-group">
                                <label for="">Year Grade</label>                                
                                <input class="form-control" type="text" style="width: 300px;" 
                                value="<?php 
                                        $sql = "SELECT yearGrade FROM students WHERE id = $id";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo $row['yearGrade'];
                                        }
                                        ?>" readonly>                              
                            </div>
                            <small class="form-text text-muted">
                                Note: Please add the subject score in the range of 0-100 only. Outside of that range will be invalid.
                            </small>    
                            <br>
                            <div class="form-group">
                                <label for="">BM</label>  
                                <input class="form-control" placeholder="BM Score" name="bm" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">English</label>  
                                <input class="form-control" placeholder="English Score" name="english" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Mathematic</label>  
                                <input class="form-control" placeholder="Mathematic Score" name="mathematic" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Science</label>  
                                <input class="form-control" placeholder="Science Score" name="science" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Geography</label>  
                                <input class="form-control" placeholder="Geography Score" name="geography" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">History</label>  
                                <input class="form-control" placeholder="History Score" name="history" type="text" style="width: 300px;" required>                                                     
                            </div>
                            
                            <?php

                            $sql = "SELECT yearGrade FROM students WHERE id = $id";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {

                                if ($row['yearGrade'] === "Upper Secondary Science") {



                                    ?>
                            <div class="form-group">
                                <label for="">Biology</label>  
                                <input class="form-control" placeholder="Biology Score" name="biology" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Chemistry</label>  
                                <input class="form-control" placeholder="Chemistry Score" name="chemistry" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Physics</label>  
                                <input class="form-control" placeholder="Physics Score" name="physics" type="text" style="width: 300px;" required>                                                     
                            </div>


                            <?php

                        } else if ($row['yearGrade'] === "Upper Secondary Art") {

                            ?>
                                
                            <div class="form-group">
                                <label for="">Economics</label>  
                                <input class="form-control" placeholder="Economics Score" name="economics" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Commerce</label>  
                                <input class="form-control" placeholder="Commerce Score" name="commerce" type="text" style="width: 300px;" required>                                                     
                            </div>
                            <div class="form-group">
                                <label for="">Art</label>  
                                <input class="form-control" placeholder="Art Score" name="art" type="text" style="width: 300px;" required>                                                     
                            </div>

                            <?php

                        }

                    }

                    ?>


                            <br>
                            <input class="btn btn-lg btn-primary btn-block" style="width: 300px;" type="submit" value="Add Score" name="addScore">                                                      
                        </form>
                            <a href="score.php"><button class="btn btn-lg btn-link btn-block" style="width: 300px;">Back</button></a>  
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