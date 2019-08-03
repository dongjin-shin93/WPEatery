
<?php
	class Admin{
		private $lastLoginDate;
		private $adminId;

		function __construct($adminId, $lastLoginDate){
      $this->setAdminId($adminId);
			$this->setLastLoginDate($lastLoginDate);
		}

    public function getAdminId(){
			return $this->adminId;
		}
		public function setAdminId($adminId){
			$this->adminId = $adminId;
		}
		public function getLastLoginDate(){
			return $this->lastLoginDate;
		}
		public function setLastLoginDate($lastLoginDate){
			$this->lastLoginDate = $lastLoginDate;
		}
	}
?>
