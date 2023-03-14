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
                  <h5 class="modal-title" style="float: left;">View Invoices</h5>
                </div>
                
                <div class="card-body ">
                <button type="button" style="width:150px; background-color:RGB(101,140,187)" onclick="window.print()">Print Report</button>

                  <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                    <div class="invoice-from-wrap">
                      <div class="row">
                        <div class="col-md-7 mb-20">
                         <img style="height: 125px;" class="img-avatar mb-3" src="assets/img/companyimages/logo.jpg" alt="">
                          
                        </div>
                        <?php 
                        //Consumer Details
                        $inid=$_SESSION['invoice'];
                        $query=mysqli_query($con,"select distinct InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode,InvoiceGenDate  from tblorders  where InvoiceNumber='$inid'");
                        
                        $payment='';
                        $cnt=1;
                        while($row=mysqli_fetch_array($query))
                        { 
                          ?>
                          <div class="col-md-5 mb-20">
                            <h4 class="mb-35 font-weight-600">Invoice / Receipt</h4>
                            <table  border="0" >
                              <tr>
                                <td><strong >Date:</strong></td>
                                <td></td>
                                <td><?php  echo htmlentities(date("d-m-Y", strtotime($row['InvoiceGenDate'])));?></td>
                              </tr>
                              <tr>
                                <td><strong >Invoice / Receipt:</strong></td>
                                <td>&nbsp;</td>
                                <td><?php echo $row['InvoiceNumber'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Customer:</strong></td>
                                <td></td>
                                <td><?php echo $row['CustomerName'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Customer Mobile No:</strong></td>
                                <td></td>
                                <td>0<?php echo $row['CustomerContactNo'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Payment Mode:</strong></td>
                                <td></td>
                                <td><?php echo $row['PaymentMode'];?></td>
                              </tr>
                            </table>
                          </div>
                          <?php $payment = $row['PaymentMode'];
                        }  ?>
                      </div>
                    </div>
                    <dir>&nbsp;</dir>
                    <div class="row">
                      <div class="card-body table-responsive p-3">
                        <div class="table-wrap">
                          
                            <table  class="table align-items-center table-bordered " id="dataTableHover">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th >Product Name</th>
                                  <th >Quantity</th>
                                  <th >Unit Price (Ksh)</th>
                                  <th >Total Price (Ksh)</th>

                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                //Product Details
                                $query=mysqli_query($con,"SELECT tblproducts.ProductName,tblorders.Quantity, tblproducts.ProductPrice from tblorders join tblproducts on tblproducts.id=tblorders.ProductId where tblorders.InvoiceNumber='$inid'");
                                
                                $cnt=1;
                                while($row=mysqli_fetch_array($query))
                                {    
                                  ?>                                                
                                  <tr>
                                    <td><?php echo $cnt;?></td>
                                    <td><?php echo $row['ProductName'];?></td>
                                    <td><?php echo $qty=$row['Quantity'];?></td>
                                    <td><?php echo $ppu=$row['ProductPrice'];?></td>
                                    <td><?php echo $subtotal=($ppu*$qty);?></td>
                                  </tr>

                                  <?php
                                  $grandtotal+=$subtotal; 
                                  $cnt++;
                                } ?>
                                <tr>
                                  <th colspan="4" style="text-align:center; font-size:20px;">Total</th> 
                                  <th style="text-align:left; font-size:20px;"><?php echo number_format($grandtotal,0);?></th>   
                                </tr>                                              
                              </tbody>
                            </table>
                            <form method="post" action="<?php  $pay;?>.php">
                              <div align="center" class="col-md-6 mb-4 " >
                                <button style="background-color:green" class="btn btn-primary mt-6" type="submit" name="checkout">Checkout</button>
                              </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </section>
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
