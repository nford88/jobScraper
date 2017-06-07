<?php
require ('conn.php');

$limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 0;
$offset = (intval($_GET['offset']) != 0 ) ? $_GET['offset'] : 0;


if(isset($_POST['valueToSearch']))
{
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT * FROM `jobScraper` WHERE `hide`=false AND CONCAT(`role`, `company`, `location`, `url`, `salary`, `dates`, `descr`, `apply`) LIKE '%".$valueToSearch."%' ORDER BY `dates` DESC";
  filterTable($query); 
}
else {
  $query = "SELECT * FROM `jobScraper` WHERE `hide`='false' ORDER BY `jobScraper`.`dates` DESC, `company` DESC LIMIT $limit OFFSET $offset" ;
  filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{ global $connect;
  $filter_Result = mysqli_query($connect, $query);
    if (count($filter_Result) > 0) {
      foreach ($filter_Result as $row) {
        echo '        <div class="col s12 m6 l4 jobCards">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <h5 class="role">'.  $row['role'] .'</h5>
              <p class="salary">€ '. $row['salary'].'</p>
              <p class="company">   '. $row['company'].' // <span class="dates">'. date('d M Y', strtotime($row['dates'])).'</span></p>
            </div>
            <div class="card-action">
              <a href="'.  $row['url'].'" target="_blank" id="myBtn" data-id="'.  $row['url'].'"><i class="material-icons">link</i></a>
              <a class="descTogg"><i class="material-icons">keyboard_arrow_down</i></a>
              <a class="hide_class" id="'.  $row['url'].'"><i class="material-icons">delete</i></a> 
              <a class="apply_button" id="'.  $row['url'].'">
                <i class="material-icons">favorite</i>
              </a>
            </div>
          </div>
        </div>';
      }
  }
}










if(isset($_POST['apply'])){
  $url = $_POST['apply'];
  $query = "UPDATE `jobScraper` SET `apply` = '1' WHERE `jobScraper`.`url` = '$url' ";
  mysqli_query($connect, $query);
  $query = "INSERT INTO `applied` SET `applied`.`url` = '$url', `applied`.`applierName` = '-', `applied`.`applierEmail` = '-' ";
  mysqli_query($connect, $query);
}


?>

