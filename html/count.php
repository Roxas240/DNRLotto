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

    <title>Block Party Count Down</title>

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
    <div class="jumbotron" style="padding-bottom:1rem; padding-top:1rem;">
      <div class="container">
	    <div class="row fill" style="padding-top:1rem;">
		  <div class="col-sm-6 col-md-6" style="text-align:left; padding-left:0;">
		    <h6 id="height"></h6>
		  </div>
		  <div class="col-sm-6 col-md-6" style="text-align:right; padding-right:0;">
			<h6 id="total"></h6>
		  </div>
		</div>
	    <div class="row fill">
          <div class="col-xs-12 col-md-12" style="padding:0;"><h1 class="display-1" style="text-align:center; font-size: 8rem;" id="left"></h1></div>
		  <div class="col-xs-12 col-md-12" style="padding:0;"><h1 style="text-align:center;"><small><span id="eta"></span></small></h1></div>
		  <div class="col-xs-12 col-md-12" style="padding:0;"><h1 style="text-align:center;"><small><span id="time"></span></small></h1></div>
		</div>
		<div class="row fill" style="padding-top:2rem;">
		  <div class="col-sm-6 col-md-6" style="text-align:left; padding-left:0;">
		    <a href="https://twitter.com/denariuscoin?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="true">Follow @denariuscoin</a>
		  </div>
		  <div class="col-sm-6 col-md-6" style="text-align:right; padding-right:0;">
			<a href="https://twitter.com/XemplarSoft?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="true">Follow @XemplarSoft</a>
		  </div>
		</div>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
	  <div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="height:3rem;"><h1>Information:</h1></div>
		<div class="col-xs-6 col-sm-6 col-md-6" style="text-align:right; height:3rem; padding-top:0.8rem;" id="share-container"><a class="twitter-hashtag-button"
            href="https://twitter.com/intent/tweet?button_hashtag=DnrBlockParty&ref_src=twsrc%5Etfw"
            data-size="large"
            data-text="Only 2000 blocks left!!!"
            data-url="http://www.xemplarsoft.xyz/count.php"
            data-hashtags="DnrBlockParty"
            data-related="denariuscoin, XemplarSoft">
			Tweet #DnrBlockParty
		</a></div>
		<div class="col-md-12">
		  <hr/>
		  <p class="justify">
		    Follow <a href="https://twitter.com/denariuscoin">@Denariuscoin</a> for updates on the Denarius Wallet, the coin itself and other DNR
			type things. Follow <a href="https://twitter.com/XemplarSoft">@XemplarSoft</a> for updates to CryptoPayAPI (engine behind this website),
			the DNR Lotto and other cryptocurrency related news. Visit <a href="https://denarius.io">Denarius.io</a> to check out DNR and All of
			its goodies! And hey, if you wanna talk join us on <a href="https://gitter.im/denariusproject/Lobby">Gitter</a>. A great community to
			laugh and share all things crypto! Last Block Time was <span id="lasttime"></span> and the average block time for the last 1000 blocks
			is <span id="avgtime"></span>.
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
	<script async src="/js/twitter.js" charset="utf-8"></script>
	<script>
	  var height = 0;
	  var goal = 0;
	  var prev_goal = 0;
	  var prev = -1;
	  var time = 0;
	  var left = 0;
		
	  function update_block(){
		$.post("/include/getvar.php", { varname:"height" }, function(data) {
			var height = data;
			if(height != prev){
				$('#height').fadeOut(250, function() {
				    $("#height").html("Current Height: " + height);
				    $("#height").fadeIn(250);
			    });
				$.post("/include/getvar.php", { varname:"goal" }, function(data) {
			        goal = data;
					left = goal - height;
					
					if(goal != prev_goal){
					    $('#total').fadeOut(250, function() {
				            $("#total").html("Party At: " + goal);
				            $("#total").fadeIn(250);
			            });
					}
					
					prev_goal = goal;
					
					if(height >= goal){
						var extra = height - goal;
						$("#goal").text(goal + " Blocks Reached!");
						$("#left").text("Goal Reached " + extra + (extra != "1" ? " Blocks" : " Block") + " Ago.");
						update_twitter(goal + ' Goal Reached!!!');
					} else {
						update_twitter('Only ' + left + ' blocks left!!!');
						
					    $("#goal").text("Block Party At: " + goal);
				        $('#left').fadeOut(250, function() {
					        $("#left").text(left + (left != "1" ? " Blocks" : " Block"));
					        $("#left").fadeIn(250);
				        });
					
					    update_est();
					}
		        });
			}
			prev = height;
		});
	  }
	
	  function update_twitter(blocks){
		  $("#share-container").html('<a class="twitter-hashtag-button" href="https://twitter.com/intent/tweet?button_hashtag=DnrBlockParty&ref_src=twsrc%5Etfw" data-size="large" data-text="' + blocks + '" data-url="http://www.xemplarsoft.xyz/count.php" data-hashtags="DnrBlockParty" data-related="denariuscoin, XemplarSoft"> Tweet #DnrBlockParty </a>');
		  twttr.widgets.load();
	  }
	
	  function update_est(){
		  $.post("/include/getvar.php", { varname:"avgtime" }, function(data) {
			  time = data * left;
			  $("#avgtime").text(data + " seconds");
			  $('#time').fadeOut(250, function() {
				  var days = Math.floor(time / 60 / 60 / 24);
				  var hours = Math.floor(time / 60 / 60 % 24);
				  var mins = Math.floor(time / 60 % 60);
				  var secs = Math.floor(time % 60);
				  
				  var day_str = days != 1 ? "Days" : "Day";
				  var hur_str = hours != 1 ? "Hours" : "Hour";
				  var min_str = mins != 1 ? "Minutes" : "Minute";
				  var sec_str = secs != 1 ? "Seconds" : "Second";
				  
				  $("#time").html("Approximately: " + days + " " + day_str + ", " + hours + " " + hur_str + ", " + mins + " " + min_str + ", " + secs + " " + sec_str);
				  $("#time").fadeIn(250);
			  });
			  $('#eta').fadeOut(250, function() {
				  var ts = Math.round((new Date()).getTime() + (time * 1000));
				  var date = new Date(ts);
				  
				  $("#eta").html(get_day(date.getUTCDay()) + ", " + get_month(date.getUTCMonth()) + " " + date.getUTCDate() + " " + date.getUTCFullYear() + " at " + get_time(date) + " (UTC)");
			      $("#eta").fadeIn(250);
			  });
		  });
		  $.post("/include/getvar.php", { varname:"lasttime" }, function(data) {
			  $("#lasttime").text(data != "1" ? (data + " seconds") : (data + " second"));
		  });
	  }
	  
	  function get_month(name){
		  var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		  return months[name];
	  }
	  
	  function get_day(name){
	      var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		  return days[name];
	  }
	  
	  function get_time(date){
		  var rawHours = date.getUTCHours();
		  var meridian = " AM";
		  if(rawHours >= 12){
			  meridian = " PM";
		  }
		  if(rawHours >= 13){
			  rawHours -= 12;
		  }
		  
		  return rawHours + ":" + inflate(date.getUTCMinutes()) + meridian;
	  }
	  
	  $(document).ready(function(){
		update_block();
		setInterval(update_block, 300);
	  });
	  
	  function inflate(n){
          return n > 9 ? "" + n: "0" + n;
      }
	</script>
  </body>
</html>
