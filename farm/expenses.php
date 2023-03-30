<?php
include('includes/checklogin.php');
check_login();
if(isset($_POST['save']))
{
  $name=$_POST['name'];
  $desc=$_POST['description'];
  $total=$_POST['total'];
  $sql=mysqli_query($con,"INSERT INTO expenses(name,description,total) VALUES('$name','$desc','$total')");
    if($sql)
    {
      echo"<script>alert('Saved successfully')</script>";
    }
    else
    {
      echo"<script>alert('Something went wrong. Check your entries!')</script>";
    }
}
if(isset($_GET['confirm'])){    
  $id=$_GET['eid'];
  $query=mysqli_query($con,"UPDATE expenses set status='1' where id='$id'");
  echo "<script>alert('Confirmed successfully');</script>";   
  echo "<script>window.location.href='expenses_report.php'</script>";
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
             <h2 style="text-align:center"> Expenses </h2>
          <div class="card-body">
            <form  method="post" action="expenses.php" autocomplete="off">
                <div class="row">
                    <div class="form-group col-md-4">
                      <label for="exampleInputPassword1">Expense Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" required="required">
                    </div>
                    <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="Eg supplied by ....." required="required" >
                    </div>
                    <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Total Cost</label>
                        <input type="number" class="form-control" name="total" placeholder="Total" required="required">
                    </div>
                </div>
                                     
                <div class="form-group">
                    <input type="submit" value="Save" name="save" id="submit" class="btn btn-info">
                </div>
            </form>
          </div> 
        </div>        
        
        <?php @include("includes/footer.php");?>
        
      </div>
      
    </div>
    
  </div>
 
  <?php @include("includes/foot.php");?>
  
</body>
</html>
