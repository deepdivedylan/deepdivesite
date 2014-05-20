<?php
require_once("../../config.php");
require_once("post.php");

function titleToUrl($title)
{
    $url = strtolower($title);
    $url = preg_replace("/[^\w\_\-\s]*/", "", $url);
    $url = str_replace("-", "", $url);
    $url = str_replace(" ", "-", $url);
    return($url);
}

function urlToTitle($url)
{
    $title = str_replace("-", " ", $url);
    return($title);
}

if(isset($_GET["title"]))
{
    try
    {
        $title  = urlToTitle($_GET["title"]);
        $mysqli = Pointer::getMysqli();
        $posts   = Post::getAllTitles($mysqli);
        $id = array_search($title, $posts);
        $post = Post::getPostById($mysqli, $id);
        echo $post;
    }
    catch(Exception $exception)
    {
        echo "404 post not found";
    }
}
?>
