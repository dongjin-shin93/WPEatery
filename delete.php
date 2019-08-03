<?php include "header.php";
require_once('./dao/signUpCustomerDAO.php');
require_once('./model/customer.php');
require_once('./dao/adminDAO.php');
require_once('./model/admin.php');

  // Redirect if admin has not logged in
  if(!isset($_SESSION['AdminID'])){ $_SESSION['pageName'] = 'delete'; header('Location:userlogin.php'); }

  $signUpCustomerDAO = new signUpCustomerDAO();
  $hasError = false;
  $errorMessages = Array();
  if(isset($_POST['delete'])){
    if(isset($_POST['existingId'])) {
        if($_POST['existingId'] == ""){
            $hasError = true;
            $errorMessages['idError'] = 'Please enter the id';
        }
        // If there is no error on textfield
        if(!$hasError){
            $existingId = $_POST['existingId'];
            $deleteSuccess = $signUpCustomerDAO->deleteCustomer($existingId);
            echo '<h3>' . $deleteSuccess . '</h3>';
        }
     }
   }
?>

<!DOCTYPE html>
<html>
<div id="content" class="clearfix">
    <h3>Delete Existing ID</h3>
    <form name="deleteExistId" id="deleteExistId" method="post" action="delete.php">
      <table>
          <tr>
              <td>ID: </td>
              <td><input type="text" name="existingId" id="existingId" size='20'></td>

              <td><input type='submit' name='delete' id='delete' value='Delete'></td>

              <td>
                <?php
                  if(isset($errorMessages['idError'])){
                      echo '<span style=\'color:red\'>' . $errorMessages['idError'] . '</span>';
                  }
                ?>
              </td>
          </tr>
        </table>
    </form>
</div>
<?php include "footer.php"; ?>
</html>
