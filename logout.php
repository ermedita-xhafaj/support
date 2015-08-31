<?php 
session_start();
if(session_destroy())
{
header("location:http://localhost/support/?msg=Successfully Logged out");
}
exit();
?>