<?php
require_once("../../config.php");
require_once("post.php");

function titleToUrl($title)
{
    $url = strtolower($title);
    $url = str_replace("-", "--", $url);
    $url = str_replace(" ", "-", $url);
    return($url);
}

function urlToTitle($url)
{
    $title = str_replace("-", " ", $url);
    $title = str_replace("  ", "-", $title);
    $title = ucwords($title);
    return($title);
}

if(isset($_GET["title"]))
{
    try
    {
        $title  = urlToTitle($_GET["title"]);
        $mysqli = Pointer::getMysqli();
        $post   = Post::getPostByTitle($mysqli, $title);
        echo $post;
    }
    catch(Exception $exception)
    {
        echo "404 post not found";
    }
}
?>
