<?php

	class CBSDUserManagement
	{

		private $stmt;
		private $sessionName = "CBSDUserManagement";
		public $logged_in = false;
		public $current_userid;

		/**
		* Object construct verifies that a session has been started and that a MySQL connection can be established.
		* It takes no parameters.
		*
		* @exception	Exception	If a session id can't be returned.
		*/

		public function __construct()
		{
			$sessionId = session_id();
			if( strlen($sessionId) == 0)
				throw new Exception("No session has been started.\n<br />Please add `session_start();` initially in your file before any output.");

			DataMappingManager::initializeMapper();

			$this->_validateUser();

		}
		// User Management

		public function createUser($username, $email, $firstname, $lastname,$botname,$password)
		{
			$user =new User;


			$salt = $this->_generateSalt();
			$password = $salt.$password;
			$user->Salt = $salt;
			$user->Password = sha1($password);
			$user->Username = $username;
			$user->Email = $email;
			$user->FirstName = $firstname;
			$user->LastName = $lastname;
			$user->BotName = $botname;
			$user->Role=0;
			$user->BotScore=0;
			$user->BotActive=true;

			$user->save();

			return $user->Id;
		}

		public function loginUser( $username, $password )
		{
			$sql = "SELECT * FROM users WHERE Username='$username' AND SHA1(CONCAT(Salt, '$password'))=Password LIMIT 1";
			$user = User::sql($sql);
			if(count($user) == 1) {
				$_SESSION[$this->sessionName]["Id"] = $user[0]->Id;
				$_SESSION[$this->sessionName]["user"] = $user[0]->Username;
				$this->current_userid = intval($_SESSION[$this->sessionName]["Id"]);
				$this->logged_in = true;

				return $user[0]->Id;
			}
			return null;
		}
		public function searchBot($sbotname)
		{
			return User::sql("SELECT * FROM users WHERE BotName LIKE \"%$sbotname%\"");
		}
		public function logoutUser()
		{
			if( isset($_SESSION[$this->sessionName]) )
				unset($_SESSION[$this->sessionName]);

			$this->logged_in = false;
		}
    	public function setPassword( $password, $userId = null )
		{
			if( $userId == null )
				$userId = $_SESSION[$this->sessionName]["Id"];

			$user  = User::retrieveByPK($userId);
			$user->Salt = $this->_generateSalt();
			$password = $user->Salt.$password;

			$user->Password = sha1($password);
			$user->save();
		}
		public function getUsers()
		{
			return User::All();
		}
		public function getLeaderboard()
		{
			$sql = "SELECT * FROM users WHERE ORDER BY BotScore DESC LIMIT 3";
			return User::sql($sql);
		}
		public function getUser( $userId = null )
		{

			if( $userId == null )
				$userId = $_SESSION[$this->sessionName]["Id"];

			$user = User::retrieveByPK($userId);
			return $user;

		}
		public function updateUser($userId,$username, $email, $firstname, $lastname,$botname,$botdesc,$password)
		{
			if( $userId == null )
				$userId = $_SESSION[$this->sessionName]["Id"];

				$user = User::retrieveByPK($userId);

			$salt = $this->_generateSalt();
			$password = $salt.$password;
			$user->Salt = $salt;
			$user->Password = sha1($password);
			$user->Username = $username;
			$user->Email = $email;
			$user->FirstName = $firstname;
			$user->LastName = $lastname;
			$user->BotName = $botname;
			$user->BotDescription = $botdesc;

			$user->save();
		}
		public function getToken( $xhtml = true )
		{
			$token = $this->_generateSalt();
			$name = "token_".md5($token);
			
			$_SESSION[$this->sessionName]["csrf_name"] = $name;
			$_SESSION[$this->sessionName]["csrf_token"] = $token;
			
			$string = "<input type=\"hidden\" name=\"".$name."\" value=\"".$token."\"";
			if($xhtml)
				$string .= " />";
			else
				$string .= ">";
			
			return $string;
		}		
		public function validateToken()
		{
			$name = $_SESSION[$this->sessionName]["csrf_name"];
			$token = $_SESSION[$this->sessionName]["csrf_token"];
			unset($_SESSION[$this->sessionName]["csrf_token"]);
			unset($_SESSION[$this->sessionName]["csrf_name"]);
			
			if($_POST[$name] == $token)
				return true;
				
			return false;
		}

		public function setBotState($id, $state)
		{
			$user = User::retrieveByPK($id);
			$user->BotActive = $state;
			$user->save();
		}
		// Bot Settings Management
		public function addAimlSet($bid, $aimlfile)
		{
				$aimlset = new AimlSet;
			$aimlset->AimlFile = $aimlfile;
			$aimlset->BotId = $bid;
			$aimlset->save();
		}
		public function addPersonality($bid, $personalityfile)
		{
			$perso = new Personality;
			$perso->PersonalityFile = $personalityfile;
			$perso->BotId = $bid;
			$perso->save();
		}
		public function removeAimlSet($id)
		{
			$aimlset = AimlSet::retrieveByPK($id);
			$aimlset->delete();
		}
		public function removePersonality($id)
		{
			$aimlset = Personality::retrieveByPK($id);
			$aimlset->delete();
		}
		public function getAllAimlSets($uid)
		{
			$sql = "SELECT * FROM aimlsets WHERE BotId = ".$uid;
			return AimlSet::sql($sql);
		}
		public function getAllPersonalities($uid)
		{
			$sql = "SELECT * FROM personalities WHERE BotId = ".$uid;
			return Personality::sql($sql);
		}




		private function _validateUser()
		{
			if( !isset($_SESSION[$this->sessionName]["Id"]) )
				return;

			if( !$this->_validateUserId() )
				return;
			$this->current_userid = intval($_SESSION[$this->sessionName]["Id"]);
			$this->logged_in = true;
		}
		private function _validateUserId()
		{
			$userId = $_SESSION[$this->sessionName]["Id"];

			$sql = "SELECT * FROM users WHERE Id=".$userId." LIMIT 1";
			$users = User::sql($sql);

			if( count($users))
				return true;

			$this->logoutUser();

			return false;
		}
		private function _generateSalt()
		{
			$salt = null;

			while( strlen($salt) < 128 )
				$salt = $salt.uniqid(null, true);

			return substr($salt, 0, 128);
		}

	}
	
?>