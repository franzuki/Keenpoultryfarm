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
                <h3 class="modal-title" style="float: left;">Expenses Report</h3>
                </div>
                
                <div class="card-body table-responsive p-3">
                <button type="button" style="width:150px; background-color:RGB(101,140,187)" onclick="printTable()">Print Report</button>
                
                  <table class="table align-items-center table-flush table-hover table-bordered" id="dataTableHover">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Expense Name</th>
                      <th>Description</th>
                      <th>Total Cost (Ksh)</th>
                      <th>Date</th>
                      <th>Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql="SELECT * from expenses ORDER BY id DESC";
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
                          <td class="font-w600"><?php  echo htmlentities($row->total);?></td>
                          <td class="font-w600"><?php  echo htmlentities(date("d-m-Y", strtotime($row->date)));?></td>
                          <td class="font-w600">
                            <?php if($row->status==1){
                              echo '<span style="color:green">confirmed</span>';
                            } else{ ?>
                              <a href="expenses.php?confirm=yes&eid=<?php echo $row->id; ?>" onclick="return confirm('Do you really want to confirm the expense? You cannot reverse this action');">Confirm</a>
                            <?php } ?>
                          </td>
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
