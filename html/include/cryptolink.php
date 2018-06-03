<?php

class CryptoLink{
	private $mysql_link;
	private $table;
	
	public function __construct($database, $table, $user, $pass, $port = 3306, $hostname = "localhost") {
		$con = mysqli_connect($hostname, $user, $pass, $database, $port);
		if(!$con) {
			die("Connection failure: ".mysqli_connect_error() . PHP_EOL);
		}
		$this->mysql_link = $con;
		$this->table = $table;
	}
	public function addrequ($amount, $notes){ global $table;
		$query = "INSERT INTO $table (amount, code, notes, filled, txid) VALUES ('$amount', '-1', '$notes', '0', '')";
		$result = mysqli_query($this->mysql_link, $query) or die("Error: ".mysqli_error($this->mysql_link));
		$newID = mysqli_insert_id($this->mysql_link);
		return "ID:$newID";
	}
	public function chkpin($id){ global $table;
		$query = "SELECT code FROM $table WHERE id='$id'";
		$result = mysqli_query($this->mysql_link, $query) or die("Error: ".mysqli_error($this->mysql_link));
		$array = $result->fetch_assoc();
		return "Code:".$array['code'].":$id";
	}
	public function chkpay($id){ global $table;
		$query = "SELECT filled, confirms FROM $table WHERE id='$id'";
		$result = mysqli_query($this->mysql_link, $query) or die("Error: ".mysqli_error($this->mysql_link));
		$array = $result->fetch_assoc();
		return "Filled:".$array['filled'].":Confirms:".$array['confirms'];
	}
	public function grabvar($varname){
		$query = "SELECT `value` FROM `count_vars` WHERE name='$varname'";
        $result = mysqli_query($this->mysql_link, $query) or die("Error: ".mysqli_error($this->mysql_link));
		$array = $result->fetch_assoc();
		return "Value:".$array['value'];
	}
	public function cancel($id){ global $table;
		$query = "UPDATE $table SET filled='-1' WHERE id='$id'";
		$result = mysqli_query($this->mysql_link, $query) or die("Error: ".mysqli_error($this->mysql_link));
		return "ID:$id";
	}
	public function __destruct(){
		mysqli_close($this->mysql_link);
	}
}

?>