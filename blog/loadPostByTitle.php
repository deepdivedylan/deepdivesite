<?php
require_once("../../config.php");
require_once("post.php");

function titleToUrl($title)
{
    $url = strtolower($title);
    $url = preg_replace("/[^\w\_\-\s]*/", "", $url);
    $url = str_replace("-", "", $url);
    $url = str_replace(" ", "-", $url);
    return($url);
}

function urlToTitle($url)
{
    $title = str_replace("-", " ", $url);
    return($title);
}

if(isset($_GET["title"]))
{
    try
    {
        $title  = urlToTitle($_GET["title"]);
        $mysqli = Pointer::getMysqli();
        $posts   = Post::getAllTitles($mysqli);
        $id = array_search($title, $posts);
        $post = Post::getPostById($mysqli, $id);
        ?>
        <!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
        
        
            <title>Deep Dive Coders</title>
            
            <!-- Bootstrap core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            
            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        
            <!-- Custom styles for this template -->
            <link href="../css/style.css" rel="stylesheet">
          </head>
        
        <!-- NAVBAR
        ================================================== -->
          <body>
         <div class="navbar-wrapper">
              <div class="container"> 
                <a href=""><img src="../images/logo.png" class="logo"></a>
                  <div class="navbar navbar-inverse navbar-static-top" role="navigation">
                  <div class="container">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      
                    </div>
                    <div class="navbar-collapse collapse">
                      <ul class="nav navbar-nav">
                        <li class=""><a href="../index.html">Home</a></li>
                        <li><a href="../our_team.html">Our Team</a></li>
                        <li><a href="../the_program.html">The Program</a></li>
                        <li><a href="../faq.html">FAQs</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="../contact.html">Contact</a></li>
                        <li class="active"><a href="/apply">Apply</a></li>
                        
                        
                        <!--
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                          </ul>
                        </li>
                        
                        -->
                      </ul>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <section class="container" style="margin-top: 100px">
                <?php echo $post;?>
                <p class="pull-right"><a href="#">Back to top</a></p>
            </section>
            <hr>
              <!-- FOOTER -->
              <footer class="footer container">
                <p class="pull-right">
                  <strong>Contact:</strong><br/>
                  Deep Dive Coders<br/>
                  312 Central Ave SE<br/>
                  Albuquerque, NM 87102<br/>
                  (505) 720-1380<br/>
                 <a href="mailto:hello@deepdivecoders.com">hello@deepdivecoders.com</a>
                </p>
                <p>
                  &copy; 2013-2014 Deep Dive Coders LLC All Rights Reserved &middot;
                  <a href="#">Carrers</a> &middot;
                  <a href="#">Employers</a>  &middot;
                  <a href="#">Our Network</a>  &middot;
                  <a href="../contact.html">Stay Informed</a>
                </p>
              </footer>
        
            </div><!-- /.container -->
        
        
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/docs.min.js"></script>
          </body>
        </html>
        <?php
    }
    catch(Exception $exception)
    {
        echo "404 post not found";
    }
}
?>
