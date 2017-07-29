<html>
	<head>
		<script src="../js/province_ajax.js"></script>
	</head>
	<body>
		Province: 	<select name="province" id="province" onchange='call_ajax();'>
						<option value=""></option>
							<?php
								ini_set('display_errors', 1);
								error_reporting(E_ALL|E_STRICT);
								require_once 'login.php';
								$conn = new mysqli($hn, $un, $pw, $db);
								if($conn->connect_error){
									die("Connection failed: ". $conn->connect_error);
								}
								
								$query = "SELECT name FROM provinces";
								$result = $conn->query($query);

								$num_rows = $result->num_rows;
								for($x=0; $x<$num_rows; ++$x){
									$result->data_seek($x);
									$record = $result->fetch_array(MYSQLI_NUM);
									echo "<option value=\"".$record[0]."\">".$record[0]."</option>";
								}
								$conn->close();
									
							?>
					</select>
			<br>
			City:	<select id="city_ajax">
						<option value=""></option>
					</select>
		
	</body>
</html>