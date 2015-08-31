<?php 
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include("includes/config.php");  

function NewUser() {
					$uname = mysql_real_escape_string($_POST['uname']);
					$email = mysql_real_escape_string($_POST['email']);
					$upass = md5(mysql_real_escape_string($_POST['pass']));
					$query = "INSERT INTO tbl_users(username,email,password) VALUES ('$uname','$email','$upass')"; 
					$data = mysql_query ($query)or die(mysql_error()); 
					if($data) {
								/*echo "YOUR REGISTRATION IS COMPLETED..."; */
								} 
					} 
function SignUp() {
						if(!empty($_POST['uname'])) 
						//checking the 'user' name which is from Sign-Up.html, is it empty or have some text 
						{ 
							$query = mysql_query("SELECT * FROM tbl_users WHERE username = '$_POST[uname]' AND password = '$_POST[pass]'") or die(mysql_error()); 
							if(!$row = mysql_fetch_array($query) or die(mysql_error())) 
							{ 
								newuser(); 
							} 
							else 
							{ 
								/*echo "SORRY...YOU ARE ALREADY REGISTERED USER..."; */
							} 
						} 
					} 
if(isset($_POST['submit'])) 
{ 
SignUp(); 
} 

?>
