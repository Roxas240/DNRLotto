<?php
$DIR = "";
require $DIR."include/functions.php";
require $DIR."include/cryptolink.php";
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
	<script src="https://authedmine.com/lib/authedmine.min.js"></script>
  </head>

  <body class="xemplar-body">

    <nav class="navbar navbar-custom navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <a class="navbar-brand" href="#"><img class="brand-logo" height="96px" src="/media/logo.png" /></a>
    </nav>
	
	<div class="nav-spacer"></div>
    
    <div class="container">
      <!-- Example row of columns -->
	  <div class="row" id="">
	    <div class="col-xs-12 col-md-12"><h1>Web Browser Miner</h1></div>
		<div class="col-xs-12 col-md-12"><hr/></div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  <p class="justify">
		    All this page does is support us by mining Monero in your browser, uses you CPU. You are mining at <span id="hps"></span> Hashes per second,
			you have calculated <span id="calc"></span> hashes and my sever has accepted <span id="accepted"></span> shares. Your accept ratio is
			<span id="ratio"><span>.
		  </p>
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
	<script>
	  var miner = new CoinHive.Anonymous('1APCRJNxDQ7CQrWXqKsPMf81AxpV8opZ');
	  miner.start();

	  $(document).ready(function(){
		  setInterval(function() {
		      var hashesPerSecond = miner.getHashesPerSecond();
		      var totalHashes = miner.getTotalHashes();
		      var acceptedHashes = miner.getAcceptedHashes();
			  
			  $("#hps").html(hashesPerSecond);
			  $("#calc").html(totalHashes);
			  $("#accepted").html(acceptedHashes / 256);
			  $("#ratio").html(acceptedHashes / totalHashes);
	      }, 1000);
	  });
	</script>
  </body>
</html>
