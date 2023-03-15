<?php
$message="";
$valid='true';
include("../includes/dbconnection.php");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email_reg=mysqli_real_escape_string($con,$_POST['email']);
    $details=mysqli_query($con,"SELECT FirstName,Email FROM tbladmin WHERE Email='$email_reg'");
    if (mysqli_num_rows($details)>0) { //if the given email is in database, ie. registered
        //generating the random key
        $key=md5(time()+123456789% rand(4000, 55000000));
        //insert this temporary key into database
        $sql_insert=mysqli_query($con,"INSERT INTO forget_password (email,temp_key) VALUES('$email_reg','$key')");
       if ($sql_insert){
            //sending email about update
        $message_success=" Please check your email inbox or spam folder and follow the steps";
        $to = $email_reg;
        $subject = 'Change password';
        $msg = "Please copy the link and paste in your browser address bar". "\r\n"."http://keenpoultryfarm.000webhostapp.com/forgot-password/forgot_password_reset.php?key=".$key."&email=".$email_reg;
        $headers = 'From:keenpoultryfarming@gmail.com' . "\r\n";
        mail($to, $subject, $msg, $headers);
       }
       else{
           $message_fail="You already have an email send to you. Check your inbox or spam folder";
       }
       
       
    }
    else{
        $message="Sorry! no account associated with this email";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <title>Forgot Password</title>
  </head>
  <body>
    <div class="container">
      <div class="row"><br><br><br>
        <div class="col-md-4"></div>
        <div class="col-md-4" style="background-color: #D2D1D1; border-radius:15px;">
          <br><br>
          <form role="form" method="POST">
          <div class="form-group">
            <label>Please enter USER's email to help them recover their password</label><br><br>
            <select  id="email" name="email"  class="form-control" required>
            <option value="">Select User's Email</option>
            <?php
            $sql="SELECT * from  tbladmin";
            $query = $dbh -> prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0)
            {
                foreach($results as $row)
                {
                ?> 
                <option value="<?php  echo $row->Email;?>"><?php  echo $row->Email;?></option>
                <?php 
                }
            } ?>
            </select>

            </div>
                      
            <?php if (isset($error)) {
                      echo"<div class='alert alert-danger' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$error."</div>";
                 } ?>
            <?php if ($message<>"") {
                      echo"<div class='alert alert-danger' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$message."</div>";
                } ?>
            <?php if (isset($message_success)) {
                      echo"<div class='alert alert-success' role='alert'>
                      <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$message_success."</div>";
                  } ?>
             <?php if (isset($message_fail)) {
                      echo"<div class='alert  alert-danger' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>".$message_fail."</div>";
                  } ?>      
              <button type="submit" class="btn btn-primary pull-right" name="submit" style="display: block; width: 100%;">Send Email</button>
              <br>
          </form>
        </div>
        </div>
    </div>
  </body>
</html>
