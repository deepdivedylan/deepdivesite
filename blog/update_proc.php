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
        $id = $_POST["postId"];
        $date = $_POST["date"];
        try
        {
                    $post = Post::getPostById($mysqli, $id);
                    $post->setTitle($title);
                    $post->setAuthor($author);
                    $post->setText($text);
                    $post->setDate($date);
                    $post->update($mysqli);
        }
        catch(Exception $exception)
        {
                    echo "<p style='color: red'>There was a problem updating your post: $exception</p>";
                    return;
        }
        header("location: page.php?post=$id");
        
    }
    updatePost();
?>