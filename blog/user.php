<?php
	
	class User
	{
		//create member variables 
		private $id;
		private $email;
		private $password;
		private $salt;
		
		//the constructor for the user object
		public function __construct($newId,$newEmail,$newPassword,$newSalt)
		{
			try
			{
				$this->setId($newId);
				$this->setPassword($newPassword);
				$this->setEmail($newEmail);
				$this->setSalt($newSalt);
			}
			catch(Exception $exception)
			{
				throw(new Exception($exception));
			}	
		}
/************************************************************Accessors & Mutators*******************************************/
		//getters for the member variables
		public function getId()
		{
		    return $this->id;
		}
		
		public function getEmail()
		{
		    return $this->email;
		}
		
		public function getSalt()
		{
		    return $this->salt;   
		}	

		public function getPassword()
		{
		    return $this->password;
		}

		//setters of the member variables
		//along with sanitization
		public function setId($newId)
		{
		    if(is_numeric($newId) === false)
		    {
		    	throw(new Exception("User id Not Numberic "));
		    }
		    //convert to integer
		    $newId = intval($newId);

		    //throw out negative ID's
		    //except -1 which is our new user
		    if($newId < -1)
		    {
		    	throw(new Exception("User id below -1"));
		    }
		    //sanitized; assign the value
		    $this->id = $newId;
		}
		public function setEmail($email)
		{
			//trim the email
			$email = trim($email);
			
			//check to see if its a valid email
			if(strpos($email,"@") !== false)
			{
				//set the email
				$this->email = $email;
			}
			else
			{
				throw(new Exception("Invalid Email"));
			}
		}
		public function setPassword($password)
		{
			//trim the password input
			$password = trim($password);
			
			//conver to lower since we know it is a sha512
			$password = strtolower($password);
			
			//check against a  regular expression
			$regexp = "/^([\da-f]{128})$/";
			if((preg_match($regexp,$password)) !== 1)
			{
				throw(new Exception("Bad Password: $password"));
			}
			else
			{
				//set the password 
				$this->password = $password;	
			}
		}
		public function setSalt($salt)
		{
			//trim the salt
			$salt   = trim($salt);
			
			//convert to lower cause we know its a hash
			$salt   = strtolower($salt);
			
			//check against a regular expression
			$regexp = "/^([\da-f]{64})?$/";
			if(preg_match($regexp,$salt) !== 1)
			{
				throw (new Exception("Invalid Salt Detected"));
			}
			else
			{
				//set the salt
				$this->salt = $salt;	
			}
		}
/*******************************************************Insert, Delete & Update Methods*************************************/
		public function insert(&$mysqli)
		{
			// handle degenerate cases
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			// create a query template
			$query = "INSERT INTO User (email, password, salt) VALUES(?,?,?)";

			// prepare the query statement
			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}
			
			// bind parameters to the query template, takes user inputs and check them
			$bindTest = $statement->bind_param("sss",$this->email, $this->password, $this->salt);
			if($bindTest === false)
			{
				throw (new Exception("Statement did not Bind"));
			}
			
			//execute the statement, insert the object
			if($statement->execute() === false)
			{
				echo $statement->error;
				throw(new Exception("Statement did not Execute"));
			}
			
			//clean up the statement
			$statement->close();
			
			//set the object id to the same as it is in the database
			try
			{
				$this->setId($mysqli->insert_id);
			}
			catch(Exception $exception)
			{
				//rethrow if the id is bad
				throw(new Exception("Unable to determine user id", 0, $exception));
			}
		}
		
		public function update(&$mysqli)
		{
		   	// handle degenerate cases
		   	if (is_object($mysqli) === false   ||   get_class($mysqli) !== "mysqli")
		   	{
		   		throw(new Exception("Non mySQL pointer detected"));
		   	}
		   
		   	// verify the id is not -1 (i.e., an existing user)
		   	if($this->id === -1)
		   	{
		   		throw(new Exception("New id detected"));
		   	}
		   		
		   	// create a query template
		   	$query = "UPDATE User SET email = ?, password = ?, salt = ? WHERE id = ?";
		   	
		   	// prepare the query statement
		  	$statement = $mysqli->prepare($query);

		  	if($statement === false)
		  	{
		  	   	throw(new Exception("Unable to prepare statement."));
			}  
		  	   
		  	// bind parameters to the query template, takes user inputs and check them
		  	$wasClean = $statement->bind_param("sssi", $this->email, $this->password, $this->salt, $this->id);
		  	   
		  	if($wasClean === false)
		  	{
		  	   	throw(new Exception("Unable to bind parameters"));
		  	}
		  	
			//execute the statement, update the object
		  	if($statement->execute() === false)
		  	{
		  		echo $statement->error;
		  	   	throw(new Exception("Unable to execute statement."));
		  	}
		  	   
		  	// clean up the statement
		  	$statement->close();	 
		}
		
		public function delete(&$mysqli)
		{
			// handle degenerate cases
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception("Not an mysqli object"));
			}

			// verify the id is not -1 (i.e., an existing user)
			if($this->id === -1)
			{
				throw (new Exception("New Id detected"));
			}

			// create a query template
			$query = "DELETE FROM User WHERE id = ?";

			//prepare the statement
			$statement = $mysqli->prepare($query);
			if($statement === false)
			{
				throw(new Exception("Statement did not prepare"));
			}
			
			// bind parameters to the query template, takes user inputs and check them
			if($statement->bind_param("i",$this->id) === false)
			{
				throw(new Exception("Statement did not bind"));
			}
			
			//execute the statement, delete the object
			if($statement->execute() === false )
			{
				//echo $statement->error;
				throw(new Exception("Statement did not execute"));
			}
			$statement->close();
		}
		
/**********************************************************Static Functions*************************************************/
		public static function getUserByEmail(&$mysqli,$email)
		{
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			$query = "SELECT id, password, salt FROM User WHERE email = ?";

			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}

			$bindTest = $statement->bind_param("s",$email);

			if($bindTest === false)
			{
				throw (new Exception("Statement did not Bind"));
			}

			if($statement->execute() === false)
			{
				throw(new Exception("Statement did not Execute"));
			}

			$result = $statement->get_result();
			$row    = $result->fetch_assoc();
			$user = new User($row["ID"], $email, $row["password"], $row["salt"]);
			$statement->close();
			
			return($user);
		}

		public static function getUserById(&$mysqli,$id)
		{
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			$query = "SELECT email, password, salt FROM User WHERE id = ?";

			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}

			$bindTest = $statement->bind_param("i",$id);

			if($bindTest === false)
			{
				throw (new Exception("Statement did not Bind"));
			}

			if($statement->execute() === false)
			{
				throw(new Exception("Statement did not Execute"));
			}

			$result = $statement->get_result();
			$row    = $result->fetch_assoc();
		
			$user =new User($id,$row["email"],$row["password"],$row["salt"]);

			return($user);
		}		
	}
?>