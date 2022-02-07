<?php
session_start();
// echo '<pre>';
                // print_r($_SESSION);
// echo '</pre>';
include('condb.php');
$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
if($m_level!='staff'){
Header("Location: logout.php");
}
//query member login
$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id";
$resultm = mysqli_query($condb, $queryemp) or die ("Error in query: $queryemp " . mysqli_error());
$rowm = mysqli_fetch_array($resultm);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>ระบบบันทึกเวลาการทำงาน by devbanban.com</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col col-sm-12">
          <h3  class="jumbotron" align="center">Work-IO ระบบบันทึกเวลาการทำงาน by devbanban.com </h3>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col col-sm-2">
          <img src="img/<?php echo $rowm['m_img'];?>" width='70%'>
          <br>
          <b>
          <?php echo $rowm['m_firstname'].$rowm['m_name']. ' '.$rowm['m_lastname'];?>
          <br>
          <?php echo $rowm['m_position'];?>
          </b>
          <br>
          <div class="list-group">
            <a href="profile.php" class="list-group-item list-group-item-action active">
              home
            </a>
            <a href="job.php" class="list-group-item list-group-item-action">-Job</a>
            <a href="logout.php" class="list-group-item list-group-item-danger" onclick="return confirm('Logout??');">-Logout</a>
          </div>
        </div>
        <div class="col col-sm-10">
          
          
          <h3>List Job
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">+job</button>
          </h3>
          <?php
          $queryjob = "SELECT * FROM tbl_job WHERE ref_m_id = $m_id ORDER BY id DESC";
          $rs = mysqli_query($condb, $queryjob)  or die("Error:" . mysqli_error($queryjob));
          echo "
          <table class='table table-bordered table-striped table-sm'>
            <thead>
              <tr class='table-info'>
                <th width='5%'>#</td>
                <th width='40%'>job_detail</td>
                <th width='30%'>job_remark</td>
                <th width='10%'>job_by</td>
                <th width='15%'>date</td>
              </tr>
            </thead>
            ";
            foreach ($rs as $row) {
            echo "<tr>";
              echo "<td>" .$row["id"] ."</td> ";
              echo "<td>" .$row["job_detail"] .  "</td> ";
              echo "<td>" .$row["job_remark"] .  "</td> ";
              echo "<td>" .$row["job_by"] .  "</td> ";
              echo "<td>" .date('d/m/Y',strtotime($row["date_save"])) .  "</td> ";
            echo "</tr>";
            }
          echo '</table>';
          ?>
          ตัวอย่าง datatable : https://devbanban.com/?p=1946
        </div>
      </div>
    </div>
    <div class="container-fluid" style="margin-top: 100px;">
      <div class="row">
        <div class="col col-sm-12">
          <p align="center"> *เป็นระบบตัวอย่าง สำหรับเอาไปพัฒนาต่อยอดนะครับ <br>
            <a href="https://devbanban.com/" target="_blank">
              https://devbanban.com/
            </a></p>
          </div>
        </div>
      </div>
      <!--start form modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">บันทึกการทำงาน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="save_job.php" method="post">
                <div class="form-group">
                  <label class="col-form-label">job detail:</label>
                  <textarea class="form-control" name="job_detail" required minlength="3"></textarea>
                </div>
                <div class="form-group">
                  <label  class="col-form-label">job remark:</label>
                  <textarea class="form-control" name="job_remark" required minlength="3"></textarea>
                </div>
                <div class="form-group">
                  <label  class="col-form-label">job by:</label>
                  <input type="text" name="job_by" class="form-control" required minlength="3" placeholder="ชื่อผู้สั่งงาน">
                </div>
                
              </div>
              <div class="modal-footer">
                <input type="hidden" name="m_id" value="<?php echo $m_id;?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  type="submit" class="btn btn-success">SAVE</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--end form modal -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
  </html>