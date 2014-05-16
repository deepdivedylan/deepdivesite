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

    <title>Write a Post on Deep Dive Coders</title>

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

      <form class="form-post" role="form" method="post" action="post_proc.php">
        <h2 class="form-signin-heading">Write a Post</h2>
        <input type="text" name="title" class="form-control" placeholder="Post Title" required autofocus><br />
        <input type="text" name="author" class="form-control" placeholder="Author" required><br />
        <textarea name="text" class="form-control" placeholder="Blog Post" required rows="40" cols="50"></textarea><br />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Publish</button>
      </form>

    </div> 
  </body>
</html>
