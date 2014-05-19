<?php
require_once("../../config.php");
require_once("recaptchalib.php");

/* posts application data to mySQL
 * @param  pointer to mySQL connection
 * @throws if an SQL or input validation error occurs */
function postApplicationToMySQL(&$mysqli)
{
	$query = "INSERT INTO application(classId, aboutYourself, whyAttend, otherLinks, progExperience, fullName, phoneNumber, emailAddress, howHeard, skype, google, gender, birthday, browser, ipAddress) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	/* prepare query */
	$statement = $mysqli->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysqli->error));
	}

	/* reformat IP address */
	$ipAddress = inet_pton($_SERVER["REMOTE_ADDR"]);
	if($ipAddress === false)
	{
		throw(new Exception("Unable to prepare mySQL query: invalid IP address"));
	}

	/* verify & normalize the date */
	$birthday = null;
	try
	{
		$date     = new DateTime($_POST["birthday"]);
		$birthday = $date->format("Y-m-d");
	}
	catch(Exception $e)
	{
		throw(new Exception("Unable to prepare mySQL query: invalid birthday", 0, $e));
	}

	/* bind parameters to the prepared statement */
	$statement->bind_param("isssssssssssssi",
								htmlspecialchars($_POST["classId"]),
								htmlspecialchars($_POST["aboutYourself"]),
								htmlspecialchars($_POST["whyAttend"]),
								htmlspecialchars($_POST["otherLinks"]),
								htmlspecialchars($_POST["progExperience"]),
								htmlspecialchars($_POST["fullName"]),
								htmlspecialchars($_POST["phoneNumber"]),
								htmlspecialchars($_POST["emailAddress"]),
								htmlspecialchars($_POST["howHeard"]),
								htmlspecialchars($_POST["skype"]),
								htmlspecialchars($_POST["google"]),
								htmlspecialchars($_POST["gender"]),
								$birthday,
								htmlspecialchars($_SERVER["HTTP_USER_AGENT"]),
								$ipAddress);

	/* execute mySQL query */
	if($statement->execute() === false)
	{
		throw(new Exception("Unable to query mySQL: " . $statement->error));
	}

	/* affected_rows != 1 implies the data wasn't able to be inserted */
	if($statement->affected_rows !== 1)
	{
		throw(new Exception("Unable to query mySQL: " . $statement->error));
	}
}

/* emails an HTML formatted message with the application
 * @param  pointer to mySQL connection
 * @throws if an SQL or input validation error occurs */
function emailApplicationResults(&$mysqli)
{
	/* set static variables */
	$destinationEmail = Pointer::getDestinationEmail();
	$class            = getClassName($mysqli, $_POST["classId"]);
	$subject          = "Application from " . $_POST["fullName"];
	$from             = "Apache Web Server <" . strip_tags($_SERVER["SERVER_ADMIN"]) . ">";

	/* build Email headers */
	$headers  = "From: $from\r\n";
	$headers .= "Reply-To: $from\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	/* set the preamble of the message */
	$preamble  = "<html>\r\n<body>\r\n";
	$preamble .= "<h1>Application From " . $_POST["fullName"] . "</h1>\r\n";
	$preamble .= "<table border=\"3\">\r\n";
	$preamble .= "<tr><th>Field</th><th>Answer</th>\r\n";

	/* build the table of values */
	$message  = "<tr><td>Class</td><td>$class</td></tr>\r\n";
	$message .= "<tr><td>Full Name</td><td>" . $_POST["fullName"] . "</td></tr>\r\n";
	$message .= "<tr><td>Phone Number</td><td>" . $_POST["phoneNumber"] . "</td></tr>\r\n";
	$message .= "<tr><td>Email Address</td><td>" . $_POST["emailAddress"] . "</td></tr>\r\n";
	$message .= "<tr><td>Gender</td><td>" . $_POST["gender"] . "</td></tr>\r\n";
	$message .= "<tr><td>Birthday</td><td>" . $_POST["birthday"] . "</td></tr>\r\n";
	$message .= "<tr><td>About Yourself</td><td>" . $_POST["aboutYourself"] . "</td></tr>\r\n";
	$message .= "<tr><td>Why Attend?</td><td>" . $_POST["whyAttend"] . "</td></tr>\r\n";
	$message .= "<tr><td>Other Links?</td><td>" . $_POST["otherLinks"] . "</td></tr>\r\n";
	$message .= "<tr><td>Programming Experience</td><td>" . $_POST["progExperience"] . "</td></tr>\r\n";
	$message .= "<tr><td>Google ID</td><td>" . $_POST["google"] . "</td></tr>\r\n";
	$message .= "<tr><td>Skype ID</td><td>" . $_POST["skype"] . "</td></tr>\r\n";
	$message .= "<tr><td>How Did You Hear About Us?</td><td>" . $_POST["howHeard"] . "</td></tr>\r\n";
	$message .= "<tr><td>Browser</td><td>" . $_SERVER["HTTP_USER_AGENT"] . "</td></tr>\r\n";
	$message .= "<tr><td>IP</td><td>" . $_SERVER["REMOTE_ADDR"] . "</td></tr>\r\n";

	/* close the table & message */
	$postamble  = "</table>\r\n";
	$postamble .= "</body>\r\n";
	$postamble .= "</html>";

	/* Email the message */
	$message = $preamble . $message . $postamble;
	mail($destinationEmail, $subject, $message, $headers);
}

/* gets a list of all available classes
 * @param   pointer to mySQL connection
 * @returns array of available classes
 * @throws  if an SQL or input validation error occurs */
function getClassList(&$mysqli)
{
	/* prepare query */
	$query = "SELECT id, className, startDate FROM classes WHERE startDate > DATE_ADD(NOW(), INTERVAL 1 WEEK)";
	$statement = $mysqli->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysqli->error));
	}

	try
	{
		$statement->execute();
	}
	catch(mysqli_sql_exception $exception)
	{
		// ignore the "No index used..." exception since it's just a minor warning
		if(strpos($exception->getMessage(), "No index used in query/prepared statement") === false)
		{
			throw(new Exception("Statement did not Execute", 0, $exception));
		}
	}

	$classes = array();
	$result = $statement->get_result();
	while(($row = $result->fetch_assoc()) !== null)
	{
		/* verify & normalize the date */
		$classDate = null;
		try
		{
			$date      = new DateTime($row["startDate"]);
			$classDate = $date->format("m/d/Y");
		}
		catch(Exception $e)
		{
			throw(new Exception("Unable to format start date: invalid start date", 0, $e));
		}

		$class = $row["className"] . " ($classDate)";
		$classes[$row["id"]] = $class;
	}
	return($classes);
}

/* gets a human readable name of a class
 * @param   pointer to mySQL connection
 * @param   class ID to query
 * @returns string containing class name
 * @throws  if an SQL or input validation error occurs */
function getClassName(&$mysqli, $classId)
{
	/* prepare query */
	$query = "SELECT className, startDate FROM classes WHERE id = ?";
	$statement = $mysqli->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysqli->error));
	}

	/* bind parameters to the prepared statement */
	$statement->bind_param("i", $classId);

	/* execute mySQL query */
	if($statement->execute() === false)
	{
		throw(new Exception("Unable to query mySQL: " . $statement->error));
	}

	$result = $statement->get_result();
	$row    = $statement->fetch_assoc();
	/* verify & normalize the date */
	$classDate = null;
	try
	{
		$date      = new DateTime($row["startDate"]);
		$classDate = $date->format("m/d/Y");
	}
	catch(Exception $e)
	{
		throw(new Exception("Unable to format start date: invalid start date", 0, $e));
	}
	$class = $row["className"] . " ($classDate)";
	return($class);
}

/* verifies whether the captcha is valid
 * @throws if the captcha is invalid */
function verifyCaptcha()
{
	$privateKey = Pointer::getCaptchaKey();
	$captcha    = recaptcha_check_answer ($privateKey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

	if (!$captcha->is_valid)
	{
		/* if the captcha was entered incorrectly, display an error */
		throw(new Exception("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $captcha->error . ")"));
	}
}
?>
