<?php
session_start();
require_once("user.php");
require_once("../../config.php");
function makeUser()
{
    $mysqli = Pointer::getMysqli();
    $email = "ericdebelak@gmail.com";
    $salt = "136c67657614311f32238751044a0a3c0294f2a521e573afa8e496992d3786ba";
    $password = "ilovesecurepasswords";
    $password =  $password . $salt;
    $password = hash("sha512", $password, false);
    try
    {
        $user = new User(-1, $email, $password, $salt);
        $user->insert($mysqli);
    }
    catch(Exception $exception)
    {
        echo $exception;
    }
    
    
}
makeUser();
?>