<?php namespace Ds3\Legacy; ?><?php
if(isset($_POST['submit'])) {
   $to = 'dryatros@gmail.com' ;     //put your email address on which you want to receive the information
   $subject = 'Contact Form Submission - DSS Site';   //set the subject of email.
   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   $message = "<table><tr><td>First Name:</td><td>".$_POST['textfield']."</td></tr>
               <tr><td>Last Name:</td><td>".$_POST['textfield2']."</td></tr>
               <tr><td>Address 1:</td><td>".$_POST['textfield3']."</td></tr>
               <tr><td>Address 2:</td><td>".$_POST['textfield32']."</td></tr>
               <tr><td>Email:</td><td>".$_POST['textfield4']."</td></tr>
               <tr><td>Number 1:</td><td>".$_POST['textfield5']."</td></tr>
               <tr><td>Number 2:</td><td>".$_POST['textfield52']."</td></tr>
               <tr><td>Message:</td><td>".$_POST['textarea']."</td></tr>
               <tr><td>Reffered by:</td><td>".$_POST['textfield6']."</td></tr>
               <tr><td>Message</td><td>".$_POST['message']."</td>
               </tr></table>" ;
   mail($to, $subject, $message, $headers);
   header('Location: http://dentalsleepsolutions.com/pages.php?pid=12  ');
}
?>
