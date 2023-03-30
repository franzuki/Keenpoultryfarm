<?php
include('includes/checklogin.php');
include('includes/functions.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
<?php @include("includes/head.php");?>
<body>
  <div class="container-scroller">
    
    <?php @include("includes/header.php");?>
    
    <div class="container-fluid page-body-wrapper">
      
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="modal-header">
                <h3 class="modal-title" style="float: left;">Losses Report</h3>
                </div>
                
                <div class="card-body table-responsive p-3">
                <button type="button" style="width:150px; background-color:RGB(101,140,187)" onclick="printTable()">Print Report</button>

                  <table class="table align-items-center table-flush table-hover table-bordered" id="dataTableHover">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Cause</th>
                      <th>Date</th>
                      <th>Type (Stock-in)</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql="select * from losses ORDER BY id DESC";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                      foreach($results as $row)
                      {  
                        ?>
                        <tr>
                          <td><?php echo $cnt;?></td>

                          <td class="font-w600"><?php  echo htmlentities($row->productname);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->quantity);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->cause);?></td>
                          <td class="font-w600"><?php  echo htmlentities(date("d-m-Y", strtotime($row->date)));?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->type);?></td>

                        </tr>

                        <?php 
                        $cnt++;
                      }
                    }?>
                  </tbody>                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      <?php @include("includes/footer.php");?>

      
    </div>
    
  </div>
  
</div>

<?php @include("includes/foot.php");?>

</body>

</html>

