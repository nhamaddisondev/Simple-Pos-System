<?php
 	include("../header.php");
	include("../connection.php");

	$fdate = $_POST['fdate'];
	$tdate = $_POST['tdate'];
	$sluser = $_POST['user'];

	$sql ="";
	if($sluser==0){
		$sql = "SELECT * FROM orders WHERE ordered_date>=$fdate AND ordered_date<='".$tdate."'";
	}else{
		$sql = "SELECT * FROM orders WHERE ordered_date>=$fdate AND ordered_date<='".$tdate."' AND orderby='".$sluser."'";
	}

	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while ($row = $result->fetch_object()) {
			$orderid = $row->orderid;
			$ordered_date = $row->ordered_date;
			$orderby = $row->orderby;
			$total	 = $row->total;
			$discount	 = $row->discount;
			$grand_total	 = $row->grand_total;
			echo "<tr>
                <td>".$orderid."</td>
                <td>".$ordered_date."</td>
                <td>".$orderby."</td>
                <td>".$total."</td>
                <td>".$discount."</td>
                <td>".$grand_total."</td>
              </tr>";
		}
	}
	include("../footer.php");
?>