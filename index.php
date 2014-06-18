<?php
    include("php/header.php");
    if(isset($_GET["email"]) && $_GET["email"] === "received")
    {
	echo"<script>alert('Thanks for subscribing!')</script>";
    }
?>
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          
          <div class="container">
            <div class="carousel-caption">
              <h1>Welcome to Deep Dive Coders!</h1>
              <p>Deep Dive Coders is the best value web development and programming bootcamp in the country. </p>
              <p><a class="btn btn-default btn-carousel" href="the_program.php" role="button">Learn More &raquo;</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          
          <div class="container">
            <div class="carousel-caption">
              <h1>Apply Now!</h1>
              <p>Do you want to gain skills where the talent currently enjoys about a 2% unemployment rate, and average salaries of $85K? Do you want to have the technical skills to build websites, software and apps? Apply now to join our June 2, 2014 Summer Bootcamp! Seats are filling up fast!</p>
              <p><a class="btn btn-default btn-carousel" href="/apply" role="button">Apply &raquo;</a></p>
              
            </div>
          </div>
        </div>
        <div class="item">
        
          <div class="container">
            <div class="carousel-caption">
              <h1>Stay Informed</h1>
              <p>Want to learn more? Feel free to call us at (505) 720-1380, email us at <a style="color:white; text-decoration:none" href="mailto:hello@deepdivecoders.com">hello@deepdivecoders.com</a> or join our mailing list below!</p>
              <!--<form name="contact" method="post" action="send_email.php">
                <table width="400" border="0" align="center" cellpadding="3" cellspacing="5">
                  <tr>
                    <td>Name:</td>
                    <td><input name="name" type="text" id="name" size="50"></td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td><input name="email" type="text" id="email" size="50"></td>
                  </tr>  
                  <tr>
                    <td>Phone:</td>
                    <td><input name="phone" type="text" id="phone" size="50" value="email"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input class="btn btn-default" type="submit" name="submit" value="Stay Informed"></td>
                  </tr>
                </table>-->
		<form name="contact" method="post" action="php/send_contact_home.php">
		<input name="email" type="text" style="color: black" id="email" size="30" placeholder="email@example.com">
		<br/>
		<input style="margin-top: 10px" class="btn btn-default btn-carousel" type="submit" name="submit" value="Stay Informed &raquo;">
              </form>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
      
      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="images/kirsten.jpg" alt="Photo of Kirsten" height="200px" width="200px">
          <h2>Kirsten</h2>
          <p>"Deep Dive Coders challenged me way beyond my level of comfort and tested my determination. With no prior technical skills, I am now looking forward to a career in web development. - Kirsten, Spring 2014</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="images/matt.png" alt="Photo of Matt" height="200px" width="200px">
          <h2>Matt</h2>
          <p>"Deep Dive Coders was an intense, comprehensive learning experience. It isn't easy but it's worth it. I can now confidently analyze, interpret, and write computer code and it was amazing how much we were able to learn and retain by working through the various projects" -Matt, Fall 2013</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="images/josh.jpg" alt="Photo of Josh" height="200px" width="200px">
          <h2>Josh</h2>
          <p>"I would reccomend Deep Dive Coders to anyone that has the will and determination to be a programmer but just lacks the guided instruction. Everything was amazing, the course, the instructor, my classmates and the networking all are there to help you succeed." -Josh, Spring 2014</p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Best Value in the Country. <span class="text-muted">We dare you to find a better deal.</span></h2>
          <p class="lead">We're the best value web bootcamp in the country, but this may not last forever. Apply now to take advantage of our current rates.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="images/team_2.jpg" alt="Photo of some of our students collaborating" height="500px" width="500px">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <a href="http://techcrunch.com/2012/09/30/an-analysis-of-market-demand-for-web-programming-languages/"><img class="featurette-image img-responsive" src="images/language_demand.png" alt="Graph of in-demand languages"height="500px" width="500px"></a>
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">High Demand. <span class="text-muted">We teach PHP for a reason.</span></h2>
          <p class="lead">PHP is the most used programming language and in the highest demand. You learn HTML5/CSS3, JavaScript, jQuery and mySQL as you build practical and theoretical foundation of understanding. But PHP is the focus, because that's where the jobs are.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Small Class Size. <span class="text-muted">We cap our classes at 10-15 students.</span></h2>
          <p class="lead">We work in small teams, collaborate on projects and everyone gets the individual attention they need.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="images/2014_01_06_camp.jpg" alt="Photo of our Winter 2014 bootcamp graduates" height="500px" width="500px">
        </div>
      </div>
      <br/>
      <br/>
      <br/>
      <!--<hr class="featurette-divider">-->
        
        

      <!-- /END THE FEATURETTES -->
<?php
    include("php/footer.php");
?>