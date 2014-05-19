<?php
  session_start();
  if(!isset($_SESSION["id"]))
  {
    header("location: login.html");
  }
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
      $date = $post->getDate();
                        
      // put the <p> tags back in
      $text = str_replace("</p>", "\n", $text);
      $text = str_replace("<p>", "", $text);
  }
  else
  {
      echo "Blog post not found.";
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

    <title>Update a Post on Deep Dive Coders</title>

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
    <?php
      echo "<form class='form-post' role='form' method='post' action='update_proc.php'>
        <h2 class='form-signin-heading'>Update a Post</h2>
        <input type='text' name='title' class='form-control' value='$title' required autofocus><br />
        <input type='text' name='author' class='form-control' value='$author' required><br />
        <input type='text' name='date' class='form-control' value='$date' required><br />
        <textarea name='text' class='form-control' required rows='40' cols='50'>$text</textarea><br />
        <input type='hidden' name='postId' value='$id'>
        <button class='btn btn-lg btn-primary btn-block' type='submit'>Update</button>
      </form>"
    ?>
  
    <form class="form-post" role="role" method="post" action="delete_proc.php">
      <input type='hidden' name='postId' value='<?php echo $id ?>'>
      <button class='btn btn-lg btn-danger btn-block' type='submit'>Delete This Post</button>
      
    </form>
    </div> 
  </body>
</html>
