<?php
require ('conn.php');

if(isset($_POST['search_button']))
{
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT * FROM `jobScraper` WHERE `hide`=false AND CONCAT(`role`, `company`, `location`, `url`, `salary`, `dates`, `descr`) LIKE '%".$valueToSearch."%' ORDER BY `dates` DESC";
  $search_result = filterTable($query); 
}
else {
  $query = "SELECT * FROM `jobScraper` WHERE `hide`='false' ORDER BY `jobScraper`.`dates` DESC, `company` DESC";
  $search_result = filterTable($query);
}


if(isset($_POST['apply_button'])){
  $url = $_POST['apply_button'];
  $connect = mysqli_connect("localhost", "root", "mysql", "jobScraper");
  $query = "UPDATE `jobScraper` SET `apply` = '1' WHERE `jobScraper`.`url` = '$url' ";
  mysqli_query($connect, $query);
  $query = "INSERT INTO `applied` SET `applied`.`url` = '$url', `applied`.`applierName` = '-', `applied`.`applierEmail` = '-' ";
  mysqli_query($connect, $query);
  header('Location: applied.php');
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
        <li class="active"><a href="represent.php">Home</a></li>
      </ul>
      <ul class="nav navbar-nav">
        <li class=""><a href="applied.php">Applied</a></li>
      </ul>

      <div class="col-sm-3 col-md-3 pull-right">
        <form class="navbar-form" method="POST" action="represent.php">
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


      <table class="table table-striped table-hover table-condensed table-responsive">
        <thead>
          <tr>
            <th>Role</th>
            <th>Company</th>
            <th>Location</th>
            <th>URL</th> 
            <th>Salary</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_array($search_result)):?>
            <tr class="table-rows">
              <td><?php echo $row['role'];?></td>
              <td><?php echo $row['company'];?></td>
              <td><?php echo $row['location'];?></td>
              <td>
                <div>
                  <a href="<?php echo $row['url']; ?>" target="_blank" id="myBtn" class="btn btn-primary glyphicon glyphicon-globe" data-id="<?php echo $row['url']; ?>"></a>
                  <a class="descTogg btn btn-danger glyphicon glyphicon-resize-vertical"></a>
                </div>
              </td>
              <td><?php echo $row['salary'];?></td>
              <td><?php echo date('d M Y', strtotime($row['dates']));?></td>
              <td><form class="butts" action="represent.php"  method="POST"> 
                <div class="hide_class btn btn-danger glyphicon glyphicon-trash" id="<?php echo $row['url'];?>"></div>
                <button class="btn btn-success glyphicon glyphicon-plus" id="apply_button" name="apply_button" value="<?php echo $row['url']; ?>"></button>

              </form></td>  
            </tr>
            <tr>
              <td colspan="8" class="itemDesc" style="display: none;"><?php echo $row['descr']; ?></td>
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

