<?php


require_once'checkSession.php';


 $conn = new mysqli('localhost','root','','homework');

 if ($conn->connect_error) die($conn->connect_error);
	

if(isset($_POST['delete']) && isset($_POST['name'])) {
	$name=get_post($conn, 'name');
	$query="DELETE FROM movie WHERE id='$name'";
	$result=$conn->query($query);
	if(!$result) echo "DELETE failed <br>" .
	$conn->error . "<br><br>";
	
	echo <<<_END
	<pre>Movie deleted successfully</pre>
	</br></br>
	<a href = "list.php">Home</a>
	<a href = "logout.php">LogOut</a>
	
_END;
}

//$result->close();
$conn->close();

function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}


?>