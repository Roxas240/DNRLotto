<?php
$DIR = "";
require $DIR."include/functions.php";
require $DIR."include/cryptolink.php";

$conn = login_mysql();
$query = "SELECT `value` FROM `lotto_vars` WHERE name='sold'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$data = $result->fetch_assoc();

$sold = $data['value'];

error_reporting(E_ALL); ini_set('display_errors', 1); 
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

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
	    <div class="row fill">
          <div class="col-xs-9 col-md-9" style="padding:0;"><h1 class="display-3">Fors Dīvitiārum</h1></div>
		  <div class="col-xs-3 col-md-3" style="padding:0;"><h1 class="display-3" style="text-align:right;" id="height"><?php echo file_get_contents("http://localhost/include/blockheight.php"); ?></h1></div>
		</div>
		<div class="row fill">
		  <div class="col-xs-9 col-md-9"style="padding:0;">
			<p>Welcome to the Denarius lottery. It is quite simple to play, click the button below to purchase a ticket. All that is required to buy a ticket is your DNR address, no name or registration. Current limit is set at 10 tickets per address.</p>
			<p><a class="btn btn-primary btn-lg" href="buy.php">Buy a Ticket Now &raquo;</a> <a class="btn btn-success btn-lg" href="viewticket.php">View Tickets &raquo;</a></p>
		  </div>
		  <div class="col-xs-3 col-md-3" style="padding:0;">
			<p class="indent" style="text-align:right;">
			Block Draw Height: <span id="draw-height">200000</span><br/>
			Current Tickets Sold: <span id="sold-tickets">035</span><br/>
			Current Pot Total: <span id="pot-total">072</span><br/>
			Total Lotteries Held: <span id="lotto-count">003</span></p>
		  </div>
		</div>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
	  <div class="row">
	    <div class="col-md-12">
		  <h1>How Does it Work?</h1>
		  <hr/>
		  <p>
		    Every time you buy a ticket, that ticket is given an ID number. That ID number is what defines a win if selected. To
			ensure provably fair winnings, the number that determines the ticket that wins is the block header hash
			generated when a block is solved. The used block is marked above as &quot;Block Draw Height&quot;. That hash
			is then converted to a base-10 number and then modulo with the total number of tickets bought. Tickets stop being sold
			3 blocks before the Block Draw Height. Since there are 3 winners, the Block Draw Height and the very next 2 blocks after
			are drawn. Block Draw Height, is first and the others go in order.
		  </p>
		  <p>
		    For example, take the header hash of block 256826. Quite the large hex number indeed. Convert it into its the base-10
			representation. Now lets say 1243 tickets were bought. The base-10 equlivalent, modulo 1243 is 
			<?php echo bcmod("26582529392879661788940249849043594860928890895793242155140535942", '1243'); ?>. Meaning the ticket with
			that ID has won. The 1st gets 60% of the pot, 2nd gets 26% and 3rd gets 12%. The remaining 2% is split between the devs.
			Hopefully within each month, 2800 tickets are bought to maintain server costs. The total count this month so far is
			<?php echo '<span id="sold-month">'.$sold.'</span>'; ?>.
		  </p>
		</div>
	  </div>
	  <?php
	    $query = "SELECT * FROM (
                    SELECT * FROM `lotto_tickets` ORDER BY id DESC LIMIT 10
                  ) sub
                  ORDER BY id ASC";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($result);
	  ?>
	  <br/>
      <div class="row">
	    <div class="col-xs-12 col-md-12">
		  <h1>Last <?php echo $count; echo $count != 1 ? " Purchases" : " Purchase"; ?></h1>
		</div>
        <div class="col-xs-12 col-md-12">
          <table class="table table-responsive">
		    <thead>
			  <tr>
			    <th>Address</th>
				<th>TIX ID</th>
				<th>Time</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			    for($i = 0; $i < $count; $i++){
					$data = $result->fetch_assoc();
					echo '
			  <tr>
				<td>'.$data['address'].'</td>
				<td>'.$data['id'].'</td>
				<td>'.$data['date'].'</td>
			  </tr>';
				}
			  ?>
			</tbody>
		  </table>
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
	<script src="/js/kjua-0.1.1.min.js"></script>
	<script src="/js/clipboard.min.js"></script>
	<script src="/js/wallet-address-validator.min.js"></script>
	<script>
	  var height = 0;
	  var prev = -1;
		
	  function update_block(){
		$.post("/include/blockheight.php", function(data) {
			height = data;
			if(height != prev){
				$('#height').fadeOut(250, function() {
					$("#height").html(height);
					$("#height").fadeIn(250);
				});
			}
			prev = height;
		});
	  }
	  
	  
	  var prev_lotto;
	  var prev_draw;
	  var prev_sold;
	  var prev_pot;
	  
	  var lotto;
	  var draw;
	  var sold;
	  var pot;
	  
	  function update_stats(){
		$.post("/include/getstats.php", function(data) {
			var spl = data.split(":");
			
			lotto = spl[3];
			if(prev_lotto != lotto){
				$('#lotto-count').fadeOut(250, function() {
					$("#lotto-count").html(lotto);
					$("#lotto-count").fadeIn(250);
				});
				prev_lotto = lotto;
			}
			
			sold = spl[1];
			if(prev_sold != sold){
				$('#sold-tickets').fadeOut(250, function() {
					$("#sold-tickets").html(sold);
					$("#sold-tickets").fadeIn(250);
				});
				prev_sold = sold;
			}
			
			pot = spl[2];
			if(prev_pot != pot){
				$('#pot-total').fadeOut(250, function() {
					$("#pot-total").html(pot);
					$("#pot-total").fadeIn(250);
				});
				prev_pot = pot;
			}
			
			draw = spl[0];
			if(prev_draw != draw){
				$('#draw-height').fadeOut(250, function() {
					$("#draw-height").html(draw);
					$("#draw-height").fadeIn(250);
				});
				prev_draw = draw;
			}
		});
	  }
	
	  $(document).ready(function(){
		new Clipboard('#copy-button');
		
		update_block();
		update_stats();
		setInterval(update_stats, 1000);
		setInterval(update_block, 1000);
		
		$("#check").click(function() {
			var addy = $("#inaddy").val();
			var valid = window.WAValidator.validate(addy, 'DNR');
			if(valid){
				alert('This is a valid address');
			} else {
				alert('Address INVALID');
			}
		});
	  });
	</script>
  </body>
</html>
