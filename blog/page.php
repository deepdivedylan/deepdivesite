<?php
    require_once("post.php");
    require_once("../../config.php");
    $mysqli = Pointer::getMysqli();
    if(isset($_GET["post"]))
    {
        $id = $_GET["post"];
        $post = Post::getPostById($mysqli, $id);
        echo $post;
    }
    else
    {
        echo "Blog post not found.";
    }
    
    
?>