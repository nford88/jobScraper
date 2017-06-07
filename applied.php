<?php
require ('conn.php');

if(isset($_POST['search_button']))
{
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT jobScraper.role, jobScraper.company, jobScraper.salary, jobScraper.url, applied.dateApp, applied.applierName, applied.applierEmail FROM `jobScraper` LEFT JOIN `applied` ON jobScraper.url=applied.url WHERE jobScraper.apply=1 AND CONCAT(jobScraper.role, jobScraper.company, jobScraper.salary, jobScraper.url, applied.dateApp, applied.applierName, applied.applierEmail) LIKE '%".$valueToSearch."%'";
  $search_result = filterTable($query); 
}
else {
  $query = "SELECT jobScraper.role, jobScraper.company, jobScraper.salary, jobScraper.url, applied.dateApp, applied.applierName, applied.applierEmail FROM `jobScraper` LEFT JOIN `applied` ON jobScraper.url=applied.url WHERE jobScraper.apply=1 ORDER BY applied.dateApp DESC";
  $search_result = filterTable($query);
}

if(isset($_POST['upd_button'])){
  $applierName = $_POST['appName'];
  $applierEmail= $_POST['appEmail'];
  $url = $_POST['upd_button'];
  echo $applierEmail, $applierName, $url; 
  $query = "UPDATE `applied` SET `applierName` = '$applierName', `applierEmail` = '$applierEmail'  WHERE `url` = '$url' ";
  mysqli_query($connect, $query);
  header('Location: applied.php');
}

// function to connect and execute the query
function filterTable($query)
{
  global $connect;
  $filter_Result = mysqli_query($connect, $query);
  return $filter_Result;
}

?>

<html>
<head>

</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="styles.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">JobParser</a>
      </div>
      <ul class="nav navbar-nav">
        <li class=""><a href="represent.php">Home</a></li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="active"><a href="applied.php">Applied</a></li>
      </ul>

      <div class="col-sm-3 col-md-3 pull-right">
        <form class="navbar-form" method="POST" action="applied.php">
          <div class="input-group">
            <input type="text" class="form-control" type="text" name="valueToSearch" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit" name="search_button" value="Filter"><i class="glyphicon glyphicon-search"></i></button>
            </div>
          </div>
        </form>
      </div>        
    </nav>
    <body>


      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Role</th>
            <th>Company</th>
            <th>Salary</th>
            <th>URL</th> 
            <th>Date Applied</th>
            <th>Contact Name</th>
            <th>Contact Email</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_array($search_result)):?>
            <tr>
              <td><?php echo $row['role'];?></td>
              <td><?php echo $row['company'];?></td>
              <td><?php echo $row['salary'];?></td>
              <td><a href="<?php echo $row['url']; ?>" target="_blank" id="myBtn" class="btn btn-primary modal_button" data-id="<?php echo $row['url']; ?>">Link</a></td>
              <td><?php echo date('d M Y', strtotime($row['dateApp']));?></td>
              <form class="butts" action="applied.php"  method="POST">
                  <td><input type="text" name="appName" value="<?php echo $row['applierName'];?>"></td>
                  <td><input type="text" name="appEmail" value="<?php echo $row['applierEmail'];?>"></td>     
                  <td><button class="btn btn-danger" id="upd_button" name="upd_button" value="<?php echo $row['url']; ?>">Submit</button></td>
              </form>
          </tr>

        </tbody>
      <?php endwhile;?>
    </table>
  </tr>
</tbody>
</table>
</tr>
</tbody>
</table>



<!-- The Modal -->
<!-- <div class="modal" id="myModal">
  <div class="modal-content">
  <span class="close"></span>
  </div>
</div> -->

</body>

<script src="script.js"></script>
</html>

