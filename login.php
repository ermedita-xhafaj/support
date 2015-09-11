<?php
define('IN_SCRIPT',1);
define('HESK_PATH','./');
include("inc/database.inc.php");
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/admin_functions.inc.php');
/*echo "Po lidhemi me databazen <br/>";*/
session_start();
hesk_dbConnect();


 $myuser = addslashes($_POST['user']);
 $mypassword = hesk_Pass2Hash(addslashes($_POST['pass']));
 $msg ='';
 if(isset($myuser, $mypassword))
 {
	//email and password sent from form
	
	
	 $myuser = stripslashes($myuser);
	 $mypassword = stripslashes($mypassword);
	
	 $myuser = mysql_real_escape_string($myuser);
	 $mypassword = mysql_real_escape_string($mypassword);

	 $result = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."clients` WHERE `user` = '".hesk_dbEscape($myuser) ."' AND `pass` = '".hesk_dbEscape($mypassword) ."' LIMIT 1");
	 $id = mysql_fetch_assoc($result);
	 $count = mysql_num_rows($result);
	
	//If result matched $myemail and $mypassword, table row must be 1 row
	 if($count==1)
	 {
			 if($id['active']=='0'){
				 $msg = "Your account is currently deactivated. Please contact administrator!";
				 $_SESSION['message'] = $msg;
				 header("location:http://localhost/support/");
			 }
			 else{
				 session_start();
				 $_SESSION['loggedin'] = true;
				 $_SESSION['user'] = $myuser;
				 $_SESSION['id'] = $id;
				 header("location:http://localhost/support/");
			 }
	 }
	 else{
		 session_start();
		 $msg = "Wrong Username or Password. Please try again!";
		 $_SESSION['message'] = $msg;
		 header("location:http://localhost/support/");
	 }
 }
	else {
		 header("location:http://localhost/support/msg=Please enter some username and password");
	 }
 hesk_dbClose();
 ?>

