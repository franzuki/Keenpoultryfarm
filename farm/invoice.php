<?php
include('includes/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<?php @include("includes/head.php");?>
<style>
      @import url("https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap");

      body {
        background-color: #eaedf4;
        
      }

      .card {
        width: 310px;
        border: none;
        border-radius: 15px;
      }

      .justify-content-around div {
        border: none;
        border-radius: 20px;
        background: #f3f4f6;
        padding: 5px 20px 5px;
        color: #8d9297;
      }

      .justify-content-around span {
        font-size: 12px;
      }

      .justify-content-around div:hover {
        background: #545ebd;
        color: #fff;
        cursor: pointer;
      }

      .justify-content-around div:nth-child(1) {
        background: #545ebd;
        color: #fff;
      }

      span.mt-0 {
        color: #8d9297;
        font-size: 12px;
      }
      .mpesa {
        background-color: green !important;
      }

      img {
        border-radius: 15px;
      }
    </style>
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
                       
                        while($rows=mysqli_fetch_array($query))
                        { 
                          $phone=$rows['CustomerContactNo'];
                          ?>
                          <div class="col-md-5 mb-20">
                            <h4 class="mb-35 font-weight-600">Receipt</h4>
                            <table style=" border:0" >
                              <tr>
                                <td><strong >Date:</strong></td>
                                <td></td>
                                <td><?php  echo htmlentities(date("d-m-Y", strtotime($rows['InvoiceGenDate'])));?></td>
                              </tr>
                              <tr>
                                <td><strong >Receipt No:</strong></td>
                                <td>&nbsp;</td>
                                <td><?php echo $rows['InvoiceNumber'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Customer:</strong></td>
                                <td></td>
                                <td><?php echo $rows['CustomerName'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Mobile No:</strong></td>
                                <td></td>
                                <td><?php echo $rows['CustomerContactNo'];?></td>
                              </tr>
                              <tr>
                                <td><strong >Payment Mode:</strong></td>
                                <td></td>
                                <td><?php echo $rows['PaymentMode'];?></td>
                              </tr>
                            </table>
                          </div>
                          <?php $payment = $rows['PaymentMode'];
                        }  ?>
                      </div>
                    </div>
                    &nbsp;
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
                            </div>
                      </div>
                      <div class="container d-flex justify-content-center">
                          <div class="card mt-5 px-3 py-4">
                            <div class="d-flex flex-row justify-content-around">
                              <div class="mpesa"><span>Mpesa </span></div>
                              <div><span>Paypal</span></div>
                              <div><span>Cash</span></div>
                            </div>
                            <!-- <div class="media mt-4 pl-2">
                              <img src="payment/daraja/images/1200px-M-PESA_LOGO-01.svg.png" class="mr-3" height="75" />
                              
                            </div> -->
                            <div class="media mt-3 pl-2">
                                              <!--bs5 input-->

                                <form class="row g-3" action="payment/daraja/stk_initiate.php" method="POST">
                                
                                    <div class="col-12">
                                      <input type="hidden" class="form-control" name="amount" value="<?php echo $grandtotal ?>" placeholder="Enter Amount">
                                    </div>
                                    <div class="col-12">
                                     <input type="hidden" class="form-control" name="phone" value="<?php echo $phone;?>" placeholder="Enter Phone Number">
                                    </div>
                                
                                    <div class="col-12">
                                      <button type="submit" class="btn btn-success" name="submit" value="submit">Pay With Mpesa</button>
                                    </div>
                                  </form>
                                  <!--bs5 input-->
                              </div>
                            </div>
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
