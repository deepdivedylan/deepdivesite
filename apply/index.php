<?php
/* load captcha library */
require_once("applylib.php");
$publicKey = "6LfJ8ekSAAAAAFz1jDyhvr9POl-UfASxN_yBbthB";

$mysqli = null;
try
{
	$mysqli     = Pointer::getMysqli();
	$classes    = getClassList($mysqli);
}
catch(Exception $e)
{
	echo "Unable to connect to mySQL: " . $e->getMessage() . "<br />";
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Deep Dive Coders</title>
    
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="apply.css" rel="stylesheet">
  </head>

<!-- NAVBAR
================================================== -->
  <body>
 <div class="navbar-wrapper">
      <div class="container"> 
        <a href=""><img src="../images/logo.png" class="logo"></a>
          <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class=""><a href="../index.html">Home</a></li>
                <li><a href="../our_team.html">Our Team</a></li>
                <li><a href="../the_program.html">The Program</a></li>
                <li><a href="../faq.html">FAQs</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="../contact.html">Contact</a></li>
                <li class="active"><a href="/apply">Apply</a></li>
                
                
                <!--
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
                
                -->
              </ul>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <section class="container" style="margin-top: 100px">
	<h1>Application</h1>
	<p>You're a great fit for Deep Dive Coders because you're:</p>
	<table class="passionTable">
		<tr>
			<td><strong>Passionate:</strong></td><td>when you take on a project you think about it all the time.</td>
		</tr>
		<tr>
			<td><strong>Friendly:</strong></td><td>you like people.</td>
		</tr>
		<tr>
			<td><strong>Enthusiastic:</strong></td><td>you're proactive, dive in with both feet, and have a can-do outlook.</td>
		</tr>
		<tr>
			<td><strong>Persistent:</strong></td><td>you're determined to finish what you start and you go over, around or through roadblocks to keep moving forward.</td>
		</tr>
		<tr>
			<td><strong>Ambitious:</strong></td><td>you have goals, and you enjoy reaching them.</td>
		</tr>
	</table>

	<p><br />If you're ready to change your world, please tell us about you below.</p>

	<p><span class="required">* Required</span></p>

	<p><span class="required">Please select the programming course you would like to attend. *</span></p>

	<form id="applyForm" method="post" action="send_application.php">
		<p>
			<select id="classId" name="classId">
			<?php
				foreach($classes as $id => $class)
				{
					echo "<option value=\"$id\">$class</option>\n";
				}
			?>
			</select>
		</p>

		<p><span class="required">Please tell us about yourself, including at least one personal story that helps describe you. *</span><br />
		<textarea id="aboutYourself" name="aboutYourself" rows="8" placeholder="Tell us your story..." required></textarea></p>

		<p><span class="required">Why do you want to attend Deep Dive Coders? *</span><br />
		<textarea id="whyAttend" name="whyAttend" rows="8" placeholder="Tell us why you want to learn with us..." required></textarea></p>

		<p><span class="required">What other videos, links, profiles, resumes, etc. should we see that help tell your story? *</span><br />
		<textarea id="otherLinks" name="otherLinks" rows="8" placeholder="Show us who you are..." required></textarea></p>

		<p><span class="required">Do you have any previous programming experience? If so, please tell us about it and share links to your portfolio, GitHub account, etc. *</span><br />
		<textarea id="progExperience" name="progExperience" rows="8" placeholder="Tell us about any previous experience..." required></textarea></p>

		<p><span class="required">Full Name *</span><br />
		<input class="textField" type="text" id="fullName" name="fullName" required /></p>

		<p><span class="required">Phone number *</span><br />
		<input class="textField" type="text" id="phoneNumber" name="phoneNumber" required /></p>

		<p><span class="required">Email address *</span><br />
		<input class="textField" type="text" id="emailAddress" name="emailAddress" type="email" required /></p>

		<p><span class="required">How did you hear about Deep Dive Coders? *</span><br />
		<input class="textField" type="text" id="howHeard" name="howHeard"  required /></p>

		<p>Skype ID (We often interview over Skype)<br />
		<input class="textField" type="text" id="skype" name="skype" /></p>

		<p>Google+ ID (we actually like Google Hangouts better than Skype)<br />
		<input class="textField" type="text" id="google" name="google" /></p>

		<p><span class="required">Gender *</span><br />
			<select name="gender">
				<option value="F">Female</option>
				<option value="M">Male</option>
			</select>
		</p>

		<p><span class="required">Date of Birth *</span><br />
		<input type="date" id="birthday" name="birthday" required /></p>

		<p><span class="required">Please enter the captcha below to show you're a human *</span><br />
		<?php echo recaptcha_get_html($publicKey); ?></p>

		<p><input id="apply" name="apply" type="submit" value="Apply" />&nbsp;<input id="reset" name="reset" type="reset" value="Reset Form" /></p>
	</form>
	<p class="pull-right"><a href="#">Back to top</a></p>
    </section>
    <hr>
      <!-- FOOTER -->
      <footer class="footer container">
        <p class="pull-right">
          <strong>Contact:</strong><br/>
          Deep Dive Coders<br/>
          312 Central Ave SE<br/>
          Albuquerque, NM 87102<br/>
          (505) 720-1380<br/>
         <a href="mailto:hello@deepdivecoders.com">hello@deepdivecoders.com</a>
        </p>
        <p>
          &copy; 2013-2014 Deep Dive Coders LLC All Rights Reserved &middot;
          <a href="#">Carrers</a> &middot;
          <a href="#">Employers</a>  &middot;
          <a href="#">Our Network</a>  &middot;
          <a href="../contact.html">Stay Informed</a>
        </p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
  </body