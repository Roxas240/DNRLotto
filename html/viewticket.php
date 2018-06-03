<?php
$DIR = "";
require $DIR."include/functions.php";
require $DIR."include/cryptolink.php";

$set = isset($_GET['id']);
$set &= !str_equal($_GET['id'], "");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/media/logo.png">

    <title>Fors Dīvitiārum</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/jumbotron.css" rel="stylesheet">
  </head>

  <body class="xemplar-body">

    <nav class="navbar navbar-custom navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <a class="navbar-brand" href="#"><img class="brand-logo" height="96px" src="/media/logo.png" /></a>
    </nav>
	
	<div class="nav-spacer"></div>
    
    <div class="container">
      <!-- Example row of columns -->
	  <div class="row" id="step2">
	    <div class="col-xs-7 col-md-7"><h1>View Tickets</h1></div>
		<div class="col-xs-5 col-md-5"><h1 style="text-align:right;" id="price">0.01 DNR</h1></div>
		<div class="col-xs-12 col-md-12"><hr/></div>
		
		<div class="col-xs-12 col-md-12">
		  <?php
		  if($set){
			  
		  } else { 
		    $query = "SELECT * FROM (
                    SELECT * FROM `lotto_tickets` ORDER BY id DESC LIMIT 1000
                  ) sub
                  ORDER BY id ASC";
		    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		    $count = mysqli_num_rows($result);
		  
		  echo '
		  <table class="table table-responsive">
		    <thead>
			  <tr>
			    <th>Address</th>
				<th>TIX ID</th>
				<th>Time</th>
			  </tr>
			</thead>
			<tbody>
			';
			    for($i = 0; $i < $count; $i++){
					$data = $result->fetch_assoc();
					echo '
			  <tr>
				<td>'.$data['address'].'</td>
				<td>'.$data['id'].'</td>
				<td>'.$data['date'].'</td>
			  </tr>';
				}
			echo '
			</tbody>
		  </table>
		  ';
		  ?>
		</div>
	  </div>
      
      <hr>

      <footer>
        <p>&copy; Xemplar Softworks 2017</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/tether.min.js"></script>
    <script src="/js/popper.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/clipboard.min.js"></script>
	<script>
	  $(document).ready(function(){
		
	  });
	</script>
  </body>
</html>
