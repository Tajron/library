<?php

if (isset($_POST['login']) && isset($_POST['haslo'])){
  $conn=mysqli_connect("localhost", "root", "", "ksiazki");
  $login=htmlentities($_POST['login']);
  $haslo=htmlentities($_POST['haslo']);
  $rs=mysqli_query($conn,"SELECT Count(id) FROM logowanie WHERE login='$login'
   AND haslo=sha1('$haslo')");
	$rec=mysqli_fetch_array($rs);
  if ($rec[0]>0){
    session_start();
	$_SESSION['login']=$_POST['login'];
    header("Location: index.php?" . SID);
    exit();
  } else
    $error = "<b>Spróbuj ponownie!</b><br>";
} else
  $error = false;
?>
<html>
<head>
  <title>Logowanie</title>
  <style>
  body{
	  background-color:#123456;
  }
  #main{
	  background-color:#198456;
	  width:200px;
	  height:220px;
	  margin:150px auto;
	  text-align:center;
	  font-size:21px;+
	  border-radius:10px;
  }
  </style>
</head>
<body >
<div id="main">
  <b>Zaloguj się !</b>
  <form method="POST" >
    Login: <input type="text" name="login"><br/>
    Hasło: <input type="password" name="haslo"><br/>
	<br/>
    <input type="submit" value="Zaloguj się">
  </form>
  <?php
  echo $error ? $error : "";
	?>
</body>
</html> 