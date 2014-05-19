<?php
    require_once("post.php");
    require_once("../../config.php");
    $mysqli = Pointer::getMysqli();
    if(isset($_GET["post"]))
    {
        $id = $_GET["post"];
        $post = Post::getPostById($mysqli, $id);
        $title = $post->getTitle();
        $author = $post->getAuthor();
        $text = $post->getText();
        $date = new DateTime($post->getDate());
        $date = $date->format("F j, Y");
        echo "<h1>$title</h1>";
        echo "<h3>By $author</h3>";
        echo "<h3>on $date</h3>";
        echo "$text";
    }
    else
    {
        echo "Blog post not found.";
    }
    
    
?>