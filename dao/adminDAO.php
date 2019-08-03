<?php
require_once('abstractDAO.php');
require_once('./model/admin.php');

class adminDAO extends abstractDAO {

    protected $username;
    protected $password;
    protected $mysqli;
    protected $dbError;
    protected $authenticated = false;

    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function authenticate($username, $password){
        $loginQuery = "SELECT * FROM adminusers WHERE Username = ? AND Password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $this->username = $username;
            $this->password = $password;
            $this->authenticated = true;
        }
        $stmt->free_result();
    }
    public function isAuthenticated(){
        return $this->authenticated;
    }

    public function getAdminId($username){
      $getAdminIdQuery = "SELECT AdminID FROM adminusers WHERE Username = ?";
      $stmt = $this->mysqli->prepare($getAdminIdQuery);
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return $row["AdminID"];
      }
      $stmt->free_result();
    }

    public function updateLastLoginDate($username){
        $today = date("Y-m-d");
        $this->username = $username;
        $updateLoginQuery = "UPDATE adminusers SET Lastlogin='$today' WHERE Username='$username'";
        $stmt = $this->mysqli->prepare($updateLoginQuery);
        $stmt->execute();
    }
}
?>
