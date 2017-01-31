<?php
 session_start();
 require_once 'dbconnect.php';
 
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: list.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
  $userid = trim($_POST['userid']);
  $userid = strip_tags($userid);
  $userid = htmlspecialchars($userid);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  if(empty($userid)){
   $error = true;
   $useridError = "Please enter your userid.";
  }
  
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  if (!$error) {
   
   $password = hash('sha256', $pass);   
   $res = mysql_query("SELECT forename, surname, username, password FROM users WHERE username='$userid'");
   $row = mysql_fetch_array($res);
   $count = mysql_num_rows($res); 
   
   if( $count == 1 && $row['password']==$password ) {
    $_SESSION['user'] = $row['username'];
    header("Location: list.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }
    
  }
  
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12" style = "text-align:center">
        
         <div class="form-group">
             <h2 class="" style = "text-align:center">Sign In</h2>
            </div>
        
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="userid" name="userid" class="form-control" placeholder="Your userid" value="<?php echo $userid; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $useridError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            
            <div class="form-group">
             <a href="register.php">Sign Up Here</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
