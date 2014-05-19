<?php
    require_once("post.php");
    require_once("../../config.php");
    $mysqli = Pointer::getMysqli();
    if(!isset($_GET["page"]))
    {
        $i = 0;
    }
    else
    {
        $pageNumber = $_GET["page"];
        $nextPage = $pageNumber + 1;
        $lastPage = $pageNumber - 1;
        $i = $pageNumber * 10;
    }
    $posts = Post::getTenPostsByDate($mysqli, $i);
    foreach($posts as $post)
    {
        $id = $post->getId();
        $title = $post->getTitle();
        $author = $post->getAuthor();
        $text = $post->getText();
        $text = implode(' ', array_slice(explode(' ', $text), 0, 50));
        $date   = new DateTime($post->getDate());
	$date   = $date->format("F j, Y");
        echo "<h1>$title</h1>";
        echo "<h3>By $author</h3>";
        echo "<h3>on $date</h3>";
        echo "$text" . "... ";
        echo "<a href='page.php?post=$id'>Read More.</a><br /><br />";
    }
    echo "<a href='index.php?page=$nextPage'>Older Posts</a> ";
    echo " <a href='index.php?page=$lastPage'>Newer Posts</a>";
    
    
?>