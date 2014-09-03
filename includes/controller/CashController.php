<?php
class CashController {
	private $_salt = "salt.bbfootball.20140824";

	public function genToken(){
		return md5(rand(1, 100000000));
	}	
	
	private function getUserModel() {
		$getUserModel =  new UserModel();
		return $getUserModel;
	}
	
	private function getCashModel() {
		$getCashModel =  new CashModel();
		return $getCashModel;
	}			
	
	public function purchase(){
		if (!isset($_POST['user_id']) || intval($_POST['user_id']) == 0)
			return;

		if (!isset($_POST['token']) || $_POST['token'] == "")
			return;			

		if (!isset($_POST['type']))
			return;	
			
		if (!isset($_POST['h']))
			return;	

		$user_id = intval($_POST['user_id']);
		$token = $_POST['token'];
		$type = intval($_POST['type']);
		$h =  strtolower ($_POST['h']);
			

		// Check User 
		$pUser = $this->getUserModel()->getUserByIdAndToken($user_id, $token);
		if ($pUser == null)
			return;
			
		if ($this->checksum($user_id, $token, $type, $h) == false)
			return;

		// Update Cash
		$pCash = new stdClass;
		$pCash->user_id = $user_id;
		$pCash->cash_type = $type;
		$pCash->cash_time = date("Y-m-d H:i:s");
		$this->getCashModel()->insert($pCash);	
		
		// Update Token
		$lsCash = array(500,2000,5000,10000);
		$user_token = $this->genToken();
		$pInfo = new stdClass;
		$pInfo->user_token = $user_token;
		$pInfo->user_cash += $lsCash[$type];
		$this->getUserModel()->update($pUser[0]->user_id, $pInfo);			
		
		$pRetObj = new stdClass;
		$pRetObj->result = "true";	
		$pRetObj->token = $user_token;
		echo json_encode($pRetObj);			
	}
	
	public function checkSum($user_id, $token, $type, $h) {
		if  (MD5($user_id . $token . $type . $this->_salt) == $h)
			return true;
			
		return false;
	}
}

?>