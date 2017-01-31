<?php

 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 
 $conn = mysql_connect('localhost','root','root123');
 $dbcon = mysql_select_db('homework');
 
 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }
	
 if ( !$dbcon ) {
  die("Database Connection failed : " . mysql_error());
 }
 
 
 ?>