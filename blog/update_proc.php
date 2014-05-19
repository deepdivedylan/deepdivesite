<?php
    require_once("post.php");
    require_once("../../config.php");
    function updatePost()
    {
        $mysqli = Pointer::getMysqli();
        $title = $_POST["title"];
        $title = trim($title);
        $author = $_POST["author"];
        $author = trim($author);
        $text = $_POST["text"];
        $text = trim($text);
        $id = $_GET["post"];
        $date = null;
        try
        {
                    $post = Post::getPostById($mysqli, $id);
                    $post->setTitle($title);
                    $post->setAuthor($author);
                    $post->setText($text);
                    $post->update($mysqli);
        }
        catch(Exception $exception)
        {
                    echo "<p style='color: red'>There was a problem publishing your post.</p>";
                    return;
        }
        header("location: page.php");
        
    }
    updatePost();
?>