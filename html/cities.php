<?php
	require_once 'login.php';
	$provinceName = $_GET['province'];
	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) die ($conn->connect_error);
	
	$query = "SELECT cities.city FROM cities INNER JOIN provinces ON UPPER(provinces.name)=UPPER('$provinceName') AND provinces.id=cities.prov_id";
	$result = $conn->query($query);
	if(!$result) die ($conn->error);

	$num_rows = $result->num_rows;
	for($x=0; $x<$num_rows; ++$x){
		$result->data_seek($x);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo "<option value=\"".$row['city']."\">".$row['city']."</option>";
	}
	
	$conn->close();
?>