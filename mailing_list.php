<?php include "header.php";
require_once('./dao/signUpCustomerDAO.php');
require_once('./model/customer.php');
require_once('./dao/adminDAO.php');
require_once('./model/admin.php');

if(!isset($_SESSION['AdminID'])){
  $_SESSION['pageName'] = 'list';
  header('Location:userlogin.php');
}
?>

<!DOCTYPE html>
<html>
<div id="content" class="clearfix">
    <?php
      echo '<p>Session ID: ' . session_id() . '</p>';
      echo '<p>Session AdminID: ' . $_SESSION['AdminID'] . '</p>';
      echo '<p>Last Login Date: ' . $_SESSION['lastLoginDate'] . '</p>';
    ?>
    <table align="center" width=100%>
    <tr><th>Name</th><th>Phone Number</th><th>Email Address</th></tr>
  <?php
  $signUpCustomerDAO = new signUpCustomerDAO();

  $mailingList = $signUpCustomerDAO->getCustomers();
      if($mailingList){
          foreach($mailingList as $customer){
              echo '<tr align="center">';
              echo '<td>' . $customer->getCustomerName() .'</td>';
              echo '<td>' . $customer->getPhoneNumber() . '</td>';
              echo '<td>' . $customer->getEmailAddress() . '</td>';
              echo '</tr>';
          }
      }else{
        echo "No record Found";
      }
    ?>
  </table>
</div>
<?php include "footer.php"; ?>
</html>
