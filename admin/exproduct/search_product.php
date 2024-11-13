<?php 
	include("../../connection.php");
	$code = $_POST['txtcode'];
	$sql = "SELECT * FROM products WHERE code='".$code."' limit 1";
	$result = $conn->query($sql);

	if($result->num_rows > 0){

		$row = $result->fetch_object();

		$proid = $row->proid;
		$proname = $row->proname;
		$price = $row->price;	
		$code = $row->code;
		$picture = $row->picture;
		$str = "$proid;$proname;$price;$code;$picture";	
		echo $str;	
		
	}else{
		echo 0;
	}

?>