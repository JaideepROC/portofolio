<?php
include('connection.php');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <form name="form" action="login2.php" method="post">
<label for>username</label>
<input type="text" id='user' name='user'><br>
<br>
<label for>paspoort</label>
<input type="password"  id='pass' name='pass'>
<input type="submit" id='btn' value="login" name='submit'>
</form>

  </body>
</html>
