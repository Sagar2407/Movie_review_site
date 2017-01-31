<?php

require_once'checkSession.php';

 $conn = new mysqli('localhost','root','','homework');

 if ($conn->connect_error) die($conn->connect_error);

 $nameError = $sentimentsError = $genreError = $directorsError = $writersError = $castError = $releaseDateError = $countryError = $languageError = $runTimeError = $descriptionError = $storyLineError = " ";
 $error = 0;
function get_post($conn, $var) {
	return $conn->real_escape_string($_POST[$var]);
}

function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}	

function sanitizeMySQL($conn, $var)
	{
		$var = $conn->real_escape_string($var);
		$var = sanitizeString($var);
		return $var;
	}
?>

<?php if(isset($_POST['change']) && isset($_POST['id'])) {
  
  $id= $_POST['id'];
  
  $name = get_post($conn,'name');
  $name = sanitizeMySQL($conn, $name);
  
   $genre = get_post($conn, 'genre');
  $genre = sanitizeMySQL($conn, $genre);
  
  $directors = get_post($conn,'directors');
  $directors = sanitizeMySQL($conn, $directors);
  
  $writers = get_post($conn,'writers');
  $writers = sanitizeMySQL($conn, $writers);
  
  $cast = get_post($conn,'cast');
  $cast = sanitizeMySQL($conn, $cast);
  
  $releaseDate = get_post($conn,'releaseDate');
  $releaseDate = sanitizeMySQL($conn, $releaseDate);
  
  $country = get_post($conn,'country');
  $country = sanitizeMySQL($conn, $country);
  
  $language = get_post($conn,'language');
  $language = sanitizeMySQL($conn, $language);
  
  $runTime = get_post($conn,'runTime');
  $runTime = sanitizeMySQL($conn, $runTime);
  
  $description = get_post($conn,'description');
  $description = sanitizeMySQL($conn, $description);
  
  $storyLine = get_post($conn,'storyLine');
  $storyLine = sanitizeMySQL($conn, $storyLine);
  
  $sentiments = get_post($conn,'sentiments');
  $sentiments = sanitizeMySQL($conn, $sentiments);
  
  if (empty($name)) {
	$error = 1;
    $nameError = "*Name of the movie is required";
  } 
  if (empty($genre)) {
	     $error = 1;
    $genreError = "*genre is required";
  }
  
  if (empty($directors)) {
	     $error = 1;
    $directorsError = "* Directors name is required";
  }
    if (empty($writers)) {
	     $error = 1;
    $writersError = "* Writers name is required";
  }
    if (empty($cast)) {
	     $error = 1;
    $castError = "* cast is required";
  }
    if (empty($releaseDate)) {
	     $error = 1;
    $releaseDateError = "* Release Date is required";
  }
    if (empty($country)) {
	     $error = 1;
    $countryError = "* Country is required";
  }
    if (empty($language)) {
	     $error = 1;
    $languageError = "* Language is required";
  }
    if (empty($runTime)) {
	     $error = 1;
    $runTimeError = "* Run Time is required";
  }
    if (empty($description)) {
	     $error = 1;
    $descriptionError = "* Description is required";
  }
    if (empty($storyLine)) {
	     $error = 1;
    $storyLineError = "* Story Line is required";
  }
    if (empty($sentiments)) {
	     $error = 1;
    $sentimentsError = "* Sentiments is required";
  }
  
  
  if( $error== 0 ) {
	  
   
   $query = "update movie set name = '$name', genre = '$genre', directors = '$directors', writers = '$writers', cast = '$cast', releaseDate = '$releaseDate',
   country = '$country', language = '$language', runTime = '$runTime', description = '$description', storyLine = '$storyLine', sentiments = '$sentiments' where id = '$id' ";
	$result=$conn->query($query);
		if(!$result) echo "UPDATE failed: $query <br>" .
			$conn->error . "<br><br>";
		if($result){
			
	echo <<<_End
			  <h3 style = "text-align:right"><a href = "list.php">Home</a></br><a href ="logout.php?logout">Log out</a></h3>
				Movie updated successfully
_End;

		} 
		    
   if ($result) {
    $errTyp = "success";
    $errMSG = "Movie Updated";
    unset($name);
    unset($genre);    
    unset($directors);
    unset($writers);
    unset($cast);
    unset($releaseDate);
    unset($country);
    unset($language);
    unset($runTime);
    unset($description);
    unset($storyLine);
    unset($sentiments);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again.."; 
   } 
    
  }
  
 }
?>


<html lang="en">
<head>
  <title>Update Movie</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


<?php 
  if(isset($_POST['update']) && isset($_POST['name'])) {
    	$name = get_post($conn, 'name');

	$query= "select *
			from movie
			where name='$name'";
			$result = $conn->query($query);
			
			if(!$result) die($conn->error);
			else{
			$row = $result->fetch_array(MYSQLI_NUM);

	echo <<<_End
<div style = "text-align:center" class="container">
  <h2>Enter updated movie details for  $row[0] </h2>
  <h3 style = "text-align:right"><a href = "list.php">Home</a></br><a href ="logout.php?logout">Log out</a></h3>
 </div>
  <form method="post" class="form-horizontal" action="movie-update.php">
   <div> 
	 
   
   
   <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name: </label>
      <div class="col-sm-10">
        <input type="text" name = "name" class="form-control" id="name" placeholder="Enter Name" value = "$row[0]">
      </div>
        <span class="text-danger"> <?php echo $nameError; ?></span>
 
    </div>
    
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Genre: </label>
      <div class="col-sm-10">
        <input type="text" name = "genre" class="form-control" id="genre" placeholder="Enter Genre" value = "$row[1]">
      </div>
        <span class="text-danger"> <?php echo $genreError; ?></span>
 
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Directors: </label>
      <div class="col-sm-10">
        <input type="text" name = "directors" class="form-control" id="directors" placeholder="Enter Director's name" value = "$row[2]">
      </div>
        <span class="text-danger"> <?php echo $directorsError; ?></span>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Writers: </label>
      <div class="col-sm-10">
        <input type="text" name = "writers" class="form-control" id="Writers" placeholder="Enter Writer's name" value = "$row[3]">
      </div>
        <span class="text-danger"> <?php echo $writersError; ?></span>	  
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Cast: </label>
      <div class="col-sm-10">
        <input type="text" name = "cast" class="form-control" id="cast" placeholder="Enter Cast" value = "$row[4]">
      </div>
        <span class="text-danger"> <?php echo $castError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Release Date: </label>
      <div class="col-sm-10">
        <input type="text" name = "releaseDate" class="form-control" id="releaseDate" placeholder="Enter Release Date" value = "$row[5]">
      </div>
        <span class="text-danger"> <?php echo $releaseDateError; ?></span>
    </div>
	
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Country: </label>
      <div class="col-sm-10">
        <input type="country" name = "country" class="form-control" id="country" placeholder="Enter Country" value = "$row[6]">
      </div>
        <span class="text-danger"> <?php echo $countryError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Language: </label>
      <div class="col-sm-10">
        <input type="text" name = "language" class="form-control" id="language" placeholder="Enter Language" value = "$row[7]">
      </div>
        <span class="text-danger"> <?php echo $languageError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Run time: </label>
      <div class="col-sm-10">
        <input type="text" name = "runTime" class="form-control" id="runtime" placeholder="Enter Runtime" value = "$row[8]">
      </div>
        <span class="text-danger"> <?php echo $runTimeError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Sentiments: </label>
      <div class="col-sm-10">
        <input type="text" name = "sentiments" class="form-control" id="sentiments" placeholder="Enter sentiments" value = "$row[12]">
      </div>
        <span class="text-danger"> <?php echo $sentimentsError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Description: </label>
      <div class="col-sm-10">
        <input type="text" name = "description" class="form-control" id="description" placeholder="Enter Description" value = "$row[9]">
      </div>
        <span class="text-danger"> <?php echo $descriptionError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Story Line: </label>
      <div class="col-sm-10">
        <input type="text" name = "storyLine" class="form-control" id="storyLine" placeholder="Enter Story Line" value = "$row[10]">
      </div>
        <span class="text-danger"> <?php echo $storyLineError; ?></span>
    </div>
    <input type="hidden" name="change" value="yes">
	  <input type="hidden" name="id" value="$row[11]">
	<div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
	  
        <button type="submit" class="btn btn-default"  value="change">Update</button>
		
      </div>
    </div>
	</div>
  </form>
_End;
			}
}
?>
</body>
</html>