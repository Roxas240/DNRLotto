<?php
$port = 3306;
$table = "payments";
$hostname = "HOSTNAME";
$database = "crypto_payments";

error_reporting(E_ALL); ini_set('display_errors', 1);

function page_setup(){
  session_name("main");
  session_start();
}

function login_mysql() {
   $USER = "MYSQL USERNAME HERE";
   $PASS = "MYSQL PASSWORD HERE";

   $HOST = "HOSTNAME";
   $NAME = "DATABASE NAME";

   $conn = mysqli_connect($HOST, $USER, $PASS, $NAME);
   if(!$conn){
     die("Connection failure: ".mysqli_connect_error());
   }
   return $conn;
}

// Functions

function str_equal($str1, $str2){
   if(strcmp($str1, $str2) == 0){
      return true;
   } else {
      return false;
   }
}

function get_stats(){
	$conn = login_mysql();
	$query = "SELECT `value` FROM `lotto_vars` WHERE 1=1";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	$ret = "";
	
	while($row = mysqli_fetch_array($result)) {
        $ret .= $row['value'].":";
    }
	
	return substr($ret, 0, strlen($ret) - 1);
}

// Lazy functions
function print_copy(){
   echo "<p>&copy; 2009 - 2017 Xemplar Softworks.</p>";
}

function print_brand(){
    echo '<a class="navbar-brand" href="/">
              <span><img src="/media/logo.png" alt="X" width="48"></span>
              emplar Softworks
          </a>';
}

function print_head(){
	echo '	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Denarius Lottery">
    <meta name="author" content="Rohan Loomis">
    <link rel="icon" href="/favicon.ico">

    <title>Xemplar Softworks</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/jumbotron.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->';
}

function print_menu(){
   $auth = get_rank();

   global $RANK_NORMAL, $RANK_WRITER;

   echo '<ul id="navbar-links" class="nav navbar-nav">
     <li><a href="/apps/index.php">Software</a></li>
     <li><a href="/tut/index.php">Tutorials</a></li>
     <li><a href="/qna/index.php">Q &amp; A</a></li>
   </ul>';

   if(!isset($_SESSION['user'])) { echo '
   <form class="navbar-form navbar-right" method="post">
     <div class="form-group">
       <input type="text" name="user" placeholder="Username" class="form-control" style="width:150px">
     </div>
     <div class="form-group">
       <input type="password" name="pass" placeholder="Password" class="form-control" style="width:150px">
     </div>
     <button type="submit" formaction="/login.php" class="btn btn-primary">Sign in</button>
     <button type="submit" formaction="/signup.php" class="btn btn-default">Sign up</button>
   </form>';
   } else { echo '
     <ul class="nav navbar-nav navbar-right">';
   }

   $name = "";
   if(has_rights_of($RANK_NORMAL)) $name = "Settings";
   if(has_rights_of($RANK_WRITER)) $name = "Admin Tools";

   if(has_rights_of($RANK_NORMAL)){ echo '
     <li class="divider visible-sm visible-xs"></li>
     <li><a href="/adm/index.php"><span class="glyphicon glyphicon-cog" style="padding-right:5px;"></span>'.$name.'</a></li>
   '; }

   if(isset($_SESSION['user'])){ echo '
     <li class="divider visible-sm visible-xs"></li>
     <li class="nav navbar-right"><a href="/logout.php">
       <span class="glyphicon glyphicon-log-out" style="padding-right:5px;"></span>
       Logout '.$_SESSION['user'].'</a>
     </li>
   </ul>
   </div>
   '; }
}

?>