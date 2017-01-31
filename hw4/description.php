<?php

require_once'checkSession.php';

 $conn = new mysqli('localhost','root','','homework');

 if ($conn->connect_error) die($conn->connect_error);
	
	
	
function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}


if(isset($_POST['description']) && isset($_POST['name'])) {
	$name=get_post($conn, 'name');
	$query="select * FROM movie WHERE id='$name'";
	$result=$conn->query($query);
	if(!$result) echo " failed <br>" .
	$conn->error . "<br><br>";
		

	$rows=$result->num_rows;
	for($j=0; $j<$rows; $j++) {
	$result->data_seek($j);
	$row=$result->fetch_array(MYSQLI_NUM);
	
	?>
	
	<html>
<title><?php  echo $row[0]; ?></title>
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

<div class="w3-container w3-teal">
  <h1><?php echo $row[0] ?>
</h1>
</div>

<body>

	<div class="w3-container ">
   <button class="w3-btn w3-ripple w3-right"><a href="list.php">Home</a></button>
   <button class="w3-btn w3-ripple w3-right"><a href="logout.php?logout"> Logout</a>
</div>
	<div class=" w3-container">

	<?php
	
	echo <<<_END
	
	

		
		<div style = "text-align:center"class="w3-quarter w3-container"><p>
		<p><h3><strong><u>Genre</u></strong></h3></p>
			<p>

			$row[1]

			
			</p></p>
			<br>
			<p><h3><strong><u>Cast</u></strong></h3></p>
			<p> $row[4]
			</p></p>
				
		</div>
			
	<div style = "text-align:center"class="w3-quarter w3-container"><p>
		<p><h3><strong><u>Writers</u></strong></h3></p>
			<p>$row[3]</p></p>
			<br>
		<p><h3><strong><u>Country</u></strong></h3></p>
			<p>$row[6]</p></p>

			</div>
			
	<div style = "text-align:center" class="w3-quarter w3-container"><p>
		<p><h3><strong><u>Directors</u></strong></h3></p>
			<p>$row[2]
			<br>
			<br><br>
			</p></p>
			<p><h3><strong><u>Language</u></strong></h3></p>
			<p>$row[7]</p></p>
</div>
			
	<div style = "text-align:center" class="w3-quarter w3-container"><p>
		<p><h3><strong><u>Release Date</u></strong></h3></p>
			<p>$row[5]
			<br><br><br>
			</p></p>
			<p><h3><strong><u>Run time</u></strong></h3></p>
			<p>$row[8]</p></p>
<br><br><br><br><br><br>
	</div>
	
	<div style = "text-align:center"><h3><strong><u>Sentiments:</u></strong></h3></p>
			<p>$row[12]
			<br><br><br>
			</p></p>
	</div>
	  <p><h2 style = "text-align:center"><strong><u>Story Line</u></strong></h2></p>
		<p style = "text-align:justify">
			$row[10]
		</p>
		
		
		
	
	
_END;
}

}

//$result->close();
$conn->close();


?>
	</div>

</body>
	</html>