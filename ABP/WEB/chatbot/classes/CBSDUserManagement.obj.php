<?php

	class CBSDUserManagement
	{

		private $mysqli, $stmt;
		private $sessionName = "CBSDUserManagement";
		public $logged_in = false;


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

			$this->mysqli = new mysqli($GLOBALS["mysql_hostname"], $GLOBALS["mysql_username"], $GLOBALS["mysql_password"], $GLOBALS["mysql_database"]);
			if( $this->mysqli->connect_error )
				throw new Exception("MySQL connection could not be established: ".$this->mysqli->connect_error);

			$this->_validateUser();
			$this->_updateActivity();
		}
		// User Management

		public function createUser($user)
		{
			$user->Salt  = $this->_generateSalt();
			$password = $user->Salt.$user->Password;
			$user->Password = sha1($password);
			$user->save();
		}
		public function loginUser( $username, $password )
		{
			$sql = "SELECT * FROM users WHERE Username='$username' AND SHA1(CONCAT(uSalt, '$password'))=Password LIMIT 1";
			$user = User::sql($sql);

			$_SESSION[$this->sessionName]["Id"] = $user->Id;
			$_SESSION[$this->sessionName]["user"] = $user->Username;
			$this->logged_in = true;

			return $user->Id;
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
		public function getUser( $userId = null )
		{

			if( $userId == null )
				$userId = $_SESSION[$this->sessionName]["userId"];

			$user = User::retrieveByPK($userId);
			return $user;

		}
		public function updateUser($userId,$username, $email, $firstname, $lastname,$botname,$botdesc,$botactive,$password)
		{
			if( $userId == null )
				$userId = $_SESSION[$this->sessionName]["userId"];

				$user = User::retrieveByPK($userId);

			$salt = $this->_generateSalt();
			$password = $salt.$password;
			$user->Salt = $salt;
			$user->Password = $password;
			$user->Username = $username;
			$user->Email = $email;
			$user->FirstName = $firstname;
			$user->LastName = $lastname;
			$user->BotName = $botname;
			$user->BotDescription = $botdesc;
			$user->BotActive = $botactive;

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



		private function _updateActivity()
		{
			if( !$this->logged_in )
				return;

			$userId = $_SESSION[$this->sessionName]["Id"];

			$sql = "UPDATE users SET Activity=NOW() WHERE Id=? LIMIT 1";
			if( !$this->stmt = $this->mysqli->prepare($sql) )
				throw new Exception("MySQL Prepare statement failed: ".$this->mysqli->error);

			$this->stmt->bind_param("i", $userId);
			$this->stmt->execute();
			return;
		}
		private function _validateUser()
		{
			if( !isset($_SESSION[$this->sessionName]["Id"]) )
				return;

			if( !$this->_validateUserId() )
				return;

			$this->logged_in = true;
		}
		private function _validateUserId()
		{
			$userId = $_SESSION[$this->sessionName]["Id"];

			$sql = "SELECT userId FROM users WHERE Id=? LIMIT 1";
			if( !$this->stmt = $this->mysqli->prepare($sql) )
				throw new Exception("MySQL Prepare statement failed: ".$this->mysqli->error);

			$this->stmt->bind_param("i", $userId);
			$this->stmt->execute();
			$this->stmt->store_result();

			if( $this->stmt->num_rows == 1)
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