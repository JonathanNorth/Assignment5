<html>
<head>
     <title>sectiona.php</title>
</head>

<?php

	require_once 'login.php';
	$conn = new mysqli($hn,$un,$pw,$db);

	if(isset($_POST['fname']) && !empty($_POST['fname']) &&
	   isset($_POST['lname']) && !empty($_POST['lname']) &&
	   isset($_POST['email']) && !empty($_POST['email']) &&
	   isset($_POST['password']) && !empty($_POST['password']))
	{
		
		$fname_temp 		= mysql_entities_fix_string($conn, 'fname');
		$lname_temp 		= mysql_entities_fix_string($conn, 'lname');
		$user_type_temp		= $_POST['user_type'];
		$email_temp 		= $_POST['email'];
		$password_temp	 	= mysql_entities_fix_string($conn, 'password');
		
		
		
		/*Need to convert the user_type from the drop down list to the $user_code specified in the User_codes table
		* therefore if any data is entered into the User_codes data we need to enter it here as well
		*/
		if(strcmp($user_type_temp,"user") == 0){
			$user_code = 1;
		}
		else{
			$user_code = 2;
		}
		
		$salt1 = "aW@sl!";
		$salt2 = "[p234;;1";
		$token_fname 		= hash('ripemd128',"$salt1$fname_temp$salt2");
		$token_lname 		= hash('ripemd128',"$salt1$lname_temp$sale2");
		$token_email		= hash('ripemd128',"$salt1$email_temp$salt2");
		$token_password		= hash('ripemd128',"$salt1$password_temp$salt2");
		
		/*Inserting record using place holders*/
		$query = "INSERT INTO `user_profiles`(`fname`,`lname`,`usercode`,`email`,`password`) VALUES (?,?,?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sssss",$token_fname,$token_lname,$user_code,$token_email,$token_password);
		
		if(!$stmt->execute()){
			echo $stmt->error;
		}
		else{
			echo "INSERT Successfull";
		}
				
		$stmt->close();
	}

/*Adding the html code for the form*/
echo <<<_END
   <body>
	<form action="sectiona.php" method="post">
		<label for="fname">First Name:</label><input type="text" name="fname" id="fname"><br>
		<label for="lname">Last Name:</label><input type="text" name="lname" id="lname"><br>
		<label for="user_type">User Type:</label>
			<select name="user_type" id="user_type">
_END;


//Printing options for user type from the User_codes table
$sql = "SELECT user_description FROM User_codes";
$result = $conn->query($sql);

if(!$result) die ($conn->error);
$rows = $result->num_rows;

for($j = 0; $j < $rows; ++$j){
	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_NUM);
	echo<<<_END
	<option value='$row[0]'>$row[0]</option>	
_END;
}

$conn->close();

echo <<<_END

	</select><br>
	<label for="email">Email:</label><input type="text" name="email" id="email"><br>
	<label for="password">Password:</label><input type="text" name="password" id="password"><br>
	<input type="submit" value="Submit">
	</form>


</body>
_END;

	$result->close();
	$conn->close();

	/*takes the db connection and a variable name from the html form and runs it through the real_escape_string function
	to elminate un-needed characters. Returns the value of the new string*/
	function mysql_entities_fix_string($conn, $var){
		
		if(get_magic_quotes_gpc()) $var = stripslashes($_POST['$var']);
		else return $conn->real_escape_string($var);
		return htmlentities($conn->real_escape_string($var));
	}

?>
</html>
