<?php
  session_start();
  if(!isset($_SESSION["id"]))
  {
    header("location: login.html");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Deep Dive Coders Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
        <nav style="max-width: 800px; margin: 0 auto; padding: 15px">
        <a href="logout_proc.php"><button class="btn btn-lg btn-primary btn-block" type="submit" style="float: right; width: 100px">Logout</button></a>
        <a href="admin.php"><button class="btn btn-lg btn-primary btn-block" style="float: right; width: 100px; margin-right: 20px">Home</button></a>
        </nav>
        <h2 class="form-signin-heading">Manage Deep Dive Coders Blog</h2>
        <a href="write_post.php"><button class="btn btn-lg btn-primary btn-block" style="width: 250px">Write a Post</button></a>
        <h3>Edit Posts:</h3>
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
                $i = $pageNumber * 100;
            }
            $posts = Post::get100Titles($mysqli, $i);
            foreach($posts as $post)
            {
                $id = $post[0];
                $title = $post[1];
                $date   = new DateTime($post[2]);
                $date   = $date->format("F j, Y");
                echo "<a href='edit_post.php?post=$id'><h4>$title</h4></a>";
                echo "<p style='text-indent:10px'>on $date</p>";
            }
            if(!isset($_GET["page"]))
            {
                echo "<a href='admin.php?page=1'>Older Posts</a> ";
            }
            else
            {
                echo "<a href='admin.php?page=$nextPage'>Older Posts</a> ";
                echo " <a href='admin.php?page=$lastPage'>Newer Posts</a>";
            }
            
        ?>
    </div> 
  </body>
</html>
