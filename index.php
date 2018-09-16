<?php
session_start();
if (!isset($_SESSION["login"])){
  header("Location: logowanie.php");
 exit();
}
?>
<html>
<head>
  <title>Katalog</title>
  <style>
  body{
	  background-color:#123456;
	  padding-left:8%;
  }
  .books{
	  width:500px;
	  height:100px;
	  background-color:#198456;
	  margin:10px;
	  text-align:center;
	  float:left;
	  border-radius:10px;
  }
  #footer{
	  width:250px;
	  height:160px;
	  background-color:#191256;
	  position:absolute;
	  bottom:2%;
	  left:40%;
	  text-align:center;
	  float:left;
	  border-radius:10px;
  }
  #log{
	  width:160px;
	  height:80px;
	  background-color:#191256;
	  font-size:23px;
	  text-align:center;
	  border-radius:10px;
  }

  </style>
</head>
<body>
<?php
  echo "<div id='log'>Witaj " . $_SESSION["login"] . "<br>";
  echo "<a href='logowanie.php?" . SID . "'>";
  echo "Wyloguj</a>";
  echo "</br></div>";
  $conn=mysqli_connect("localhost", "root", "", "ksiazki");

  $result = mysqli_query($conn,"SELECT * FROM `baza`");
  while( $row = mysqli_fetch_assoc($result) )
	{	
		echo "<div class='books'<br><b>" . $row['nazwa'] . "</b> - <i>". $row['autor'] ."</i><br/>" . $row['opis'] . "<br/>Wstawione przez: <strong>".$row['owner']."</strong><br/>";
		if($row['owner'] == $_SESSION['login']){
			echo "<form method='POST'>
				  <input type='hidden' name='val' value='". $row['id'] ."'>
			      <input type='submit' name='edit' value='edytuj'>
				  <input type='submit' name='delete' value='usuń'>
				  </form></div>";
		}else{echo "</div>";}
	}
?>  

<br/><br/>
<?php  

	if(isset($_POST['send'])){
		$nazwa = $_POST['nazwa'];
		$opis = $_POST['opis'];
		$autor = $_POST['autor'];
		$owner = $_SESSION['login'];
		if($nazwa != null && $nazwa != " " && $autor != null && $autor != " "&& $opis != null && $opis != " "){
			mysqli_query($conn,"INSERT INTO `baza` (`nazwa`, `autor`, `opis`, `owner`) 
			VALUES ('$nazwa','$opis','$autor','$owner')");
			header("Refresh:0");
		}else{
			echo "<div style='position:absolute;top:2%;left:40%;font-size:23px;color:red;'>Nie edytowano tytułu</div>";
		}

		
	}

	if(isset($_POST['delete'])){
		mysqli_query($conn,"DELETE FROM `baza` WHERE id=".$_POST['val']);
		header("Refresh:0");
	}

	if(isset($_POST['edit'])){

		$result = mysqli_query($conn,"SELECT * FROM `baza` WHERE id=".$_POST['val']);
		$row = mysqli_fetch_assoc($result);

		echo
		"<form method='POST' id='footer'>
		<input type='hidden' name='val' value='".$_POST['val']."'>
		<div>Nazwa: <input type='text' name='nazwa' id='nazwa' value='". $row['nazwa'] ."'/></div>
		<br/>
		<div>Autor: <input type='text' name='autor' rows='4' cols='22' id='autor' value='". $row['autor'] ."'/></input></div>
		<br/>
		<div>Autor: <input type='text' name='opis' rows='4' cols='22' id='opis' value='". $row['opis'] ."'/></input></div>
		<br/>
		<input type='submit' name='update' value='edytuj'>
		<input type='submit' name='remove' value='anuluj'>
		</form>";

	}else{
		echo
		"<form method='POST' id='footer'>
		<br/>
		<div>Nazwa: <input type='text' name='nazwa' id='nazwa'/></div>
		<br/>
		<div>Autor: <input type='text' name='autor' rows='4' cols='22' id='autor'/></input></div>
		<br/>
		<div>Opis: <input type='text' name='opis' rows='4' cols='22' id='opis'/></input></div>
		<br/>
		<input type='submit' name='send'>
		</form>";
	}
  
  	if(isset($_POST['update'])){
		mysqli_query($conn,"UPDATE `baza` SET `nazwa`='". $_POST['nazwa'] ."',`autor`='". $_POST['autor'] ."',`opis`='". $_POST['opis'] ."' WHERE id=".$_POST['val']);
		header("Refresh:0");
  	}

  	if(isset($_POST['remove'])){
  		header("Refresh:0");
  	}
?>

</body>
</html>
