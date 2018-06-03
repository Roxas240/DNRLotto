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
  </head>

  <body class="xemplar-body">

    <nav class="navbar navbar-custom navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <a class="navbar-brand" href="#"><img class="brand-logo" height="96px" src="/media/logo.png" /></a>
    </nav>
	
	<div class="nav-spacer"></div>
    
    <div class="container">
      <!-- Example row of columns -->
	  <div class="row" id="step1">
	    <div class="col-md-12">
		  <h1>Request A Ticket</h1>
		  <hr/>
		  <p class="justify">
		    Due to the nature of CryptoPayAPI you must first request a ticket before you can buy it. It just involves you entering the Address
			you would like your winning to be paid to. It doesn't even have to be the same address you are paying with. On this site we will
			use your address to track who buys what. To prevent doubt in those who judge fairness, a timestamp is recorded along with your
			address and is able to be seen by the public. To request a ticket put your address in below.
		  </p>
		  <div class="input-group">
		    <span class="input-group-addon" id="basic-addon1">Pay To:</span>
			<input type="text" class="form-control" id="inaddy" placeholder="Your Address">
			<span class="input-group-btn">
			  <button type="button" id="check" class="btn btn-default">Submit</button>
			</span>
		  </div>
		</div>
	  </div>
	  
	  <div class="row" id="step2">
	    <div class="col-xs-7 col-md-7"><h1>Pay For Ticket</h1></div>
		<div class="col-xs-5 col-md-5"><h1 style="text-align:right;" id="price">0.01 DNR</h1></div>
		<div class="col-xs-12 col-md-12"><hr/></div>
		
		<div class="col-xs-12 col-md-12">
		  <div class="input-group">
			<input type="text" class="form-control" id="address" value="DLHdZBBgCMsA4sojKyQXpg5zjxFQLe2coa" readonly>
			<span class="input-group-btn">
			  <button type="button" id="copy-button" class="btn btn-default" data-clipboard-target="#address">Copy</button>
			</span>
		  </div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4"><div id="qr-holder"></div></div>
		<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
		  <p class="justify">
		    On your wallet, please either scan the QR Code, or copy the above address. Make sure in the transaction that in the note, or narration
			section you enter the PIN code below without spaces. WARNING: We are not responsible for any lost funds. If you sent the wrong PIN,
			please contact the developer and send the PIN you sent. If you sent to the wrong address, there is nothing we can do. Any charges for
			refunds are directed to the customer.
		  </p>
		  <div class="pin-code">
		    Pin: <span id="pin">000000</span>
		  </div>
		  <div class="progress">
            <div id="prog" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
              0%
            </div>
          </div>
		</div>
	  </div>
	  
	  <div class="row" id="step3">
	    <div class="col-xs-12 col-md-12"><h1>Receipt For Ticket</h1></div>
		<div class="col-xs-12 col-md-12"><hr/></div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  <p class="justify">
		    You have successfully purchaced a ticket to lottery <span id="#lotto-id"></span>. The drawing will occur 2000 blocks after minimum ticket
			count is reached. All tickets for the current lottery will stop being sold 15 blocks before the winner-deciding block is mined. Any tickets
			purchased after then will count towads the next lottery. For now you can either browse all the tickets purchased 
		    <a href="viewticket.php">here</a>, look at the info of your ticket <span id="#ticket-id">here</span> or go about your day. If you wanna buy
			another ticket you can refresh the page or click <a href="buy.php">here</a>. Limit 10 tickets per address.
		  </p>
		</div>
	  </div>
	  
	  <div class="row" id="step4">
	    <div class="col-xs-12 col-md-12"><h1>Ticket Request Canceled</h1></div>
		<div class="col-xs-12 col-md-12"><hr/></div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  <p class="justify">
		    While processing your request, your ticket request was canceled. This may be due to errors relating an invalid request sent from your browser,
			or more likely your payment timed out. If you sent any DNR at all to the above address, please email dnrlotto@xemplarsoft.xyz with the TX ids
			and your pin number. Unfortunately, all refund TX fees come out of the DNR you sent. Next time, if you start a multi payment, please pay quickly
			within 15 minutes.
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
	<script src="/js/kjua-0.1.1.min.js"></script>
	<script src="/js/clipboard.min.js"></script>
	<script src="/js/wallet-address-validator.min.js"></script>
	<script>
	  var payid = -1;
	  var tixid = -1;
	  var check_id;
	  var check_prog;
	
	  function addreq(addy){
		$.post("/include/addreq.php", { address: addy }, function(data) {
			try{
				var dat = data.split(":");
				if(dat[1] > -1){
					payid = dat[1];
				    check_id = setInterval(checkreq, 500);
				}
			} finally {
				
			}
		});
	  }
	
	  function checkreq(){
		  if(payid > -1){
		    $.post("/include/checkreq.php", { id: payid }, function(data) {
			  try{
				  var dat = data.split(":");
				  if(dat[1] > -1){
					$("#pin").text(dat[1]);
					$("#step1").hide();
					$("#step2").show();
					
					clearInterval(check_id);
					check_prog = setInterval(checkprog, 500);
				  }
			  } finally {
				
			  }
		    });
		  }
	  }
	  
	  function checkprog(){
		  if(payid > -1){
		    $.post("/include/checkprog.php", { id: payid }, function(data) {
			  try{
				  var dat = data.split(":");
				  var filled  = dat[1];
				  var confirm = parseFloat(dat[3]);
				  
				  setProgress("#prog", confirm, 10);
				  
				  if(filled == "1"){
					$.post("/include/gettix.php", { id: payid }, function(data) 
						var tix = data.split(":");
						$("#lotto-id").html(tix[1]);
						$("#ticket-id").html('<a href="viewticket.php?id="' + tix[0] + '>here</a>');
				    });
					  
		        	$("#pin").text(dat[1]);
					$("#step2").hide();
					$("#step3").show();
					
					clearInterval(check_prog);
				  }
				  
				  if(filled == "-1"){
					$("#step2").hide();
					$("#step4").show();
					
					clearInterval(check_prog);
				  }
			  } finally {
				
			  }
		    });
		  }
	  }
	  
	  function setProgress(selector, progress, max){
          var size = (progress / max * 100);
          $(selector).width(size + "%");
          $(selector).html(Math.floor(size) + "%");
      }
	
	  $(document).ready(function(){
		var el = kjua({
			ecLevel: 'M',
			size: 248,
			fill: '#333',
			back: '#fff',
			text: $('#address').val(),
			mode: 'plain'
		});
		document.querySelector('#qr-holder').appendChild(el);
		new Clipboard('#copy-button');
		
		$("#step2").hide();
		$("#step3").hide();
		$("#step4").hide();
		
		$("#check").click(function() {
			var addy = $("#inaddy").val();
			var valid = window.WAValidator.validate(addy, 'DNR');
			if(valid){
				addreq(addy);
			} else {
				alert('Address INVALID');
			}
		});
	  });
	</script>
  </body>
</html>
