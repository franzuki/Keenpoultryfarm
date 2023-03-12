<?php
function sendemail($email){
$to = $Remail;
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: keenpoultryfarming@gmail.com" . "\r\n";

mail($to,$subject,$txt,$headers);
}
?>