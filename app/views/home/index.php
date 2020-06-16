<?php $uesrType = 2?>
<html>

<head>
    <title>Çelikler Restaurant</title>

    <!-- CSS FILES -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">    
    


    <!-- TAB ICON -->
    <link href="images/logo-icon.png" rel="icon">

    <!-- JavaScript and jQuery files -->
    <script src="js/jquery-1.12.1.min.js"></script>
  
    <script src="js/home.js"></script>
    <script src="js/index.js"></script>

</head>


<body id="index-page-body" style="background-color: #232934">

    <!-- Sekilli black background -->
    <div class="background"></div>

    <!-- Home  -->
    <div class="home-section">
        <!-- Nav bar starts -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- LOGO -->
                    <a class="" href="index.php"><img src="images/logo.png" class="" id="index-page" /></a>
                </div>

                <!--  Menu links-->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#food-menu" >Food menu</a></li>
                        <li><a href="#contact-us">Contact us</a></li>
                        <li><a href="famous.php">Famous</a></li>
                        <li><a id="login-button" class="outline" onclick="showLoginCard();">Login</a></li>
                    </ul>
                </div>
                <!-- navbar-collapse ends-->
            </div>
            <!-- container-fluid ends -->
        </nav>

        <!-- Welcome text starts -->
        <h1 class="col-md-8 col-md-offset-2 text-center" id="welcome-text">WELCOME TO <br>ÇELİKLER RESTAURANT</h1>
        <p class="col-md-8 col-md-offset-2 text-center" id="welcome-paragraph"> Çelikler restaurant, which was founded by Eda Deniz Çelik and Sena Çelik and hosted famous names such as Ender Sevinç, Madonna and Jim Carrey for 10 years, is on the way to be the number 1 in the world. Sign up to be able to book at this magic restaurant.</p>
        <a class="col-lr-4 col-lr-offset-4 col-md-6 col-md-offset-3 text-center col-xs-8 col-xs-offset-2" id="sign-up-button" onclick="showSignUpCard();">Create account to reservation</a>


        <!-- Form implementation -->
        <?php
            require_once'elements/forms/login-form.php';
            require_once'elements/forms/sign-up-form.php';
         ?>
    </div>

    <!-- Food menu section -->
    <div class="food-menu-section" id="food-menu">
        <label class="text-center headline">Check our food menu</label>

        <div class="food-card col-sm-3 col-xs-12 first" id="big-mac-card">
            <div class="image-edit">
                <p class="text-center col-xs-10 col-xs-offset-1">The best burger in the word CelBurger!!! Ender Sevinç's special!'
                <h1 class="text-center">burger</h1>
            </div>
        </div>
        <div class="food-card col-sm-3 col-xs-12" id="pizza-card">
            <div class="image-edit">
                <p class="text-center col-xs-10 col-xs-offset-1">You will feel like you are in Italy! Madonna had come to Turkey for this pizza Chef Eda prepared the dough.</p>
                <h1 class="text-center">Pizza</h1>
            </div>
        </div>
        <div class="food-card col-sm-3 col-xs-12" id="chicken-macdo-card">
            <div class="image-edit">
                <p class="text-center col-xs-10 col-xs-offset-1">An amazing menu made using free-walking village chicken! Chef Sena brought these chickens from Çorum.</p>
                <h1 class="text-center">Chicken</h1>
            </div>
        </div>

        <a class="col-md-4 col-md-offset-4 text-center col-xs-8 col-xs-offset-2" id="food-menu-button" href="?url=foodmenu">See our food menu</a>
    </div>


    <!-- Contact us section starts a memory for our lovely teacher Mr. Sevinç -->
<div class="contact-us-section" id="contact-us">
<label class="text-center headline">Contact Us</label>

<div style='opacity: 0;' id='imageHover'>
<div class="image-hover-container">
    <div class='container'>
        <div class='middle'>
            <div class='bg-image lake-district'></div>
            <a href='#'  target="_blank" class='overlay'>
                 <p>Celikler Restaurant</p>
                <p>You can call us!<br>(0312) 251 00 00 </p>
            </a>
        </div>
        <div class='bottom-right'>
            <div class='bg-image lake-district'></div>
        </div>
        <div class='bottom-left'>
            <div class='bg-image lake-district'></div>
        </div>
        
        <div class='top-left'>
            <div class='bg-image lake-district'></div>
        </div>
        <div class='top-right'>
            <div class='bg-image lake-district'></div>
        </div>
    </div>
</div>

</div>

<!-- Loading Screen -->
<div class='loading-container' id='loadingScreen'>
    <div id="loading"></div>  
</div>
        </div>
    </div>
  
    <br><br>

</body>

<!-- Celikler footer -->
<div class="footer" style="position: ;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #F08080;
  color: white;
  text-align: center;">
  <p>Celikler©</p>
</div>
</html>
