<?php
 session_start();
 if( isset($_SESSION['users'])!="" ){
  header("Location: list.php");
 }
 include_once 'dbconnect.php';

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
 
 $error = 0;

 if ( isset($_POST['btn-signup']) ) {
  
  $forename = trim($_POST['forename']);
  $forename = strip_tags($forename);
  $forename = htmlspecialchars($forename);
  
  $surname = trim($_POST['surname']);
  $surname = strip_tags($surname);
  $surname = htmlspecialchars($surname);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  $userid = trim($_POST['userid']);
  $userid = strip_tags($userid);
  $userid = htmlspecialchars($userid);
  
  if (empty($forename)) {
	$error = 1;
    $forenameError = "*First Name is required";
  } 
  if (empty($surname)) {
	     $error = 1;
    $surnameError = "*Last Name is required";
  }
  
  
  if ( empty($userid) ) {
   $error = 1;
   $useridError = "*userid is required.";
  } else {
   $query = "SELECT username FROM users WHERE username = '$userid'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = 1;
    $useridError = "*Provided userid is already in use.";
   }
  }
 if (empty($pass)){
   $error = 1;
   $passError = "*Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = 1;
   $passError = "*Password must have atleast 6 characters.";
  }
  
  $password = hash('sha256', $pass);
  
  if( $error== 0 ) {
   
   $query = "insert into users (forename, surname, username, password) values('$forename', '$surname', '$userid', '$password')";
   $res = mysql_query($query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($forename);
    unset($surname);    
    unset($userid);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
 }
?>
<html>
<head>
<title>Registration</title>
</head>
<body>
<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    
     <div style = "text-align:center"class="col-md-12">
        
         <div class="form-group">
             <h2 class="" style = "text-align:center">Sign Up.</h2>
            </div>
        
            
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
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            
			<input type="text" name="forename" class="form-control" placeholder="Enter your First Name" maxlength="50" value="<?php echo $forename ?>" />
		    </div>
                <span class="text-danger"><?php echo $forenameError; ?></span>
            </div>
            
			<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            
				<input type="text" name="surname" class="form-control" placeholder="Enter your Last Name" maxlength="50" value="<?php echo $surname ?>" />
			</div>		
			<span class="text-danger"><?php echo $surnameError; ?></span>
				</div>
				
			
			<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            
			<input type="text" name="userid" class="form-control" placeholder="Enter your userid" maxlength="50" value="<?php echo $userid ?>" />
             </div><span class="text-danger"><?php echo $useridError; ?></span>
           </div>
		   
		   <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
            </div> <span class="text-danger"><?php echo $passError; ?></span>
            </div>
			
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            
            <div class="form-group">
             <a href="index.php">Sign in Here</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
