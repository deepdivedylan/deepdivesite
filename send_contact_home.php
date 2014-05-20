<?php
    //validate email
    function spamcheck($field)
    {
        //santize email
        $field = filter_var($field, FILTER_SANITIZE_EMAIL);
        //validate email
        if ($field = filter_var($field, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //check against the spamcheck function
    $mailcheck = spamcheck($_POST["email"]);
    if($mailcheck == FALSE)
    {
        throw(new Exception("Invalid Email, please try again"));
    }
    $email = $_POST["email"];
    
    //sanitize the name field
    $nameRegexp = "/^[a-zA-Z\s\'\-]+$/";
    $name = $_POST["name"];
    if(preg_match($nameRegexp, $name) === 0)
    {
        throw(new Exception("Please use only letters, spaces, hyphens and apostrophes in the name field"));
    }
    
    //sanitize the phone field
    $phoneRegexp = "/^[\dextEXT\(\)\.\-\+\s]+$/";
    $phone = $_POST["phone"];
    if(preg_match($phoneRegexp, $phone) === 0)
    {
        throw(new Exception("Please use only digits, spaces, dashes, periods, parentheses, and extensions in the phone field"));
    }
    
    // Message
    $message = "$name has put their contact information in the website. Contact them at $email or $phone.";
    
    // From 
    $header ="from: $name <$mail_from>";
    
    // Send it to John
    $to ='josh@joshuatomasgarcia.com';
    $send_contact = mail($to,"Contact Form",$message,$header);
    
    // Check, if message sent to your email 
    // display message "We've recived your information"
    if($send_contact)
    {
        echo "<h4 style='text-align: center'>We've recived your contact information</h4>";
    }
    else {
    echo "ERROR";
    }
?>