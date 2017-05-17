<?php
require ('conn.php');

if(isset($_POST['valueToSearch']))
{
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT * FROM `jobScraper` WHERE `hide`=false AND CONCAT(`role`, `company`, `location`, `url`, `salary`, `dates`, `descr`, `apply`) LIKE '%".$valueToSearch."%' ORDER BY `dates` DESC";
  $search_result = filterTable($query); 
}
else {
  $query = "SELECT * FROM `jobScraper` WHERE `hide`='false' ORDER BY `jobScraper`.`dates` DESC, `company` DESC LIMIT 30";
  $search_result = filterTable($query);
}


if(isset($_POST['apply'])){
  $url = $_POST['apply'];
  $connect = mysqli_connect("localhost", "root", "mysql", "jobScraper");
  $query = "UPDATE `jobScraper` SET `apply` = '1' WHERE `jobScraper`.`url` = '$url' ";
  mysqli_query($connect, $query);
  $query = "INSERT INTO `applied` SET `applied`.`url` = '$url', `applied`.`applierName` = '-', `applied`.`applierEmail` = '-' ";
  mysqli_query($connect, $query);
}
// function to connect and execute the query
function filterTable($query)
{ global $connect;
  $filter_Result = mysqli_query($connect, $query);
  return $filter_Result;
}

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


<div class="row">
  <?php while($row = mysqli_fetch_array($search_result)):?>
    <div class="col s12 m6 l4" id="jobCards">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <h5 class="role"><?php echo $row['role'];?></h5>
          <p class="salary">€ <?php echo $row['salary'];?></p>

          <p class="company">   <?php echo $row['company'];?> // <span class="dates"><?php echo date('d M Y', strtotime($row['dates']));?></span></p>
        </div>
        <div class="card-action">
            
            <a href="<?php echo $row['url']; ?>" target="_blank" id="myBtn" data-id="<?php echo $row['url']; ?>"><i class="material-icons">link</i></a>
            <a class="descTogg"><i class="material-icons">keyboard_arrow_down</i></a>
            <a class="hide_class" id="<?php echo $row['url'];?>"><i class="material-icons">delete</i></a>
                   
            <a class="apply_button" id="<?php echo $row['url']; ?>">
              <i style="color:<?php if($row['apply']==1){ echo '#00ff00'; }?>;" class="material-icons">favorite</i>
            </a>
      
        </div>
      </div>
    </div>
  <?php endwhile;?>
</div>

<!--               <td colspan="8" class="itemDesc" style="display: none;"><?php echo $row['descr']; ?></td>
<?php echo $row['location'];?> // 
-->


</body>

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="js/custom.js"></script>
</html>

