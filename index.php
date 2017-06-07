  <?php

  require ('represent.php');

  ?>

  <html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>JobScraper</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="js/materialize.js"></script>
  </head>
  <body>

    <nav class="black darken-4" role="navigation">
      <div class="nav-wrapper container">

        <a id="logo-container" href="#" class="brand-logo">JobScraper</a>

        <ul class="right hide-on-med-and-down">
         <li class="active"><a href="represent.php">Home</a></li>
         <li class=""><a href="applied.php">Applied</a></li> 
         <li>
           <form method="POST" action="represent.php">
            <div class="input-field"> 
              <input id="search" type="search" name="valueToSearch">
              <label class="label-icon" for="search" type="submit" name="search_button"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form>
        </li>
      </ul>

      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

      <ul id="nav-mobile" class="side-nav">
       <li class="active"><a href="represent.php">Home</a></li>
       <li class=""><a href="applied.php">Applied</a></li>
     </ul> 
   </div>
 </nav>


 <div id="results">
  <div class="row">
  </div>
</div>
<div id="loader_image">
  <div class="preloader-wrapper big active">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
      <div class="circle"></div>
    </div><div class="circle-clipper right">
    <div class="circle"></div>
  </div>
</div>
</div>
</div>


<script src="js/init.js"></script>
<script src="js/custom.js"></script>
</body>


</html>


