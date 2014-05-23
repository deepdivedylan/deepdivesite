<?php
    include("../php/header.php");
?>
    <section class="container">
	<?php
            require_once("post.php");
            require_once("../../config.php");
            require_once("loadPostByTitle.php");
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
                $text = implode(' ', array_slice(explode(' ', $text), 0, 100));
                $text = strip_tags($text, "<a><h1><h2><h3><h4><h5><h6><img><p>");
                $date   = new DateTime($post->getDate());
                $date   = $date->format("F j, Y");
                $url = titleToUrl($title);
                echo "<a href='$url'><h1>$title</h1></a>";
                echo "<h3>By $author</h3>";
                echo "<h3>on $date</h3>";
                echo "$text" . "... ";
                echo "<a href='$url'>Read More.</a><br /><br />";
            }
            if(!isset($_GET["page"]))
            {
                echo "<a href='index.php?page=1'>Older Posts</a> ";
            }
            else
            {
                echo "<a href='index.php?page=$nextPage'>Older Posts</a> ";
                echo " <a href='index.php?page=$lastPage'>Newer Posts</a>";
            }
            ?>
	<p class="pull-right"><a href="#">Back to top</a></p>
    </section>
<?php
    include("../php/footer.php");
?>
