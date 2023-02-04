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
                <div class="table-responsive p-3">
                  <table id="datable_1" class="table table-hover w-100 display pb-30">
                    <thead>
                      <tr>
                        <th>Expense Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <form method="post" action="expenses.php">                                                  
                          <tr>
                            <td><input type="text" autofill="yes"> </td>
                            <td><input type="text" autofill="yes"> </td>
                            <td><input type="text" autofill="yes"> </td>
                            <td><input type="text" autofill="yes"> </td>
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
