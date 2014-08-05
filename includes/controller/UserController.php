<?php
class UserController {

	public function genToken()
	{
		return md5(rand(1, 100000000));
	}

	private function getUserModel() {
		$getUserModel =  new UserModel();
		return $getUserModel;
	}		
	
	private function getTeamModel() {
		$getTeamModel =  new TeamModel();
		return $getTeamModel;
	}		
	
	public function login() {
		$pRetObject = new stdClass; 
		if (!isset($_POST["email"]) || !isset($_POST["password"]) || $_POST["email"]=="" || $_POST["password"]==""){
			$pRetObject->result = "false";
			$pRetObject->msg = "The email or password is invalid.";
			echo json_encode($pRetObject);
			return;		
		}
		
		$pUser = $this->getUserModel()->getUserByEmailAndPass($_POST["email"], $_POST["password"]);
		if ($pUser==null){
			$pRetObject->result = "false";
			$pRetObject->msg = "The email or password is invalid.";
			echo json_encode($pRetObject);
			return;		
		}
		
		$user_token = $this->genToken();
		$pInfo = new stdClass;
		$pInfo->user_token = $user_token;
		$this->getUserModel()->update($pUser[0]->user_id, $pInfo);		
		
		$pRetObject->result = "true";
		$objUser = new stdClass; 
		//$objUser->user_id = $pUser[0]->user_id;
		//$objUser->token = $user_token;
		//$objUser->cash = $pUser[0]->user_cash;
		$pUser[0]->user_token = $user_token;
		unset($pUser[0]->user_pass);
		unset($pUser[0]->user_reg_time);
		$pRetObject->user = $pUser[0];		
		echo json_encode($pRetObject);
	}
	
	public function register() {
	
		// Email
		$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		
		$pRetObject = new stdClass; 
		$pInfo = new stdClass; 
		if (!isset($_POST["email"])){
			$pRetObject->result = "false";
			$pRetObject->msg = "Email is null";
			echo json_encode($pRetObject);
			return;
		}
		if (preg_match($pattern, $_POST["email"]) !== 1) {
			$pRetObject->result = "false";
			$pRetObject->msg = "Email Address is invalid";
			echo json_encode($pRetObject);
			return;
		}		
		$pUser = $this->getUserModel()->getUserByEmail($_POST["email"]);
		if ($pUser != null){
			$pRetObject->result = "false";
			$pRetObject->msg = "This email is already registered";
			echo json_encode($pRetObject);
			return;			
		}
	
		$pInfo->user_email = $_POST["email"];
		
		// Pass
		if (!isset($_POST["password"]) || $_POST["password"]==""){
			$pRetObject->result = "false";
			$pRetObject->msg = "Password is null";
			echo json_encode($pRetObject);
			return;
		}	
		if (strlen($_POST["password"]) > 16){
			$pRetObject->result = "false";
			$pRetObject->msg = "Password is too long";
			echo json_encode($pRetObject);
			return;		
		}
		$pInfo->user_pass = $_POST["password"];
		
		// User Name
		if (!isset($_POST["name"]) || $_POST["name"]==""){
			$pRetObject->result = "false";
			$pRetObject->msg = "Name is null";
			echo json_encode($pRetObject);
			return;
		}	
		if (strlen($_POST["name"]) > 16){
			$pRetObject->result = "false";
			$pRetObject->msg = "Name is too long";
			echo json_encode($pRetObject);
			return;		
		}
		$pInfo->user_name = $_POST["name"];		
		
		// Favourite Team
		if (!isset($_POST["teamid"]) || intval($_POST["teamid"]) == 0){
			$pRetObject->result = "false";
			$pRetObject->msg = "Favourite Team is null";
			echo json_encode($pRetObject);
			return;
		}	
		$pTeam = $this->getTeamModel()->getTeamById(intval($_POST["teamid"]));
		if ($pTeam == null){
			$pRetObject->result = "false";
			$pRetObject->msg = "This team is not exist";
			echo json_encode($pRetObject);
			return;		
		}
		$pInfo->team_id = $_POST["teamid"];			
		
		// country
		if (isset($_POST["country"])){
			$pInfo->user_country = $_POST["country"];
		}
		
		// birthday
		if (isset($_POST["birthday"])){
			$pInfo->user_birthday = $_POST["birthday"];
		}
		
		// avatar
		if (isset($_POST["avatar"])){
			$szAvatarData = $_POST["avatar"];
		}
		
		$pInfo->user_reg_time = date('Y-m-d');
		$pInfo->user_cash = 500;
		
		// Insert User
		$user_id = $this->getUserModel()->insert($pInfo);
		$pInfo = new stdClass;
		$pInfo->user_token = $this->genToken();
		$this->getUserModel()->update($user_id, $pInfo);
		
		// Return
		$pRetObject->result = "true";
		$pUser = new stdClass; 
		$pUser->user_id = $user_id;
		$pUser->token = $pInfo->user_token;
		$pUser->cash = 500;
		$pRetObject->user = $pUser;		
		echo json_encode($pRetObject);
	}	
}

?>