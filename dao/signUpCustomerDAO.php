<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');

class signUpCustomerDAO extends abstractDAO {

    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function getCustomers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailinglist');
        $mailingList = Array();

        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new customer object, and add it to the array.
                $customer = new Customer($row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $mailingList[] = $customer;
            }
            $result->free();
            return $mailingList;
        }
        $result->free();
        return false;
    }

    public function addCustomer($customer){
        if(!$this->mysqli->connect_errno){
            $query = 'INSERT INTO mailinglist (customerName, phoneNumber, emailAddress, referrer) VALUES (?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);

            $customerName = $customer->getCustomerName();
            $phoneNumber = $customer->getPhoneNumber();
            $emailAddress = $customer->getEmailAddress();
            $referrer = $customer->getReferrer();
            $stmt->bind_param('ssss', $customerName, $phoneNumber, $emailAddress, $referrer);

            $stmt->execute();
            if($stmt->error){
                return $stmt->error;
            } else {
                return $customer->getCustomerName() . ' added successfully!';
            }
        }else{
            return 'Could not connect to Database.';
        }
    }

    public function deleteCustomer($existingId){
      if(!$this->mysqli->connect_errno){
          $query = 'DELETE FROM mailinglist WHERE _id = ?';
          $stmt = $this->mysqli->prepare($query);

          $stmt->bind_param('i', $existingId);
          $stmt->execute();
          if(!$stmt->error){
              if($this->mysqli->affected_rows == 1){
                  return 'User Id ' . $existingId . ' deleted successfully!';
              }else{
                  return 'Delete Fail';
              }
          }
      }else{
          return 'Could not connect to Database.';
      }
    }
}

?>
