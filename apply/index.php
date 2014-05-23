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
    include("../php/header.php");
?>
    <link href="apply.css" rel="stylesheet">
    <section class="container">
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
<?php
    include("../php/footer.php");
?>