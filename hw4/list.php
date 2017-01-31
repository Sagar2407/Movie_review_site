<?php

require_once'checkSession.php';

 $conn = new mysqli('localhost','root','','homework');

 if ($conn->connect_error) die($conn->connect_error);
	
 
 function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}

?>
<html>
<title>Homepage</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
<head>
<style>
#grad1 {
    height: 3px;
    background: linear-gradient(to left, rgba(0,0,0,0), rgba(0,0,0,1)); 
}
</style>
</head>

<body>

<div class="w3-container ">
   <div class=" w3-center w3-serif"><h2><strong>MOVIE LIST</strong></h2></div>
   <button class="w3-btn w3-ripple w3-right"><a href="movie-add.php">Add Movie</a></button>
   <button class="w3-btn w3-ripple w3-right"><a href="logout.php?logout"> Logout</a>
</div>
<br>
<br>

<?php
$query="SELECT * FROM movie";
$result=$conn->query($query);
if(!$result) die ($conn->error);

$rows=$result->num_rows;
for($j=0; $j<$rows; $j++) {
	$result->data_seek($j);
	$row=$result->fetch_array(MYSQLI_NUM);
	
	echo <<<_END
	<div class=" w3-container ">
	<h2 style = "text-align:center"><strong>$row[0]</strong></h2>
	<p>$row[9]</p>
	<br>
	<p><strong>Director:</strong> $row[2]</p>
	<p><strong>Sentiments:</strong> $row[12]</p>
	<p><strong>Writers:</strong>  $row[3]</p>
	<p><strong>Cast:</strong> $row[4] </p> 
	<div style = "text-align:center">
	<br>
	<br>
	<br>
	<form action="description.php" method="post">
	<input type="hidden" name="description" value="yes">
	<input type="hidden" name="name" value="$row[11]">
	<input class="w3-btn" type="submit" value="DESCRIPTION">
	</form>
	
	<form action="movie-update.php" method="post">
	<input type="hidden" name="update" value="yes">
	<input type="hidden" name="name" value="$row[0]">
	<input class="w3-btn" type="submit" value="UPDATE RECORD">
	</form>
	<form action="deletemovie.php" method="post">
	<input type="hidden" name="delete" value="yes">
	<input type="hidden" name="name" value="$row[11]">
	<input class="w3-btn" type="submit" value="DELETE RECORD"></br>
	</br>
	</form>
	</div>
</div>

	</body>
	</html>
_END;
}

$result->close();
$conn->close();



?>