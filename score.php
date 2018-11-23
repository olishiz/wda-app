<?php
session_start();
include('db-connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Score Page</title>

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
            <h5 class="card-header">Score Records</h5>
            <div class="card-body">
                <p class="card-text">The information displayed below are all of the credentials for score records in order to add and modify scores.</p>                
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student No.</th>
                                <th>Full Name</th>
                                <th>Add Score</th>
                                <th>Modify Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * FROM students";
                            $result = $conn->query($sql);
                            $rownum = $result->num_rows;

                            while ($row = $result->fetch_assoc()) {
                                echo
                                    '<tr>
                                  <td>' . $row['studentNo'] . '</td>
                                  <td>' . $row['fullName'] . '</td>															
                                  <td><button class="btn px-0 btn-dark btn-block" style="width: 150px; margin: auto" type="button" onclick="window.location.href=\'addScore.php?id=' . $row['id'] . '\'">Add</button></td>                          
                                  <td><button class="btn px-0 btn-primary btn-block" style="width: 150px; margin: auto" type="button" onclick="window.location.href=\'scoreModify.php?id=' . $row['id'] . '\'">Modify</button></td>                          
                                </tr>';
                            }

                            echo " <tfoot class='foot'><td colspan='8'><div id='records' style='text-align:right;'> " . $rownum . " records found </div></td></tfoot>";

                            ?>  
                        </tbody>
                    </table>
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