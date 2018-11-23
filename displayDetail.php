<?php
session_start();
include('db-connect.php');
$id = $_GET['id'];

//init student variables
$studentNo = $fullName = $gender = $classId = $yearForm = $yearGrade = "";
$bm = $english = $mathematic = $science = $geography = $history = "";
$biology = $chemistry = $physics = "";
$economics = $commerce = $art = "";

$gradeLower = $gradeUpperScience = $gradeUpperArt = "";

$sql = "SELECT * FROM students WHERE id = $id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {

    $studentNo = $row['studentNo'];
    $fullName = $row['fullName'];
    $gender = $row['gender'];
    $classId = $row['classId'];
    $yearForm = $row['yearForm'];
    $yearGrade = $row['yearGrade'];

    $bm = $row['bm'];
    $english = $row['english'];
    $mathematic = $row['mathematic'];
    $science = $row['science'];
    $geography = $row['geography'];
    $history = $row['history'];

    $biology = $row['biology'];
    $chemistry = $row['chemistry'];
    $physics = $row['physics'];

    $economics = $row['economics'];
    $commerce = $row['commerce'];
    $art = $row['art'];

}

$totalScoreLower = $bm + $english + $mathematic + $science + $geography + $history;
$totalScoreUpperScience = $bm + $english + $mathematic + $science + $geography + $history + $biology + $chemistry + $physics;
$totalScoreUpperArt = $bm + $english + $mathematic + $science + $geography + $history + $economics + $commerce + $art;

$averageScoreLower = $totalScoreLower / 6;
$averageScoreUpperScience = $totalScoreUpperScience / 6;
$averageScoreUpperArt = $totalScoreUpperArt / 6;

if ($averageScoreLower >= 90 && $averageScoreLower <= 100) {
    $gradeLower = 'A';
} else if ($averageScoreLower >= 80 && $averageScoreLower <= 89) {
    $gradeLower = 'B';
} else if ($averageScoreLower >= 70 && $averageScoreLower <= 79) {
    $gradeLower = 'C';
} else if ($averageScoreLower >= 60 && $averageScoreLower <= 69) {
    $gradeLower = 'D';
} else {
    $gradeLower = 'F';
}

if ($averageScoreUpperScience >= 90 && $averageScoreUpperScience <= 100) {
    $gradeUpperScience = 'A';
} else if ($averageScoreUpperScience >= 80 && $averageScoreUpperScience <= 89) {
    $gradeUpperScience = 'B';
} else if ($averageScoreUpperScience >= 70 && $averageScoreUpperScience <= 79) {
    $gradeUpperScience = 'C';
} else if ($averageScoreUpperScience >= 60 && $averageScoreUpperScience <= 69) {
    $gradeUpperScience = 'D';
} else {
    $gradeUpperScience = 'F';
}

if ($averageScoreUpperArt >= 90 && $averageScoreUpperArt <= 100) {
    $gradeUpperArt = 'A';
} else if ($averageScoreUpperArt >= 80 && $averageScoreUpperArt <= 89) {
    $gradeUpperArt = 'B';
} else if ($averageScoreUpperArt >= 70 && $averageScoreUpperArt <= 79) {
    $gradeUpperArt = 'C';
} else if ($averageScoreUpperArt >= 60 && $averageScoreUpperArt <= 69) {
    $gradeUpperArt = 'D';
} else {
    $gradeUpperArt = 'F';
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

  <title>Display Detail Page</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

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
            <h5 class="card-header">Display Student Records Detail</h5>
            <div class="card-body">

                <button type="button" class="btn btn-dark">Student Details</button>
                <br><br>
                
                <p><strong>Student No. : </strong> <?php echo $studentNo ?></p>
                <p><strong>Full Name : </strong> <?php echo $fullName ?></p>
                <p><strong>Gender : </strong> <?php echo $gender ?></p>

                <p><strong>Class ID : </strong> <?php echo $classId ?></p>
                <p><strong>Year Form : </strong> <?php echo $yearForm ?></p>
                <p><strong>Year Grade : </strong> <?php echo $yearGrade ?></p>

                <hr>
                <button type="button" class="btn btn-primary">Subject Score</button>
                <br><br>

                <p><strong>BM: </strong> <?php echo $bm ?></p>
                <p><strong>English : </strong> <?php echo $english ?></p>
                <p><strong>Mathematic : </strong> <?php echo $mathematic ?></p>
                <p><strong>Science : </strong> <?php echo $science ?></p>
                <p><strong>Geography : </strong> <?php echo $geography ?></p>
                <p><strong>History : </strong> <?php echo $history ?></p>

                <?php 
                if ($yearGrade === "Upper Secondary Science") {

                    ?>
                <p><strong>Biology : </strong> <?php echo $biology ?></p>
                <p><strong>Chemistry : </strong> <?php echo $chemistry ?></p>
                <p><strong>Physics : </strong> <?php echo $physics ?></p>
                <?php

            } else if ($yearGrade === "Upper Secondary Art") {

                ?>
                        <p><strong>Economics : </strong> <?php echo $economics ?></p>
                        <p><strong>Commerce : </strong> <?php echo $commerce ?></p>
                        <p><strong>Art : </strong> <?php echo $art ?></p>
                    <?php 
                }
                ?>

                <hr>
                <button type="button" class="btn btn-danger">Total Score / Final Grade</button>
                <br><br>
                <?php
                if ($yearGrade === "Lower Secondary") {
                    echo '<p><strong>Total Score: </strong>' . $averageScoreLower . '</p>';
                } else if ($yearGrade === "Upper Secondary Science") {
                    echo '<p><strong>Total Score: </strong>' . $averageScoreUpperScience . '</p>';
                } else if ($yearGrade === "Upper Secondary Art") {
                    echo '<p><strong>Total Score: </strong>' . $averageScoreUpperArt . '</p>';
                }
                ?>

                <?php
                if ($yearGrade === "Lower Secondary") {
                    echo '<p><strong>Final Grade: </strong>' . $gradeLower . '</p>';
                } else if ($yearGrade === "Upper Secondary Science") {
                    echo '<p><strong>Final Grade: </strong>' . $gradeUpperScience . '</p>';
                } else if ($yearGrade === "Upper Secondary Art") {
                    echo '<p><strong>Final Grade: </strong>' . $gradeUpperArt . '</p>';
                }
                ?>

                <a href="display.php"><button type="button" class="btn btn-link">Back</button></a>

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