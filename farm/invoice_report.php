<?php
include('includes/checklogin.php');
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
                  <h3 class="modal-title" style="float: left;">Invoices Report</h3>
                </div>
                <button type="button" style="width:150px; background-color:RGB(101,140,187)" onclick="window.print()">Print Report</button>
                <div class="card-body table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover table-bordered" id="dataTableHover">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Invoice Number</th>
                      <th>Customer Name</th>
                      <th>Customer Contact no.</th>
                      <th>Payment Mode</th>
                      <th>Payment Date</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $rno=mt_rand(10000,99999); 
                    $sql="select distinct InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode,InvoiceGenDate    from tblorders ORDER BY id DESC";
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

                          <td class="font-w600"><?php  echo htmlentities($row->InvoiceNumber);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->CustomerName);?></td>
                          <td class="font-w600">0<?php  echo htmlentities($row->CustomerContactNo);?></td>
                          <td class="font-w600"><?php  echo htmlentities($row->PaymentMode);?></td>
                          <td class="font-w600"><?php  echo htmlentities(date("d-m-Y", strtotime($row->InvoiceGenDate)));?></td>
                          
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
