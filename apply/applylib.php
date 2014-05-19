<?php
require_once("../../application.inc");
require_once("aes.php");
require_once("recaptchalib.php");

/* connects to mySQL pointed to by the application.inc file
 * @returns pointer to the mySQL connection
 * @throws  if the connection cannot be established */
function connectToMySQL()
{
	/* register globals */
	global $AES256_KEY;
	global $MYSQL_HOSTNAME;
	global $MYSQL_USERNAME;
	global $MYSQL_PASSWORD;
	global $MYSQL_DATABASE;
	
	/* decrypt the password & connect */
	$aes      = new AES($AES256_KEY);
	$password = $aes->decrypt($MYSQL_PASSWORD);
	$mysql    = new mysqli($MYSQL_HOSTNAME, $MYSQL_USERNAME, $password, $MYSQL_DATABASE);
	
	if($mysql->connect_error)
	{
		throw(new Exception("Unable to connect to mySQL: " . $mysql->connect_error));
	}
	
	return($mysql);
}

/* posts application data to mySQL
 * @param  pointer to mySQL connection
 * @throws if an SQL or input validation error occurs */
function postApplicationToMySQL($mysql)
{
	$query = "INSERT INTO application(classId, aboutYourself, whyAttend, otherLinks, progExperience, fullName, phoneNumber, emailAddress, howHeard, skype, google, gender, birthday, browser, ipAddress) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
	/* prepare query */
	$statement = $mysql->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysql->error));
	}
	
	/* reformat IP address */
	$ipAddress = ip2long($_SERVER["REMOTE_ADDR"]);
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
								$_POST["classId"],
								$_POST["aboutYourself"],
								$_POST["whyAttend"],
								$_POST["otherLinks"],
								$_POST["progExperience"],
								$_POST["fullName"],
								$_POST["phoneNumber"],
								$_POST["emailAddress"],
								$_POST["howHeard"],
								$_POST["skype"],
								$_POST["google"],
								$_POST["gender"],
								$birthday,
								$_SERVER["HTTP_USER_AGENT"],
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
function emailApplicationResults($mysql)
{
	global $DEST_EMAIL;
	
	/* set static variables */
	$class   = getClassName($mysql, $_POST["classId"]);
	$subject = "Application from " . $_POST["fullName"];
	$from    = "Apache Web Server <" . strip_tags($_SERVER["SERVER_ADMIN"]) . ">";
	
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
	mail($DEST_EMAIL, $subject, $message, $headers);
}

/* gets a list of all available classes
 * @param   pointer to mySQL connection
 * @returns array of available classes
 * @throws  if an SQL or input validation error occurs */
function getClassList($mysql)
{
	/* prepare query */
	$query = "SELECT id, className, startDate FROM classes WHERE startDate > DATE_ADD(NOW(), INTERVAL 1 WEEK)";
	$statement = $mysql->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysql->error));
	}
	
	/* execute mySQL query */
	if($statement->execute() === false)
	{
		throw(new Exception("Unable to query mySQL: " . $statement->error));
	}

	$classes = array();
	$statement->bind_result($id, $className, $startDate);
	while($statement->fetch())
	{
		/* verify & normalize the date */
		$classDate = null;
		try
		{
			$date      = new DateTime($startDate);
			$classDate = $date->format("m/d/Y");
		}
		catch(Exception $e)
		{
			throw(new Exception("Unable to format start date: invalid start date", 0, $e));
		}
		$class = $className . " ($classDate)";
		$classes[$id] = $class;
	}
	return($classes);
}

/* gets a human readable name of a class
 * @param   pointer to mySQL connection
 * @param   class ID to query
 * @returns string containing class name
 * @throws  if an SQL or input validation error occurs */
function getClassName($mysql, $classId)
{
	/* prepare query */
	$query = "SELECT className, startDate FROM classes WHERE id = ?";
	$statement = $mysql->prepare($query);
	if($statement === false)
	{
		throw(new Exception("Unable to prepare mySQL query: " . $mysql->error));
	}
	
	/* bind parameters to the prepared statement */
	$statement->bind_param("i", $classId);
	
	/* execute mySQL query */
	if($statement->execute() === false)
	{
		throw(new Exception("Unable to query mySQL: " . $statement->error));
	}

	$statement->bind_result($className, $startDate);
	$statement->fetch();
	/* verify & normalize the date */
	$classDate = null;
	try
	{
		$date      = new DateTime($startDate);
		$classDate = $date->format("m/d/Y");
	}
	catch(Exception $e)
	{
		throw(new Exception("Unable to format start date: invalid start date", 0, $e));
	}
	$class = $className . " ($classDate)";
	return($class);
}

/* retrieves and decrypts the private key for Captcha
 * @returns private key for Captcha API */
function getCaptchaPrivateKey()
{
	global $AES256_KEY;
	global $CAPTCHA_KEY;
	
	$aes = new AES($AES256_KEY);
	$key = $aes->decrypt($CAPTCHA_KEY);
	return($key);
}

/* verifies whether the captcha is valid
 * @throws if the captcha is invalid */
function verifyCaptcha()
{
	$privateKey = getCaptchaPrivateKey();
	$captcha = recaptcha_check_answer ($privateKey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

	if (!$captcha->is_valid)
	{
		/* if the captcha was entered incorrectly, display an error */
		throw(new Exception("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $captcha->error . ")"));
	}
}

/* screen scrapes a WordPress page for the header and footer
 * @returns an array containing {header, footer} data
 * @throws  if a parse error occurs */
function stealWordPressFormatting()
{
	/* first load a WordPress enabled page */
	global $BASE_URL;
	$html = file_get_contents($BASE_URL);
	
	/* define the header as <!DOCTYPE html>...<div id="content"> & add our own CSS */
	$css          = "<link rel=\"stylesheet\" type=\"text/css\" href=\"apply.css\" />";
	$beginNeedle  = "<div id=\"content\">";
	$contentBegin = strpos($html, $beginNeedle);
	if($contentBegin === false)
	{
		throw(new Exception("Unable to find WordPress header"));
	}
	$contentBegin = $contentBegin + strlen($beginNeedle);
	$header       = substr($html, 0, $contentBegin);
	$header       = str_replace("</head>", "$css\n</head>", $header);
	
	/* define a jQuery script to validate the application form */
	$jQuery = <<<EOT
<script type="text/javascript">
jQuery("#applyForm").validate(
{
	rules:
	{
		aboutYourself:
		{
			required: true
		},
		whyAttend:
		{
			required: true
		},
		otherLinks:
		{
			required: true
		},
		progExperience:
		{
			required: true
		},
		fullName:
		{
			required: true
		},
		phoneNumber:
		{
			required: true
		},
		emailAddress:
		{
			required: true,
			email: true
		},
		howHeard:
		{
			required: true
		}
	},
	
	messages:
	{
		aboutYourself:  "Please tell us about yourself",
		whyAttend:      "Please tell us why you'd like to attend",
		otherLinks:     "Please provide additional information about yourself",
		progExperience: "Please tell us about your programming experience",
		fullName:       "Please enter your full name",
		phoneNumber:    "Please enter your phone number",
		emailAddress:   "Please enter your Email address",
		birthday:       "Please enter your birthday",
		howHeard:       "Please tell us how you heard about us"
	}
});
</script>
EOT;

	/* define the footer as <footer id="footer">...</html> & add the jQuery script */
	$endNeedle   = "<footer id=\"footer\">";
	$footerBegin = strpos($html, $endNeedle);
	if($footerBegin === false)
	{
		throw(new Exception("Unable to find WordPress footer"));
	}
	$footer = "</div>\n</section>\n";
	$footer = $footer . substr($html, $footerBegin);
	$footer = str_replace("</body>", "$jQuery\n</body>", $footer);
	
	/* construct the array & return it */
	$formatting = array($header, $footer);
	return($formatting);
}
?>