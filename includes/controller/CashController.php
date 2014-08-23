<?php
class CashController {
	private $_salt = "Thieu Muoi";

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

		if (!isset($_POST['type']) || intval($_POST['type']) == 0)
			return;	
			
		if (!isset($_POST['t']) || intval($_POST['t']) == 0)
			return;		
			
		if (!isset($_POST['h']) || intval($_POST['h']) == 0)
			return;	

		$user_id = intval($_POST['user_id']);
		$token = $_POST['token'];
		$type = intval($_POST['type']);
		$t = intval($_POST['t']);
		$h = intval($_POST['h']);
			
		// Check User 
		$pUser = $this->getUserModel()->getUserByIdAndToken($user_id, $token);
		if ($pUser == null)
			return;			
			
		if ($this->checksum($user_id, $token, $type, $t, $h) == false)
			return;

		// Update Cash
		$pCash = new stdClass;
		$pCash->user_id = $user_id;
		$pCash->cash_type = $type;
		$pCash->cash_time = date("Y-m-d H:i:s", $t);
		$this->getCashModel()->insert($pCash);	
		
		// Update Token
		$user_token = $this->genToken();
		$pInfo = new stdClass;
		$pInfo->user_token = $user_token;
		$this->getUserModel()->update($pUser[0]->user_id, $pInfo);			
		
		$pRetObj->result = "true";	
		$pRetObj->token = $user_token;
		echo json_encode($pRetObj);			
		
	}
	
	public function checkSum($user_id, $token, $type, $t, $h) {
		if  (crc32($user_id . $token . $type . $t) == $h)
			return true;
			
		return false;
	}
}

?>