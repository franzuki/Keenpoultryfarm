<?php
include('includes/checklogin.php');
check_login();
if(isset($_POST['save']))
{
  $name=$_POST['name'];
  $desc=$_POST['description'];
  $quant=$_POST['quantity'];
  $total=$_POST['total'];
  $sql=mysqli_query($con,"INSERT INTO expenses(name,description,quantity,total) VALUES('$name','$desc','$quant','$total')");
    if($sql)
    {
      echo"<script>alert('Saved successfully')</script>";
    }
    else
    {
      echo"<script>alert('Something went wrong. Check your entries!')</script>";
    }
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
                <div class="table-responsive p-3">
                  <table id="datable_1" class="table table-hover w-100 display pb-30">
                    <thead>
                      <tr>
                        <th>Expense Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <form method="post" action="expenses.php">                                                  
                          <tr>
                            <td><input type="text" autofill="yes" name="name" required> </td>
                            <td><input type="text" autofill="yes" name="description" required> </td>
                            <td><input type="text" autofill="yes" name="quantity" required> </td>
                            <td><input type="number" autofill="yes" name="total" required> </td>
                          </tr>
                          
                          <tr>
                          <td><input type="submit" name="save" class="btn btn-block btn-lg font-weight-medium " style="background-color: dodgerblue; color: white;"></input></td>
                          </tr>

                        </form>
                      
                    </tbody>
                  </table>
                  <br>


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
