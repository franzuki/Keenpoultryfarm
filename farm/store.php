<?php
include('includes/checklogin.php');
check_login();


if(isset($_GET['del'])){    
  $cmpid=$_GET['del'];
  $query=mysqli_query($con,"delete from tblproducts where id='$cmpid'");
  echo "<script>alert('Product record in store deleted.');</script>";   
  echo "<script>window.location.href='store.php'</script>";
}
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
                  <h5 class="modal-title" style="float: left;">Farm Store</h5>    
                  <div class="card-tools" style="float: right;">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pay-rent"  ><i class="fas fa-plus" ></i>&nbsp; Stock In</button> 
                  </div>    
                </div>
                
                <div class="modal fade" id="pay-rent">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add Items to stock</h4>
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
                
                                
                <div class="card-body table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                   <thead>
                    <tr>
                      <th class="text-center">Date</th>
                      <th class="text-center">Product</th>
                      <th class="text-center">Qty Remaining</th>
                      <th class="text-center">Unit Price</th>
                      <th class="text-center">Actions</th>
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
                        
                        ?>

                        <tr>
                         <td class="text-center"><?php  echo htmlentities(date("d-m-Y", strtotime($row->UpdationDate)));?></td>
                         <td class="text-center"><?php  echo htmlentities($row->ProductName);?></td>
                         <td class="text-center"><?php  echo htmlentities($row->quantity_rem);?></td>
                         <td class="text-center"><?php  echo htmlentities(number_format($row->ProductPrice, 0, '.', ','));?></td>
                         <td class="text-center">
                           <a href="product.php?del=<?php echo ($row->id);?>" data-toggle="tooltip" data-original-title="Delete" class="rounded-circle btn btn-danger" onclick="return confirm('Do you really want to delete?');"> <i class="mdi mdi-delete"></i> </a>
                          </td>
                      </tr>

                      <?php 
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
