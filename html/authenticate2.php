<?php // authenticate2.php
  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error) die($connection->connect_error);

  $rec_un = $_REQUEST['userid'];
  $rec_pw = $_REQUEST['password'];

 
if (isset($_REQUEST['userid']) &&
      isset($_REQUEST['password']))
{  
    $un_temp = mysql_entities_fix_string($connection, $rec_un);
    $pw_temp = mysql_entities_fix_string($connection, $rec_pw);

	$query = "SELECT * FROM user_profiles WHERE email ='$un_temp'";
        
 $result = $connection->query($query);


    if (!$result) die($ection->error);
	elseif ($result->num_rows)
	{

		$row = $result->fetch_array(MYSQLI_NUM);

                    
		$result->close();

		$salt1 = "qm&h*";
		$salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");
		  echo $token;
                  echo '<br>'.row[5];

		if ($token == $row[5]) 
		{
			session_start();
			$_SESSION['username'] = $un_temp;
			$_SESSION['password'] = $pw_temp;
			$_SESSION['fname'] = $row[0];
			$_SESSION['lname']  = $row[1];
			echo "$row[0] $row[1] : Hi $row[0],
				you are now logged in as '$row[5]'";
                        header('Location:continue.php');
          
			//die ("<p><a href='continue.php'>Click here to continue</a></p>");
		}

		else echo "Invalid combo";//die("Invalid username/password combination");

	}
	else echo "invalid combo";//die("Invalid username/password combination");
  
}
  else
  {
header('Location:form.php');    
  
  $connection->close();

}
  function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }
?>
