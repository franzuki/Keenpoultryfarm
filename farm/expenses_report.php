<?php
include('includes/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
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
                  <h5 class="modal-title" style="float: left;">Expenses Report</h5>
                </div>
                
                <div class="card-body table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Expense Name</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Total Cost</th>
                      <th>Date</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $rno=mt_rand(10000,99999); 
                    $sql="select id,name,description,quantity,total,date from expenses ORDER BY id DESC";
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

                          <td class="font-w600"><?php  echo htmlentities($row->name);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->description);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->quantity);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->total);?></td>
                          <td class="font-w600"><?php  echo htmlentities(date("d-m-Y", strtotime($row->date)));?></td>
                          
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
