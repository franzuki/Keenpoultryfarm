<?php
session_start();
error_reporting(1);
include('includes/error.php');
include('includes/dbconnection.php');
//code for Cart
if(!empty($_GET["action"])) {
  switch($_GET["action"]) {

//code for adding product in cart
    case "add":
    if(!empty($_POST["quantity"])) {
      $pid=$_GET["pid"];
      $result=mysqli_query($con,"SELECT * FROM tblproducts WHERE id='$pid'");
      while($productByCode=mysqli_fetch_array($result)){
        $itemArray = array($productByCode["id"]=>array('catname'=>$productByCode["CategoryName"], 'compname'=>$productByCode["CompanyName"], 'quantity'=>$_POST["quantity"], 'pname'=>$productByCode["ProductName"],'image'=>$productByCode["ProductImage"], 'price'=>$productByCode["ProductPrice"],'code'=>$productByCode["id"]));
        if(!empty($_SESSION["cart_item"])) {
          if(in_array($productByCode["id"],array_keys($_SESSION["cart_item"]))) {
            foreach($_SESSION["cart_item"] as $k => $v) {
              if($productByCode["id"] == $k) {
                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                  $_SESSION["cart_item"][$k]["quantity"] = 0;
                }
                $_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
              }
            }
          } else {
            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
          }
        }  else {
          $_SESSION["cart_item"] = $itemArray;
        }
      }
    }
    break;


    // code for removing product from cart
    case "remove":
    if(!empty($_SESSION["cart_item"])) {
      foreach($_SESSION["cart_item"] as $k => $v) {
        if($_GET["code"] == $k)
          unset($_SESSION["cart_item"][$k]);              
        if(empty($_SESSION["cart_item"]))
          unset($_SESSION["cart_item"]);
      }
    }
    break;
    // code for if cart is empty
    case "empty":
    unset($_SESSION["cart_item"]);
    break;  
  }
}

//Code for Checkout
if(isset($_POST['checkout'])){
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
  $invoiceno= randominv();
  $pid=$_SESSION['productid'];
  $quantity=$_POST['quantity'];
  $cname=$_POST['customername'];
  $cmobileno=$_POST['mobileno'];
  $pmode=$_POST['paymentmode'];
  $value=array_combine($pid,$quantity);
  foreach($value as $pid=> $quantity){
    $ask=mysqli_query($con,"SELECT quantity_remaining FROM store_stock WHERE id=$pid");
    $quant=$ask['quantity_remaining'] - $quantity;
    $query=mysqli_query($con,"insert into tblorders(ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode) 
    values('$pid','$quantity','$invoiceno','$cname','$cmobileno','$pmode')"); 
    $confirm=mysqli_query($con,"UPfDATE store_stock SET quantity_remaining=$quant WHERE id=$pid");
  }
  echo '<script>alert("Invoice generated successfully. Invoice number is "+"'.$invoiceno.'")</script>';  
  unset($_SESSION["cart_item"]);
  $_SESSION['invoice']=$invoiceno;
  echo "<script>window.location.href='invoice.php'</script>";

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
          <button style="float:right">
          <a  href="cart.php">Cart</a>
          </button>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="table-responsive p-3">
                  <table id="datable_1" class="table table-hover w-100 display pb-30">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Category</th>
                        <th>Price (Ksh)</th>
                        <th>Quantity</th>
                        <th>Action</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query=mysqli_query($con,"select * from tblproducts p join store_stock s where p.ProductName=s.item ");
                      $cnt=1;
                      while($row=mysqli_fetch_array($query))
                      {    
                        ?>
                        <form method="post" action="sell_product.php?action=add&pid=<?php echo $row["id"]; ?>">                                                  
                          <tr>
                            <td><?php echo $cnt;?></td>
                            <td> <img src="assets/img/productimages/<?php  echo $row['ProductImage'];?>" class="mr-1" alt=""><?php echo $row['ProductName'];?></td>
                            <td><?php echo $row['CategoryName'];?></td>
                            <td><?php echo $row['ProductPrice'];?></td>
                            <td style="color:green"><input type="number" min="1" class="product-quantity" name="quantity" placeholder = "Enter quantity"  required size="4" <?php
                                if ($row['quantity_remaining'] == 0){
                                  ?> hidden <?php
                                }?> />
                            <?php
                                if ($row['quantity_remaining'] == 0){
                                  ?> <p> <?php stockouterror(); ?> </p>
                                <?php } else {
                                   echo $row['quantity_remaining']?>&nbsp;remaining</td>
                                  <?php } ?>
                            </td>
                            <td>
                              <input type="submit" value="Add to Cart" class="btn btn-secondary p-2" style="background-color:green" />
                            </td>
                          </tr>
                        </form>
                        <?php 
                        $cnt++;
                      } ?>

                    </tbody>
                  </table>
                </div>
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