<?php
    $config = parse_ini_file('../../jobscraper-config.ini');
    $connect = mysqli_connect($config['hostname'],$config['username'],$config['password'],$config['dbname']) ;
// Check connection
if (!$connect)
  {
  die("Connection error: " . mysqli_connect_error());
  }
?>