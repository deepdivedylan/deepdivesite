<?php include("php/header.php"); ?>
    <section class="container" style="margin-top: 100px">
    <h3>Contact Us</h3>
    <p>
      Please feel free to call (505) 720-1380 or email <a href="mailto:hello@deepdivecoders.com">hello@deepdivecoders.com</a>. Additionally, if you would like to stay informed, please enter your information in the contact form below.
    </p>
      <form name="contact" method="post" action="send_contact_home.php">
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
            <td><input name="phone" type="text" id="phone" size="50"></td>
          </tr>
          <tr>
            <td colspan="2"><input class="btn btn-default" type="submit" name="submit" value="Stay Informed"></td>
          </tr>
        </table>
      </form>
    <p class="pull-right"><a href="#">Back to top</a></p>
    </section>
    <?php include("php/footer.php"); ?>