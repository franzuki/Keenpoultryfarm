<?php
if(isset($_POST['submit']))
{
  $item = $_POST['item'];
  $sql2 ="select * from tblproducts where ProductName = '$item' ";
  $query = $dbh -> prepare($sql2);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
    foreach($results as $row)
    { 
      $remaining = $row->quantity_rem;
      $newquantity = $_POST['quantity'];
      $quantity2 = ($newquantity+$remaining);
      $rate2 = $_POST['rate'];
      $date  = $_POST['date'];
      $item = $_POST['item'];
      $sql3="update tblproducts set UpdationDate=:date, ProductPrice=:rate2, quantity_rem=:quantity2 where ProductName = '$item' ";
      $query=$dbh->prepare($sql3);
      $query->bindParam(':date',$date,PDO::PARAM_STR);
      $query->bindParam(':quantity2',$quantity2,PDO::PARAM_STR);
      $query->bindParam(':rate2',$rate2,PDO::PARAM_STR);
      $query->execute();
      if ( $query->execute()) {
        echo '<script>alert("item has been added.")</script>';
        echo "<script>window.location.href ='store.php'</script>";
      }else{
        echo '<script>alert("Something Went Wrong. Please try again")</script>';

      }
    }
  }else{
    $date  = $_POST['date'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $sql="insert into tblproducts(PostingDate,ProductName,quantity_rem,ProductPrice,)values(:date,:item,:quantity,:rate)";
    $query=$dbh->prepare($sql);
    $query->bindParam(':date',$date,PDO::PARAM_STR);
    $query->bindParam(':item',$item,PDO::PARAM_STR);
    $query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
    $query->bindParam(':rate',$rate,PDO::PARAM_STR);
    $query->execute();
    $LastInsertId=$dbh->lastInsertId();
    if ($LastInsertId>0) {
      echo '<script>alert("item has been added.")</script>';
      echo "<script>window.location.href ='store.php'</script>";
    }
    else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
}
?>
<form role="form" id=""  method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="card-body">

    <div class="form-group ">
      <label for="exampleInputPassword1">Date</label>
      <input type="date" name="date" class="form-control" required />
    </div>
    <div class="form-group ">
      <label for="exampleInputPassword1">Item</label>
       <select  name="item"  class="form-control" required>
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
        </select>
    </div>
    
    <div class="form-group ">
      <label for="exampleInputPassword1">Quantity</label>
      <input type="text" name="quantity" class="form-control" id="exampleInputPassword1" placeholder="Quantity" required>
    </div>
    <div class="form-group ">
      <label for="exampleInputPassword1">Price</label>
      <input type="text" name="rate" class="form-control" id="exampleInputPassword1" placeholder="Price" required>
    </div>
  </div>
  
  <div class="modal-footer text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
