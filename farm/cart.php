<?php
session_start();
error_reporting(1);
include('includes/error.php');
include('includes/dbconnection.php');

//function to generate invoice number
function randominv() {
  $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  srand((double)microtime()*1000000);
  $i=0;
  $pass='';
  while ($i<=10){
      $num=rand() % 33;
      $tmp= substr($chars, $num, 1);
      $pass=$pass.$tmp;
      $i++;
  }
  return $pass;
  }


//Code for Checkout
if(isset($_POST['checkout'])){
  $invoiceno= randominv();
  $pid=$_SESSION['productid'];
  $quantity=$_POST['quantity'];
  $cname=$_POST['customername'];
  $cmobileno=$_POST['mobileno'];
  $pmode=$_POST['paymentmode'];
  // if($pmode=="Mpesa"){
  //   @require('payment\daraja\stk_initiate.php');
  
  $value=array_combine($pid,$quantity);
  foreach($value as $pid=> $quantity){
    $ask=mysqli_query($con,"SELECT quantity_rem FROM tblproducts WHERE id=$pid");
    $checked=mysqli_fetch_array($ask);
    $quant=$checked['quantity_rem'];
    if($quant>=$quantity){
    $newquant=( $quant- $quantity);
    $query=mysqli_query($con,"insert into tblorders(ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode) 
    values('$pid','$quantity','$invoiceno','$cname','$cmobileno','$pmode')"); 
    $confirm=mysqli_query($con,"UPDATE tblproducts SET quantity_rem=$newquant WHERE id=$pid");
    echo '<script>alert("Invoice generated successfully. Invoice number is "+"'.$invoiceno.'")</script>';  
    unset($_SESSION["cart_item"]);
    $_SESSION['invoice']=$invoiceno;
    echo "<script>window.location.href='invoice.php'</script>";
    }
    else{
      echo "<script>alert('The amount you are selling is not available')</script>";
      break;
    }
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
                  <form class="needs-validation" method="post" novalidate>
                   <h4 id="Cart">Shopping Cart</h4>
                   <hr />

                   <a id="btnEmpty" href="sell_product.php?action=empty" >Empty Cart</a>
                   <?php
                   if(isset($_SESSION["cart_item"])){
                    $total_quantity = 0;
                    $total_price = 0;
                    ?>  
                    <table class="table align-items-center table-bordered" >
                      <tbody>
                        <tr>
                          <th >Product Name</th>
                          <th>Category</th>
                          <th >Quantity</th>
                          <th >Unit Price</th>
                          <th >Price</th>
                          <th >Remove</th>
                        </tr>   
                        <?php 
                        $productid=array();      
                        foreach ($_SESSION["cart_item"] as $item){
                          $item_price = $item["quantity"]*$item["price"];
                          array_push($productid,$item['code']);

                          ?>
                          <input type="hidden" value="<?php echo $item['quantity']; ?>" name="quantity[<?php echo $item['code']; ?>]">
                          <tr>
                            <td><img src="assets/img/productimages/<?php  echo  $item["image"];?>" class="mr-2" alt=""><?php echo $item["pname"]; ?></td>
                            <td><?php echo $item["catname"]; ?></td>
                            <td><?php echo $item["quantity"]; ?></td>
                            <td><?php echo $item["price"]; ?></td>
                            <td><?php echo number_format($item_price,2); ?></td>
                            <td><a href="sell_product.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"> <i class="mdi mdi-close-circle" style="font-size: 25px;"></i> </a></td>
                          </tr>
                          <?php
                          $total_quantity += $item["quantity"];
                          $total_price += ($item["price"]*$item["quantity"]);
                        }

                        $_SESSION['productid']=$productid;
                        ?>

                        <tr>
                          <td colspan="4" style="align:center"><strong>Total</strong></td>
                          <td colspan=><strong><?php echo number_format($total_price, 2); ?></strong></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table> 
                    <div class="form-row">
                      <div class="col-md-6 mb-10">
                        <label for="validationCustom03">Customer Name</label>
                        <input type="text" class="form-control" id="validationCustom03" pattern="['A-Za-z]+" placeholder="Customer Name" name="customername" required>
                        <div class="invalid-feedback">Please provide a valid customer name.</div>
                      </div>
                      <div class="col-md-6 mb-10">
                        <label for="validationCustom03">Customer Mobile Number</label>
                        <input type="text" class="form-control" maxlength="12" pattern="\d{12}"id="validationCustom03" placeholder="254_ _ _ _ _ _ _ _ " name="mobileno" required>
                        <div class="invalid-feedback">Please provide a valid mobile number that start with 254.</div>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="col-md-6 mb-10">
                        <label for="validationCustom03">Payment Mode</label>
                        <div class="custom-control custom-radio mb-10">
                          <input type="radio" class="custom-control-input" id="customControlValidation2" name="paymentmode" value="cash" required>
                          <label class="custom-control-label" for="customControlValidation2">Cash</label>
                        </div>
                        <div class="custom-control custom-radio mb-10">
                          <input type="radio" class="custom-control-input" id="customControlValidation3" name="paymentmode" value="Mpesa" required>
                          <label class="custom-control-label" for="customControlValidation3">Mpesa</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4 ">
                        <button class="btn btn-primary mt-6" type="submit" name="checkout">Checkout</button>
                      </div>
                    </div>
                  </form>
                  <?php
                } else {
                  ?>
                  <div style="color:red align:center">Your Cart is Empty</div>
                  <?php 
                }
                ?>

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

<style type="text/css">
  #btnEmpty {
    background-color: #ffffff;
    border: #d00000 1px solid;
    padding: 5px 10px;
    color: #d00000;
    float: right;
    text-decoration: none;
    border-radius: 3px;
    margin: 10px 0px;
  }

</style>
<script type="text/javascript">
  /*Validation Init*/

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>