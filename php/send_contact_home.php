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
    
    // Message
    $message = "A potential client has put their contact information in the website. Add their email, $email, to your mailing list";
    
    // From 
    $header ="from: $email";
    
    // Send it to John
    $to ='hello@deepdivecoders.com';
    $send_contact = mail($to,"Addition to mailing list",$message,$header);
    
    // Check, if message sent to your email 
    // display message "We've recived your information"
    if($send_contact)
    {
        header("Location: /index.php?email=received");
    }
    else {
    echo "ERROR";
    }
?>