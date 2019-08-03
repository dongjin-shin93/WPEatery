<?php
  require_once('./dao/signUpCustomerDAO.php');
?>

<!DOCTYPE html>
<html>
<?php include "header.php"; ?>
            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>

                    <?php
                      try {
                        $signUpCustomerDAO = new signUpCustomerDAO();
                        $hasError = false;
                        $errorMessages = Array();
                        if(isset($_POST['btnSubmit'])){
                          if( isset($_POST['customerName']) ||
                              isset($_POST['phoneNumber']) ||
                              isset($_POST['emailAddress']) ||
                              isset($_POST['referral'])
                            )
                          {
                              if($_POST['customerName'] == ""){
                                  $hasError = true;
                                  $errorMessages['customerNameError'] = 'Please enter the name.';
                              }

                              if($_POST['phoneNumber'] == ""){
                                  $errorMessages['phoneNumberError'] = "Please enter the phone number.";
                                  $hasError = true;
                              }

                              if($_POST['emailAddress'] == ""){
                                  $errorMessages['emailAddressError'] = "Please enter the email.";
                                  $hasError = true;
                              }

                              if(empty($_POST['referral'])){
                                  $errorMessages['referralError'] = "Please select the referral.";
                                  $hasError = true;
                              }
                              // IF THERE IS NO ERROR
                              if(!$hasError){
                                  $email = $_POST['emailAddress'];
                                  $hash = password_hash($email, PASSWORD_DEFAULT);
                                  $customer = new Customer($_POST['customerName'], $_POST['phoneNumber'], $hash, $_POST['referral']);
                                  $addSuccess = $signUpCustomerDAO->addCustomer($customer);
                                  echo '<h3>' . $addSuccess . '</h3>';
                              }

                              // FOR FILE UPLOAD
                              $target_path = "files/";
                              $target_path = $target_path . basename( $_FILES['myfile']['name']);
                              if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
                                 $fileUploaded = "The file ".  basename( $_FILES['myfile']['name']). " has been uploaded";
                                 echo "<h3>$fileUploaded</h3>";
                              } else{
                                 echo "<h3>There was an error uploading the file, please try again!</h3>";
                              }
                          }
                      } // END OF ISSET()[$_POST['btnSubmit']]
                    ?>

                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40'></td>
                                <td>
                                  <?php
                                  //If there was an error with the name field, display the message
                                  if(isset($errorMessages['customerNameError'])){
                                          echo '<span style=\'color:red\'>' . $errorMessages['customerNameError'] . '</span>';
                                        }
                                  ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'></td>
                                <td>
                                  <?php
                                  //If there was an error with the phone number field, display the message
                                  if(isset($errorMessages['phoneNumberError'])){
                                          echo '<span style=\'color:red\'>' . $errorMessages['phoneNumberError'] . '</span>';
                                        }
                                  ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40'></td>
                                <td>
                                  <?php
                                  //If there was an error with the phone number field, display the message
                                  if(isset($errorMessages['emailAddressError'])){
                                          echo '<span style=\'color:red\'>' . $errorMessages['emailAddressError'] . '</span>';
                                        }
                                  ?>
                                </td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
                                    Radio<input type="radio" name="referral" id='referralRadio' value='radio'>
                                    TV<input type="radio" name="referral" id='referralTV' value='TV'>
                                    Other<input type="radio" name="referral" id='referralOther' value='other'></td>
                                    <td>
                                    <?php
                                    //If there was an error with the phone number field, display the message
                                    if(isset($errorMessages['referralError'])){
                                            echo '<span style=\'color:red\'>' . $errorMessages['referralError'] . '</span>';
                                          }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Choose a file to upload</td>
                                <td><input type="file" name="myfile" value=""></td>
                            </tr>

                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>

                        <?php
                          } catch (Exception $e) {
                              echo '<h3>Error on page.</h3>';
                              echo '<p>' . $e->getMessage() . '</p>';
                          }

                        ?>
                    </form>

                </div><!-- End Main -->
            </div><!-- End Content -->
            <?php include "footer.php"; ?>
</html>
