<?php
require ('conn.php');

  $url = $_POST['url'];
  echo 'url = '.$url;
  $query = "UPDATE `jobScraper` SET `hide` = '1' WHERE `jobScraper`.`url` = '$url' ";
  mysqli_query($connect, $query);
  // header('Location: represent.php');

?>