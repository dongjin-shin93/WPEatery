<?php include "header.php";
require_once('./dao/adminDAO.php');

$missingFields = false;
try{
    if(isset($_POST['submit'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            if($_POST['username'] == "" || $_POST['password'] == ""){
                $missingFields = true;
            } else {

                  //All fields set, fields have a value
                  $adminDAO = new adminDAO();
                      $username = $_POST['username'];
                      $password = $_POST['password'];
                      $adminDAO->authenticate($username, $password);

                      if($adminDAO->isAuthenticated()){
                        // Retrieve admin id using dao
                        $adminId = $adminDAO->getAdminId($username);
                        $adminDAO->updateLastLoginDate($username);
                        // Set admin id in session variable
                        $_SESSION['AdminID'] = $adminId;
                        // Set last login date in session
                        // Time zone set as America/Toronto
                        date_default_timezone_set("America/Toronto");
                        $_SESSION['lastLoginDate'] = date("Y-m-d");
                        // Set session to determine where user was coming from and redirect to where he was
                        if($_SESSION['pageName']=='list') { header('Location:mailing_list.php'); }
                        elseif ($_SESSION['pageName']=='delete') { header('Location:delete.php'); }
                      }
              }
          }
    }
?>

<!DOCTYPE html>
<html>
  <div id="content" class="clearfix">
    <div class="main">
        <!-- MESSAGES -->
        <?php
            //Missing username/password
            if($missingFields){
                echo '<h3 style="color:red;">Please enter both a username and a password</h3>';
            }
            //Authentication failed
            if(isset($adminDAO)){
                if(!$adminDAO->isAuthenticated()){
                    echo '<h3 style="color:red;">Login failed. Please try again.</h3>';
                }
            }
        ?>

        <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" id="submit" value="Login"></td>
            </tr>
        </table>
        <?php
          } catch (Exception $e) {
              echo '<h3>Error on page.</h3>';
              echo '<p>' . $e->getMessage() . '</p>';
          }
        ?>

        </form>
    </div>
  </div>
<?php include "footer.php"; ?>
</html>
