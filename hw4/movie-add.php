<?php
 require_once'checkSession.php';

 
 $conn = new mysqli('localhost','root','','homework');

 if ($conn->connect_error) die($conn->connect_error);
 
  $nameError = $sentimentsError = $genreError = $directorsError = $writersError = $castError = $releaseDateError = $countryError = $languageError = $runTimeError = $descriptionError = $storyLineError = "";
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

 if ( isset($_POST['btn-submit']) ) {
  
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
   
   $query = "insert into movie (name, genre, directors, writers, cast, releaseDate, country, language, runTime, description, storyLine, sentiments) 
   values('$name', '$genre', '$directors', '$writers', '$cast', '$releaseDate', '$country', '$language', '$runTime', '$description', '$storyLine','$sentiments')";
   $result=$conn->query($query);
		if(!$result) echo "INSERT failed: $query <br>" .
			$conn->error . "<br><br>";
	
    
   if ($result) {
    $errTyp = "success";
    $errMSG = "Movie Added";
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
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again.."; 
   } 
    
  }
  
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Movie</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div style = "text-align:center" class="container">
  <h2>Enter new movie details</h2>
  <h3 style = "text-align:right"><a href = "list.php">Home</a></br><a href ="logout.php?logout">Log out</a></h3>
  <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    
	 <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
     <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
   <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name: </label>
      <div class="col-sm-10">
        <input type="text" name = "name" class="form-control" id="name" placeholder="Enter Name">
      </div>
        <span class="text-danger"><?php echo $nameError; ?></span>

    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="genre">Genre: </label>
      <div class="col-sm-10">
        <input type="text" name = "genre" class="form-control" id="genre" placeholder="Enter Genre">
      </div>
        <span class="text-danger"><?php echo $genreError; ?></span>
 
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Directors: </label>
      <div class="col-sm-10">
        <input type="text" name = "directors" class="form-control" id="directors" placeholder="Enter Director's name">
      </div>
        <span class="text-danger"><?php echo $directorsError; ?></span>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Writers: </label>
      <div class="col-sm-10">
        <input type="text" name = "writers" class="form-control" id="Writers" placeholder="Enter Writer's name">
      </div>
        <span class="text-danger"><?php echo $writersError; ?></span>	  
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Cast: </label>
      <div class="col-sm-10">
        <input type="text" name = "cast" class="form-control" id="cast" placeholder="Enter Cast">
      </div>
        <span class="text-danger"><?php echo $castError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Release Date: </label>
      <div class="col-sm-10">
        <input type="text" name = "releaseDate" class="form-control" id="releaseDate" placeholder="Enter Release Date">
      </div>
        <span class="text-danger"><?php echo $releaseDateError; ?></span>
    </div>
	
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Country: </label>
      <div class="col-sm-10">
        <input type="country" name = "country" class="form-control" id="country" placeholder="Enter Country">
      </div>
        <span class="text-danger"><?php echo $countryError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Language: </label>
      <div class="col-sm-10">
        <input type="text" name = "language" class="form-control" id="language" placeholder="Enter Language">
      </div>
        <span class="text-danger"><?php echo $languageError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Run time: </label>
      <div class="col-sm-10">
        <input type="text" name = "runTime" class="form-control" id="runtime" placeholder="Enter Runtime">
      </div>
        <span class="text-danger"><?php echo $runTimeError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Sentiments: </label>
      <div class="col-sm-10">
        <input type="text" name = "sentiments" class="form-control" id="sentiments" placeholder="Enter sentiments">
      </div>
        <span class="text-danger"> <?php echo $sentimentsError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Description: </label>
      <div class="col-sm-10">
        <input type="text" name = "description" class="form-control" id="description" placeholder="Enter Description">
      </div>
        <span class="text-danger"><?php echo $descriptionError; ?></span>
    </div>
    
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Story Line: </label>
      <div class="col-sm-10">
        <input type="text" name = "storyLine" class="form-control" id="storyLine" placeholder="Enter Story Line">
      </div>
        <span class="text-danger"><?php echo $storyLineError; ?></span>
    </div>
    
	<div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="btn-submit">Submit</button>
		<button type="reset" class="btn btn-default">Reset</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
