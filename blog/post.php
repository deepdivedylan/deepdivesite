<?php
	
	class Post
	{
		//create member variables 
		private $id;
		private $title;
		private $author;
		private $text;
                private $date;
		
		//the constructor for the post object
		public function __construct($newId,$newTitle,$newAuthor,$newText, $newDate)
		{
			try
			{
				$this->setId($newId);
				$this->setTitle($newTitle);
				$this->setEmail($newAuthor);
				$this->setSalt($newText);
                                $this->setDate($newDate);
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
                
                public function getTitle()
		{
		    return $this->title;
		}
		
		public function getAuthor()
		{
		    return $this->author;
		}
		
		public function getText()
		{
		    return $this->text;   
		}
                public function getDate()
                {
                    return $this->date;
                }

		//setters of the member variables
		//along with sanitization
		public function setId($newId)
		{
		    if(is_numeric($newId) === false)
		    {
		    	throw(new Exception("Post id Not Numberic "));
		    }
		    //convert to integer
		    $newId = intval($newId);

		    //throw out negative ID's
		    //except -1 which is our new post
		    if($newId < -1)
		    {
		    	throw(new Exception("Post id below -1"));
		    }
		    //sanitized; assign the value
		    $this->id = $newId;
		}
                
                public function setTitle($title)
		{
			//trim the title input
			$title = trim($title);
                        
                        //htmlspecialchars to santize input 
                        htmlspecialchars($title);
			
			//set the title 
			$this->title = $title;
		}
                
		public function setAuthor($author)
		{
			//trim the author input
			$author = trim($author);
			
                        //htmlspecialchars to santize input 
                        htmlspecialchars($author);
                        
                        //set the author
                        $this->author = $author;
		}
	    
		public function setText($text)
		{
			//trim the text
			$text   = trim($text);
                        
                        //strip tags to santize certain types of input
                        strip_tags($text, "<a><h1><h2><h3><h4><h5><h6><ul><ol><li><em><strong><img>");
                        
                        //put the <p> tags back in
                        str_ireplace("\n","</p>\n<p>", $text);
                        $text = "<p>$text</p>";
                        
                        //set the text
			$this->text = $text;
		}
                
                public function setDate($date)
		{                        
                        //set the date
                        $this->date = $date;
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
			$query = "INSERT INTO posts (title, author, text) VALUES(?,?,?)";

			// prepare the query statement
			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}
			
			// bind parameters to the query template, takes post inputs and check them
			$bindTest = $statement->bind_param("sss", $this->title, $this->author, $this->text);
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
				throw(new Exception("Unable to determine post id", 0, $exception));
			}
		}
		
		public function update(&$mysqli)
		{
		   	// handle degenerate cases
		   	if (is_object($mysqli) === false   ||   get_class($mysqli) !== "mysqli")
		   	{
		   		throw(new Exception("Non mySQL pointer detected"));
		   	}
		   
		   	// verify the id is not -1 (i.e., an existing post)
		   	if($this->id === -1)
		   	{
		   		throw(new Exception("New id detected"));
		   	}
		   		
		   	// create a query template
		   	$query = "UPDATE posts SET title = ?, author = ?, text = ? WHERE id = ?";
		   	
		   	// prepare the query statement
		  	$statement = $mysqli->prepare($query);

		  	if($statement === false)
		  	{
		  	   	throw(new Exception("Unable to prepare statement."));
			}  
		  	   
		  	// bind parameters to the query template, takes post inputs and check them
		  	$wasClean = $statement->bind_param("sssi", $this->title, $this->author, $this->text, $this->id);
		  	   
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

			// verify the id is not -1 (i.e., an existing post)
			if($this->id === -1)
			{
				throw (new Exception("New Id detected"));
			}

			// create a query template
			$query = "DELETE FROM posts WHERE id = ?";

			//prepare the statement
			$statement = $mysqli->prepare($query);
			if($statement === false)
			{
				throw(new Exception("Statement did not prepare"));
			}
			
			// bind parameters to the query template, takes post inputs and check them
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
		public static function getPostByTitle(&$mysqli,$title)
		{
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			$query = "SELECT id, author, text, date FROM posts WHERE title = ?";

			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}

			$bindTest = $statement->bind_param("s",$title);

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
			$post = new Post($row["id"], $title, $row["author"], $row["text"], $row["date"]);
			$statement->close();
			
			return($post);
		}

		public static function getPostById(&$mysqli,$id)
		{
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			$query = "SELECT title, author, text, date FROM posts WHERE id = ?";

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
		
			$post =new Post($id,$row["title"],$row["author"],$row["text"],$row["date"]);

			return($post);
		}
                
                public static function getTenPostsByDate(&$mysqli,$id)
		{
			if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
			{
				throw (new Exception ("not a mysqli object"));
			}

			$query = "SELECT id, author, text, date FROM posts ORDER BY date DESC LIMIT ?, 10";

			$statement = $mysqli->prepare($query);
			if ($statement === false)
			{
				throw(new Exception("Statement did not Prepare"));
			}

			$bindTest = $statement->bind_param("s",$title);

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
			$post = new Post($row["id"], $row["title"], $row["author"], $row["text"], $row["date"]);
			$statement->close();
			
			return($post);
		}
	}
?>