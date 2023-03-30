<?php
include('includes/checklogin.php');
check_login();
if(isset($_POST['save'])){
  $type=$_POST['type'];
  if($type=='before')
  {
    $name=$_POST['productname'];
    $quant=$_POST['quantity'];
    $cause=$_POST['cause'];
    $sql=mysqli_query($con,"INSERT INTO losses(productname,quantity, cause, type) VALUES('$name','$quant','$cause', '$type')");
      if($sql)
      {
        echo"<script>alert('Saved successfully')</script>";
      }
      else
      {
        echo"<script>alert('Something went wrong. Check your entries!')</script>";
      }
  }


elseif($type=['after'])
{
  $item2=$_POST['productname'];
  $quantity2=$_POST['quantity'];
  $sql=mysqli_query($con,"SELECT * from tblproducts where ProductName='$item2'");
  $row=mysqli_fetch_array($sql);
  $remaining = $row['quantity_rem'];
  if ($remaining>=$quantity2) 
  {
    $productname=$_POST['productname'];
    $cause=$_POST['cause'];
    $quantity=$_POST['quantity'];
    $sql=mysqli_query($con,"INSERT INTO losses(productname,quantity, cause,type) VALUES('$productname','$quantity','$cause', '$type')");
    if ($sql) {
      $quantity2=$_POST['quantity'];
      $newqtyleft = ($remaining-$quantity2);
      $item=$_POST['productname'];
      $sql3="update  tblproducts set quantity_rem=:newqtyleft where ProductName=:productname";
      $query=$dbh->prepare($sql3);
      $query->bindParam(':newqtyleft',$newqtyleft,PDO::PARAM_STR);
      $query->bindParam(':productname',$item,PDO::PARAM_STR);
      $query->execute();
      echo '<script>alert("Loss recorded successfully. Remaining quantity was also affected")</script>';
    }
    else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }else{
    echo '<script>alert("The quantity you entered is greater than quamtity in stock")</script>';
  }
}}
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
        <h2 style="text-align:center">Losses </h2>
          <div class="card-body">
            <form  method="post" action="losses.php" autocomplete="off">
            
                <div class="row">
                  <div class="form-group col-md-3">
                      <label for="exampleInputPassword1">Type</label>
                      <select name="type" class="form-control" required>
                        <option value="" > Choose </option>
                        <option value="before" > Before Stock in </option>
                        <option value="after" > After Stock in </option>
                      </select>
                  </div>
                    <div class="form-group col-md-3">
                      <label for="exampleInputPassword1">Product name</label>
                        <select  name="productname"  class="form-control" required>
                            <option value="">Select item</option>
                            <?php
                            $sql="SELECT * from  tblproducts";
                            $query = $dbh -> prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            if($query->rowCount() > 0)
                            {
                                foreach($results as $row)
                                {
                                ?> 
                                <option value="<?php  echo $row->ProductName;?>"><?php  echo $row->ProductName;?></option>
                                <?php 
                                }
                            } ?>
                            </select>                    </div>
                    <div class="form-group col-md-3">
                    <label for="exampleInputPassword1">Quantity</label>
                        <input type="number" min="1" class="form-control" name="quantity" placeholder="" required="required" >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleInputPassword1">Cause</label>
                        <input type="text" class="form-control" name="cause" placeholder="What caused the loss" required="required">
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
