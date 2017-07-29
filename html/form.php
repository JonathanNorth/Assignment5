<?php
echo <<<_END
<html>  <head> <link href="../css/form.css" type="text/css" rel="stylesheet" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head> <body>
<form action="authenticate2.php" method="post">
  <label for="userid">ID</label>
  <input type="text" name="userid" id="userid" />
  <br />
  <label for="password">Password</label>
  <input type="password" name="password" id="password" />
  <br />
  <input type="submit" name="submit" value="login" />
</form>
<form action="sectiona.php">
  <input type="submit" name="submit" value="register" />
</form>
<body>
_END;
?>