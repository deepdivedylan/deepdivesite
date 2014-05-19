<?php
    require_once("post.php");
    require_once("../../config.php");
    function deletePost()
    {
        $mysqli = Pointer::getMysqli();
        $id = $_POST["postId"];
        try
        {
                    $post = Post::getPostById($mysqli, $id);
                    $post->delete($mysqli);
        }
        catch(Exception $exception)
        {
                    echo "<p style='color: red'>There was a problem deleting your post: $exception</p>";
                    return;
        }
        header("location: index.php");
        
    }
    deletePost();
?>