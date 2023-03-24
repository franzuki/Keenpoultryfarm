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
                  <h3 class="modal-title" style="float: left;">Current Stock Report</h3>    
                 
                </div>
                <button type="button" style="width:150px; background-color:RGB(101,140,187)" onclick="window.print()">Print Report</button>
                <div class="modal fade" id="pay-rent">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">New Item register</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <?php @include("newitem-form.php");?>
                      </div>
                      
                    </div>
                    
                  </div>
                  
                </div>
                

                <div class="modal fade" id="deleted-items">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">New Items</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <?php @include("deleted-items.php");?>
                      </div>
                     
                        
                      
                    </div>
                    
                  </div>
                  
                </div>
                

                <div id="itemout" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Item Out Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update2">
                        
                        <?php @include("storeout.php");?>
                      </div>
                      
                    </div>
                    
                  </div>
                  
                </div>

                <div class="card-body table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover table-bordered" id="dataTableHover">
                   <thead>
                    <tr>
                      <th class="text-center">Last updated</th>
                      <th class="text-center">Product</th>
                      <th class="text-center">Qty Remaining</th>
                      <th class="text-center">Unit Price (Ksh)</th>
                      <th class="text-center">Total</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql="SELECT * from tblproducts ";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                      foreach($results as $row)
                      {  
                        $remaining=$row->quantity_rem;
                        $rate=$row->ProductPrice;
                        $total=($remaining*$rate);  
                        ?>

                        <tr>
                         <td class="text-center"><?php  echo htmlentities(date("d-m-Y", strtotime($row->UpdationDate)));?></td>
                         <td class="text"><?php  echo htmlentities($row->ProductName);?></td>
                         <td class="text-center"><?php  echo htmlentities($row->quantity_rem);?></td>
                         <td class="text-center"><?php  echo htmlentities(number_format($row->ProductPrice, 0, '.', ','));?></td>
                         <td class="text-center"><?php  echo htmlentities(number_format($total, 0, '.', ','));?></td>
                         
                      </tr>

                      <?php $ctn+=1;
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

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.edit_data',function(){
      var edit_id=$(this).attr('id');
      $.ajax({
        url:"storeout.php",
        type:"post",
        data:{edit_id:edit_id},
        success:function(data){
          $("#info_update2").html(data);
          $("#itemout").modal('show');
        }
      });
    });
  });
</script>
</body>
</html>
