<?php
	require ('./dbConnector.php');
	
	$query = "SELECT Latitudine, Longitudine FROM impianti";
	$rs = sendQuery($query);
	$array = array();
	
	if($rs->num_rows > 0){
		while($row = $rs->fetch_assoc()){
			array_push($array, $row);
		}
		echo json_encode($array);
	}

?>